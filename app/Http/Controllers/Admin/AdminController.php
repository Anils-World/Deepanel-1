<?php

namespace App\Http\Controllers\Admin;

use Photo;
use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Product;
use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        return view('backend.index');
    }

    public function dashboard()
    {
        $order = Order::count();

        $pendingOrder = Order::where('order_status', 'pending')->orderBy('id', 'DESC')->take(10)->get();

        $totalProduct = Product::count();
        $totalSale = Order::where('order_status', 'delieverd')->sum('price');
        $thisMonthSales = Order::where('order_status', 'delieverd')
            ->whereMonth('created_at', Carbon::now()->month) // Filter by current month
            ->whereYear('created_at', Carbon::now()->year)  // Filter by current year
            ->sum('price');
        $cat = ProductCategory::all()->count();
        $camp = Campaign::all()->count();
        return view('backend.home.home', [
            'total_product' => $totalProduct,
            'total_price'   => $totalSale,
            'thisMonth'     => $thisMonthSales,
            'order_pending' => $pendingOrder,
            'total_cat'     => $cat,
            'order'         => $order,
            'camp'          => $camp,
            'chart'         => $this->chartMonth(),
            'chart2'        => $this->chart2(),
            'orders' => $pendingOrder
        ]);
    }
    function admin_login()
    {
        return view('backend.include.admin_login');
    }


    function adminlogin(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email' => 'required|max:255',
            'password' => 'required|min:8',
        ]);

        $credentials = $request->only('email', 'password');

        $remember = $request->has('remember'); // Check if remember me is checked

        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            return redirect()->route('dashboard');
        } else {
            return back()->withErrors([
                'email' => 'Invalid credentials.',
            ]);
        }
    }

    //Admin Link
    function admin_register()
    {
        $super_admin = Admin::count();

        if ($super_admin == 0 && !Auth::guard('admin')->check()) {
            return view('backend.include.admin_register', compact('super_admin'));
        } else {
            return redirect('/');
        }
    }
    //Admin Store
    function admin_store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'number' => 'required|max:11',
            'password' => 'required|min:8',
        ]);
        //Pure File //Path Name // Prefix for name // size alternative
        Photo::upload($request->profile, 'files/profile', 'adminProfile');

        Admin::insert([
            'name' => $request->name,
            'profile' => Photo::$name,
            'email' => $request->email,
            'number' => $request->number,
            'role' => $request->role,
            'password' => bcrypt($request->password),
        ]);
        $credentials =  $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()
                ->route('dashboard')
                ->with('Welcome! Your account has been successfully created!');
        }
    }

    // create admin for role
    function create_admin()
    {
        $super_admin = Admin::count();
        return view('backend.admin.create_admin', compact('super_admin'));
    }
    function create_role_admin(Request $request)
    {
        Photo::upload($request->profile, 'files/profile', $request->name);

        Admin::insert([
            'name' => $request->name,
            'profile' => Photo::$name,
            'email' => $request->email,
            'number' => $request->number,
            'role' => $request->role,
            'password' => bcrypt($request->password),
        ]);
        return back();
    }

    function admin_logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function chart()
    {
        // Get data for the last 30 days grouped by day and status
        $dailyData = Order::selectRaw('DATE(created_at) as date, order_status, COUNT(*) as total')
            ->whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()])
            ->groupBy('date', 'order_status')
            ->orderBy('date')
            ->get();

        // Initialize arrays
        $labels = [];
        $dataByDate = [];

        // Prepare the structure to store data
        foreach ($dailyData as $data) {
            $dateLabel = Carbon::parse($data->date)->format('Y-m-d');

            // Add date to labels if it's not already there
            if (!in_array($dateLabel, $labels)) {
                $labels[] = $dateLabel;
            }

            // Initialize the array if not already set
            if (!isset($dataByDate[$dateLabel])) {
                $dataByDate[$dateLabel] = [
                    'delivered' => 0,
                    'damage' => 0,
                    'cancel' => 0,
                ];
            }

            // Assign the counts to the correct status
            switch ($data->order_status) {
                case 'delieverd':
                    $dataByDate[$dateLabel]['delivered'] = $data->total;
                    break;
                case 'damage':
                    $dataByDate[$dateLabel]['damage'] = $data->total;
                    break;
                case 'cancel':
                    $dataByDate[$dateLabel]['cancel'] = $data->total;
                    break;
            }
        }

        // Now we need to build the data arrays for each status
        $deliveredData = [];
        $damageData = [];
        $cancelData = [];

        foreach ($labels as $date) {
            $deliveredData[] = $dataByDate[$date]['delivered'];
            $damageData[] = $dataByDate[$date]['damage'];
            $cancelData[] = $dataByDate[$date]['cancel'];
        }

        // Prepare the final chart data
        $chartData = [
            'labels' => $labels,
            'datasets' => [
                'delivered' => $deliveredData,
                'damage' => $damageData,
                'cancel' => $cancelData,
            ],
        ];
        return $chartData;
    }


    public function chartMonth()
    {
        // Get data for the last 12 months grouped by month and order status
        $monthlyData = Order::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, order_status, COUNT(*) as total')
            ->whereBetween('created_at', [Carbon::now()->subYear(), Carbon::now()]) // Get last 12 months
            ->groupBy('year', 'month', 'order_status')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Initialize arrays
        $labels = [];
        $dataByMonth = [];

        // Prepare the structure to store data for each month
        foreach ($monthlyData as $data) {
            $monthLabel = Carbon::createFromDate($data->year, $data->month, 1)->format('F Y'); // Format as Jan 2025, Feb 2025, etc.

            // Add month to labels if it's not already there
            if (!in_array($monthLabel, $labels)) {
                $labels[] = $monthLabel;
            }

            // Initialize the array if not already set
            if (!isset($dataByMonth[$monthLabel])) {
                $dataByMonth[$monthLabel] = [
                    'delivered' => 0,
                    'damage' => 0,
                    'cancel' => 0,
                ];
            }

            // Assign the counts to the correct status
            switch ($data->order_status) {
                case 'delieverd':
                    $dataByMonth[$monthLabel]['delivered'] = $data->total;
                    break;
                case 'damage':
                    $dataByMonth[$monthLabel]['damage'] = $data->total;
                    break;
                case 'cancel':
                    $dataByMonth[$monthLabel]['cancel'] = $data->total;
                    break;
            }
        }

        // Now we need to build the data arrays for each status
        $deliveredData = [];
        $damageData = [];
        $cancelData = [];

        foreach ($labels as $month) {
            $deliveredData[] = $dataByMonth[$month]['delivered'];
            $damageData[] = $dataByMonth[$month]['damage'];
            $cancelData[] = $dataByMonth[$month]['cancel'];
        }

        // Prepare the final chart data for the monthly sales chart
        $chartData = [
            'labels' => $labels,
            'datasets' => [
                'delivered' => $deliveredData,
                'damage' => $damageData,
                'cancel' => $cancelData,
            ],
        ];

        return $chartData;
    }

    public function chart2()
    {
        // Get data for the last 7 days grouped by order status
        $dailyData = Order::selectRaw('DATE(created_at) as date, order_status, SUM(price) as total')
            ->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()]) // Get last 7 days
            ->groupBy('date', 'order_status')
            ->orderBy('date', 'asc')
            ->get();

        // Initialize arrays
        $labels = [];
        $dataByDay = [];

        // Prepare the structure to store data for each day
        foreach ($dailyData as $data) {
            $dateLabel = Carbon::parse($data->date)->format('Y-m-d'); // Format as 2025-04-10

            // Add date to labels if it's not already there
            if (!in_array($dateLabel, $labels)) {
                $labels[] = $dateLabel;
            }

            // Initialize the array for the specific date if not already set
            if (!isset($dataByDay[$dateLabel])) {
                $dataByDay[$dateLabel] = [
                    'delivered' => 0,
                    'cancel' => 0,
                    'pending' => 0,
                    'shipping' => 0,
                ];
            }

            // Assign the total sales to the correct order status
            switch ($data->order_status) {
                case 'delieverd':
                    $dataByDay[$dateLabel]['delivered'] = $data->total;
                    break;
                case 'cancel':
                    $dataByDay[$dateLabel]['cancel'] = $data->total;
                    break;
                case 'pending':
                    $dataByDay[$dateLabel]['pending'] = $data->total;
                    break;
                case 'shipping':
                    $dataByDay[$dateLabel]['shipping'] = $data->total;
                    break;
            }
        }

        // Now we need to build the data arrays for each status
        $deliveredData = [];
        $cancelData = [];
        $pendingData = [];
        $shippingData = [];

        foreach ($labels as $date) {
            $deliveredData[] = $dataByDay[$date]['delivered'];
            $cancelData[] = $dataByDay[$date]['cancel'];
            $pendingData[] = $dataByDay[$date]['pending'];
            $shippingData[] = $dataByDay[$date]['shipping'];
        }

        // Prepare the final chart data for the daily sales chart
        $chartData = [
            'labels' => $labels,
            'datasets' => [
                'delivered' => $deliveredData,
                'cancel' => $cancelData,
                'pending' => $pendingData,
                'shipping' => $shippingData,
            ],
        ];

        return $chartData;
    }
}
