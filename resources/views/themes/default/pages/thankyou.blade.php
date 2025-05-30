@extends('themes.default.layout.app')

@section('content')
    <div class="py-0 py-md-5"></div>
    <main style="padding-top: 30px;">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <div class="order-complete">
                <div class="order-complete__message">
                    <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="40" cy="40" r="40" fill="#B9A16B"></circle>
                        <path
                            d="M52.9743 35.7612C52.9743 35.3426 52.8069 34.9241 52.5056 34.6228L50.2288 32.346C49.9275 32.0446 49.5089 31.8772 49.0904 31.8772C48.6719 31.8772 48.2533 32.0446 47.952 32.346L36.9699 43.3449L32.048 38.4062C31.7467 38.1049 31.3281 37.9375 30.9096 37.9375C30.4911 37.9375 30.0725 38.1049 29.7712 38.4062L27.4944 40.683C27.1931 40.9844 27.0257 41.4029 27.0257 41.8214C27.0257 42.24 27.1931 42.6585 27.4944 42.9598L33.5547 49.0201L35.8315 51.2969C36.1328 51.5982 36.5513 51.7656 36.9699 51.7656C37.3884 51.7656 37.8069 51.5982 38.1083 51.2969L40.385 49.0201L52.5056 36.8996C52.8069 36.5982 52.9743 36.1797 52.9743 35.7612Z"
                            fill="white"></path>
                    </svg>
                    <h3 class="font-bd">আপনার অর্ডার টি কনফার্ম হয়েছে।!</h3>
                    <p>আন্তরিক অভিনন্দন ও ভালোবাসা অনিঃশেষ আমাদের পন্য অর্ডার করার জন্য। <br>
                        <strong>সকাল ১০টা থেকে রাত ১১টার মাঝেই আমাদের সাপোর্ট টিম আপনার সাথে যোগাযোগ করবে সময় দিয়ে সাথেই
                            থাকুন
                            প্লিজ।</strong>
                    </p>
                </div>
                <div class="order-info">
                    <div class="order-info__item">
                        <label>Order Number</label>
                        <span>{{ $order->order_id }}</span>
                    </div>
                    <div class="order-info__item">
                        <label>Date</label>
                        <span>{{ $order->created_at->format('D M y') }}</span>
                    </div>
                    <div class="order-info__item">
                        <label>Total</label>
                        <span>{{ $order->price }}</span>
                    </div>
                    <div class="order-info__item">
                        <label>Paymetn Method</label>
                        <span>Cash on delivery</span>
                    </div>
                </div>
                <div class="checkout__totals-wrapper">
                    <div class="checkout__totals">
                        <h3>Order Details</h3>
                        <table class="checkout-cart-items table">
                            <thead>
                                <tr>
                                    <th>PRODUCT</th>
                                    <th>ATT</th>
                                    <th>SUBTOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($order->products)
                                    @foreach ($order->products as $product)
                                        <tr>
                                            <td>
                                                {{ $product->product ? $product->product->product->name : 'Unknown' }} x
                                                {{ $product->qnt }}
                                            </td>
                                            <td class="p-1">
                                                Color:
                                                {{ $product->product->color ? $product->product->color->name : 'Unknown' }}
                                                <br>
                                                Size:
                                                {{ $product->product->size ? $product->product->size->name : 'Unknown' }}
                                            </td>
                                            <td>
                                                {{ $product->price * $product->qnt }} Tk
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <table class="checkout-totals">
                            <tbody>
                                <tr>
                                    <th>SUBTOTAL</th>
                                    <td>{{ $order->price - $order->shipping_charge }} Tk</td>
                                </tr>
                                <tr>
                                    <th>SHIPPING</th>
                                    <td>{{ $order->shipping_charge }} Tk</td>
                                </tr>
                                <tr>
                                    <th>TOTAL</th>
                                    <td>{{ $order->price }} Tk</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
