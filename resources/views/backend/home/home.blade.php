@extends('backend.master')
@php
    function getStatusColor($status)
    {
        switch ($status) {
            case 'pending':
                return 'warning';
            case 'processing':
                return 'info';
            case 'shipping':
                return 'primary';
            case 'return':
                return 'secondary';
            case 'cancel':
                return 'danger';
            case 'damage':
                return 'dark';
            case 'delieverd':
                return 'success';
            default:
                return 'secondary';
        }
    }
    function getStatusLabel($status)
    {
        switch ($status) {
            case 'pending':
                return 'Pending';
            case 'processing':
                return 'Processing';
            case 'shipping':
                return 'Shipping';
            case 'return':
                return 'Pending Payment';
            case 'cancel':
                return 'Cancelled';
            case 'damage':
                return 'On Hold';
            case 'delieverd':
                return 'Complete';
            default:
                return 'Unknown';
        }
    }

@endphp
@php
    use Carbon\Carbon;
    $todayDate = Carbon::now()->format('d M'); // Format as 'YYYY-MM-DD'
@endphp
@section('content')
    <section class="content-main">
        <div class="content-header">
            <div>
                <h2 class="content-title card-title">Dashboard </h2>
                <p>Welcome <strong>{{ Auth::guard('admin')->user()->name }}</p>
            </div>
            <div>
                <a href="{{ route('sitemap') }}" class="btn btn-primary"><i
                        class="text-muted material-icons md-post_add"></i>Site Map</a>
                <a href="{{ route('index') }}" class="btn btn-primary" target="_blank">
                    <svg fill="#ffffff" version="1.1" id="Capa_1" style="margin-right: 0.5rem"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16px"
                        viewBox="0 0 63.241 63.24" xml:space="preserve">
                        <g>
                            <path
                                d="M23.011,44.446h7.578v9.479C27.374,50.959,24.827,47.774,23.011,44.446z M30.595,33.352H19.75
                                                                                                                      c0.176,2.931,0.876,5.842,2.086,8.659h8.759V33.352z M30.595,22.259h-8.989c-1.13,2.805-1.768,5.715-1.879,8.659h10.861v-8.659
                                                                                                                      H30.595z M11.325,42.011h7.879c-1.101-2.817-1.734-5.726-1.893-8.659h-8.21C9.267,36.386,10.01,39.296,11.325,42.011z
                                                                                                                      M30.595,9.827c-3.395,3.121-6.031,6.479-7.857,9.996h7.857V9.827z M33.027,30.917H43.89c-0.111-2.944-0.746-5.854-1.88-8.659
                                                                                                                      h-8.986v8.659H33.027z M33.027,9.827v9.996h7.857C39.057,16.306,36.424,12.947,33.027,9.827z M9.105,30.917h8.186
                                                                                                                      c0.101-2.937,0.674-5.844,1.705-8.659h-7.673C10.01,24.972,9.267,27.883,9.105,30.917z M27.049,9.897
                                                                                                                      c-5.902,1.256-11.062,4.819-14.356,9.925h7.328C21.642,16.364,24.006,13.032,27.049,9.897z M33.027,53.925
                                                                                                                      c3.215-2.964,5.766-6.147,7.576-9.479h-7.576V53.925z M50.932,44.446h-7.587c-1.738,3.522-4.223,6.9-7.4,10.053
                                                                                                                      C42.116,53.368,47.505,49.759,50.932,44.446z M50.932,19.822c-3.294-5.106-8.458-8.669-14.357-9.925
                                                                                                                      c3.043,3.132,5.401,6.467,7.032,9.925H50.932z M27.675,54.497c-3.174-3.155-5.662-6.528-7.4-10.053h-7.587
                                                                                                                      C16.113,49.759,21.504,53.368,27.675,54.497z M52.296,22.259h-7.674c1.031,2.814,1.608,5.722,1.706,8.659h8.185
                                                                                                                      C54.354,27.883,53.61,24.972,52.296,22.259z M33.027,42.011h8.758c1.211-2.817,1.907-5.729,2.087-8.659H33.027V42.011z
                                                                                                                      M54.513,33.352h-8.207c-0.155,2.934-0.792,5.842-1.889,8.659h7.879C53.61,39.296,54.354,36.386,54.513,33.352z M59.853,31.618
                                                                                                                      c0,15.571-12.669,28.242-28.237,28.242c-15.573,0-28.24-12.671-28.24-28.242c0-15.57,12.667-28.237,28.24-28.237
                                                                                                                      c5.922,0,11.684,1.877,16.46,5.305l-3.332,3.331l12.698,3.31L54.134,2.63l-3.647,3.649C45.056,2.231,38.436,0,31.621,0
                                                                                                                      C14.184,0,0,14.184,0,31.618C0,49.055,14.184,63.24,31.621,63.24c17.434,0,31.62-14.186,31.62-31.623H59.853z" />
                        </g>
                    </svg>
                    Website</a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3">
                <div class="card card-body mb-4">
                    <article class="icontext">
                        <span class="icon icon-sm rounded-circle bg-primary-light"><i
                                class="text-primary material-icons md-monetization_on"></i></span>
                        <div class="text">
                            <h6 class="mb-1 card-title">Total Sales</h6>
                            <span>{{ number_format($total_price) }} Tk</span>
                            <span class="text-sm">
                                Shipping fees are not included
                            </span>
                        </div>
                    </article>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card card-body mb-4">
                    <article class="icontext">
                        <span class="icon icon-sm rounded-circle bg-success-light"><i
                                class="text-success material-icons md-local_shipping"></i></span>
                        <div class="text">
                            <h6 class="mb-1 card-title">Orders</h6> <span>{{ $order }}</span>
                            <span class="text-sm">
                                Excluding orders in transit
                            </span>
                        </div>
                    </article>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card card-body mb-4">
                    <article class="icontext">
                        <span class="icon icon-sm rounded-circle bg-warning-light"><i
                                class="text-warning material-icons md-qr_code"></i></span>
                        <div class="text">
                            <h6 class="mb-1 card-title">Products</h6> <span>{{ $total_product }}</span>
                            <span class="text-sm">
                                In {{ $total_cat }} Categories
                            </span>
                        </div>
                    </article>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card card-body mb-4">
                    <article class="icontext">
                        <span class="icon icon-sm rounded-circle bg-info-light"><i
                                class="text-info material-icons md-shopping_basket"></i></span>
                        <div class="text">
                            <h6 class="mb-1 card-title">Monthly Earning</h6> <span>{{ $thisMonth }}</span>
                            <span class="text-sm">
                                Based in your local time.
                            </span>
                        </div>
                    </article>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8 col-lg-12">
                <div class="card mb-4">
                    <article class="card-body">
                        <h5 class="card-title">Monthly Sales Report</h5>
                        <canvas id="myChart" height="120px"></canvas>
                    </article>
                </div>
            </div>
            <div class="col-xl-4 col-lg-12">
                <div class="card mb-4">
                    <article class="card-body">
                        <h5 class="card-title">Daily Sales Report</h5>
                        <canvas id="myChart2" height="217"></canvas>
                    </article>
                </div>
            </div>
            {{-- <div class="col-xl-4 col-lg-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">Pending Order</h5>
                            <span class="badge  text-dark">{{ $todayDate }}</span>
                        </div>
                        <div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">SL</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!--[if BLOCK]><![endif]-->
                                        @foreach ($order_pending as $order)
                                            <tr>
                                                <td>{{ $order->order_id }}</td>
                                                <td>
                                                    <a href="{{ route('admin.order.view', $order->id) }}">
                                                        {{ $order->name }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="text-dark"
                                                        style="font-weight: 700">{{ number_format($order->price) }}
                                                        Tk</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="card mb-4">
                <header class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Latest orders</h4>
                    <a href="{{ route('admin.order') }}" class="btn btn-primary"></i>All Orders</a>
                </header>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="form-check-input" id="checkAll"
                                                title="Select All" />
                                        </th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Contact</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Employee</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Date</th>
                                        <th scope="col" class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr @if ($order->notification == 1) style="background: #6de9ed2b;" @endif>
                                            <td>
                                                <input class="form-check-input status-checkbox" name="status[]"
                                                    type="checkbox" value="{{ $order->id }}" />
                                            </td>
                                            <td>
                                                <b>{{ $order->user ? $order->user->name : 'Unknown' }}</b><br>
                                                <span
                                                    style="font-size: 10px; font-weight: 800;">#{{ $order->order_id }}</span>
                                            </td>
                                            <td>
                                                {{ $order->user ? $order->user->number : 'Null' }}<br>
                                                @if ($order->user)
                                                    <span
                                                        class="badge rounded-pill alert-{{ $order->user->is_blocked == 1 ? 'danger' : '' }}">
                                                        {{ $order->user->is_blocked == 1 ? 'Blocked' : '' }}</span>
                                                @endif
                                            </td>
                                            <td>{{ number_format($order->price, 0) }} Tk</td>
                                            <td>
                                                @if ($order->employee)
                                                    <span
                                                        class="badge rounded-pill alert-secondary">{{ $order->employee->name }}</span>
                                                @else
                                                    @php
                                                        $orderHealth = $order->health($order->user_id);
                                                        $progressBarColor =
                                                            $orderHealth >= 80
                                                                ? 'bg-success'
                                                                : ($orderHealth >= 50
                                                                    ? 'bg-warning'
                                                                    : 'bg-danger');
                                                    @endphp
                                                    <div class="progress">
                                                        <div class="progress-bar {{ $progressBarColor }}"
                                                            role="progressbar"
                                                            style="width: {{ $orderHealth }}%; font-size:10px;"
                                                            aria-valuenow="{{ $orderHealth }}" aria-valuemin="0"
                                                            aria-valuemax="100">
                                                            {{ $orderHealth }}%
                                                        </div>
                                                    </div>
                                                @endif

                                                <br>

                                            </td>
                                            <td><span
                                                    class="badge rounded-pill alert-{{ getStatusColor($order->order_status) }}">{{ getStatusLabel($order->order_status) }}</span>
                                            </td>
                                            <td>
                                                {{ $order->created_at->format('d-M-y') }}<br>
                                                <span
                                                    style="font-size: 11px; background: #cbcbcb4f; padding: 2px 7px; border-radius: 10px; color:#00000091">{{ $order->created_at->format('g:i A') }}</span>
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('admin.order.view', $order->id) }}"
                                                    class="btn btn-md rounded font-sm">Check</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- table-responsive end// -->
                </div>
            </div>
        </div>

    </section> <!-- content-main end// -->
@endsection

@section('script')
    <script>
        /*Sale statistics Chart*/
        if ($('#myChart').length) {
            var ctx = document.getElementById('myChart').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'line',

                // The data for our dataset
                data: {
                    // labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    labels: {!! json_encode($chart['labels']) !!},
                    datasets: [{
                            label: 'Delivered',
                            tension: 0.3,
                            fill: true,
                            backgroundColor: 'rgba(4, 209, 130, 0.2)',
                            borderColor: 'rgb(4, 209, 130)',
                            data: {!! json_encode($chart['datasets']['delivered']) !!}
                        },
                        {
                            label: 'Damage',
                            tension: 0.3,
                            fill: true,
                            backgroundColor: 'rgba(44, 120, 220, 0.2)',
                            borderColor: 'rgba(44, 120, 220)',
                            data: {!! json_encode($chart['datasets']['damage']) !!}
                        },
                        {
                            label: 'Cancel',
                            tension: 0.3,
                            fill: true,
                            backgroundColor: 'rgba(380, 200, 230, 0.2)',
                            borderColor: 'rgb(380, 200, 230)',
                            data: {!! json_encode($chart['datasets']['cancel']) !!}
                        }

                    ]
                },
                options: {
                    plugins: {
                        legend: {
                            labels: {
                                usePointStyle: true,
                            },
                        }
                    }
                }
            });
        } //End if


        if ($('#myChart2').length) {
            var ctx = document.getElementById("myChart2").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar', // You can change the type to 'line' if needed
                data: {
                    labels: @json($chart2['labels']), // Dates for the last 7 days
                    datasets: [{
                            label: "Delivered",
                            backgroundColor: "#5897fb", // Blue color for delivered
                            barThickness: 10,
                            data: @json($chart2['datasets']['delivered'])
                        },
                        {
                            label: "Cancelled",
                            backgroundColor: "#ff6347", // Red color for cancelled
                            barThickness: 10,
                            data: @json($chart2['datasets']['cancel'])
                        },
                        {
                            label: "Pending",
                            backgroundColor: "#ffcc00", // Yellow color for pending
                            barThickness: 10,
                            data: @json($chart2['datasets']['pending'])
                        },
                        {
                            label: "Shipping",
                            backgroundColor: "#7bcf86", // Green color for shipping
                            barThickness: 10,
                            data: @json($chart2['datasets']['shipping'])
                        },
                    ]
                },
                options: {
                    plugins: {
                        legend: {
                            labels: {
                                usePointStyle: true,
                            },
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    </script>
@endsection
