@extends('frontend.layout.app')

@section('page-title')
    Order Information
@endsection


@section('page-css')
    <link href="{{ asset('frontend/style/accounts.min.12.css') }}" type="text/css" rel="stylesheet" media="screen" />
    <style type="text/css">
        .order-details .head {
            text-align: center;
            padding-bottom: 30px;
        }

        .order-details p {
            font-size: 14px;
            line-height: 18px;
        }

        .order-details .head h1 {
            margin: 0 0 5px;
        }

        .order-details .head p {
            font-size: 14px;
            line-height: 18px;
            margin: 0;
        }

        .order-details .head .status {
            display: inline-block;
            padding: 3px 5px;
            border-radius: 2px;
            background: #27AE60;
            color: #fff;
            font-size: 12px;
        }

        .order-details .order-summary table {
            width: 100%;
        }

        .order-details .order-summary table td {
            padding: 0 0 7px;
        }

        .order-details .order-summary table .due td {
            border-top: 1px solid #ddd;
            padding-top: 7px;
        }

        .order-details .order-summary table .due td.text-right {
            color: red;
        }

        .order-details .order-summary table .paid td.text-right {
            color: #27AE60;
        }

        .order-details .table-order-products img {
            height: 50px;
        }

        .order-details .table-order-products {
            margin-bottom: 20px;
        }

        .order-details .table-order-products td {
            padding-left: 0;
        }
        .history p {
            font-size: 14px;
            line-height: 20px;
        }

        .order-details .table-order-products thead td {
            border-bottom: 1px solid #eee;
            background: #fff;
        }

        .order-details .order-details-comment {
            border-bottom: 1px solid #eee;
            margin-bottom: 20px;
        }

        .order-details-history .histories {
            border-left: 2px solid #ddd;
            padding-left: 20px;
            margin-left: 4px;
        }

        .order-details-history .histories .history {
            margin-bottom: 20px;
            position: relative;
        }

        .order-details-history {
            height: 100%;
        }

        .order-details-history .histories .history:before {
            content: "";
            position: absolute;
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 10px;
            border: 2px solid #EF4A23;
            background: #fff;
            left: -26px;
            top: 6px;
        }

        .order-details-history .histories h5 {
            margin-bottom: 4px;
        }

        .order-details-history .histories p {
            margin-bottom: 0px;
        }

        .order-details-history .histories span {
            display: inline-block;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .order-details-history {
                margin-top: 15px;
            }
            .col-md-6.order-summary {
                padding-top: 20px;
            }
        }
        .pending {
            background-color: #9e9e9e !important;
            color: white;
        }
        .processing {
            background-color: #03a9f4 !important;
            color: white;
        }
        .delivered {
            background-color: #4caf50 !important;
            color: white;
        }
       .completed {
            background-color: #388e3c !important;
            color: white;
        }
        .canceled {
            background-color: #f44336 !important;
            color: white;
        }
        .fake {
            background-color: #ff9800 !important; 
            color: white;
            font-weight: bold;
        }

    </style>
    
@endsection

@section('body-content')

    <section class="after-header p-tb-10">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ url('/') }}"><i class="material-icons" title="Home">home</i></a></li>
                <li><a href="{{ route('user.dashboard') }}">Account</a></li>
                <li><a href="{{ route('user.orders') }}">Order History</a></li>
                <li><a href="">Order Information</a></li>
            </ul>
        </div>
    </section>

    <section class="info-page bg-bt-gray" style="padding-top: 40px;">
        <div class="container ac-layout p-tb-15">
            <div class="row">
                <div class="col-xs-12 col-md-8">
                    <div class="ws-box content order-details">
                        @php
                            $status = $order->delivery_status;
                            $labels = [
                                'pending'    => 'Pending',
                                'processing' => 'Processing',
                                'delivered'  => 'Delivered',
                                'completed'  => 'Completed',
                                'canceled'   => 'Cancelled',
                                'fake'       => 'Fake Order',
                            ];
                        @endphp

                        <div class="head">
                            <h1>Order Information {{ $order->order_id }}</h1>
                            <span class="status {{ $status }}">{{ $labels[$status] ?? ucfirst($status) }}</span>
                        </div>
                        <div class="g-box">
                            <div class="row">
                                <div class="col-md-6 address">
                                    <h5>Shipping Address</h5>
                                    <address>
                                        <div style="margin-bottom: 5px;">{{ $order->name }}</div>
                                        <div style="margin-bottom: 5px;">{{ $order->shipping_address }}</div>
                                        <div style="margin-bottom: 5px;">{{ $order->district->name }}</div>
                                    </address>
                                    <div class="telephone p-tb-15"><span>Mobile: </span><span>{{ $order->phone }}</span></div>
                                </div>
                                <div class="col-md-6 order-summary">
                                    <h5>Order Summary</h5>
                                    <table class="table">
                                        <tr>
                                            <td class="text-left">Sub-Total</td>
                                            <td class="text-right">{{ format_price($order->orderItems->sum(fn($i) => $i->price * $i->quantity)) }}৳</td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">Delivery Charge</td>
                                            <td class="text-right">{{ format_price($order->shipping_cost) }}৳</td>
                                        </tr>
                                        @if( $order->coupon_discount )
                                            <tr>
                                                <td class="text-left">Coupon Discount</td>
                                                <td class="text-right">{{ format_price($order->coupon_discount) }}৳</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td class="text-left">Total</td>
                                            <td class="text-right">{{ format_price($order->grand_total) }}৳</td>
                                        </tr>
                                        <tr class="paid">
                                            <td class="text-left">Paid</td>
                                            <td class="text-right">{{ format_price($order->paid_amount ?? 0) }}৳</td>
                                        </tr>
                                        <tr class="due">
                                            <td class="text-left">Due</td>
                                            <td class="text-right">{{ format_price($order->grand_total - $order->paid_amount) }}৳</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <h5 class="m-t-30">Products</h5>
                        <table class="table table-bordered table-hover table-order-products">
                            <thead>
                                <tr>
                                    <td class="text-left">Image</td>
                                    <td class="text-left">Product Name</td>
                                    <td class="text-center">Quantity</td>
                                    <td class="text-right">Total</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItems as $item)
                                    <tr>
                                        <td> 
                                            <img src="{{ asset($item->product->thumb_image) }}">
                                        </td>
                                        <td class="text-left">
                                            <a href="{{ route('product-details', $item->product->slug) }}">{{ $item->product->name }}</a> </td>
                                        <td class="text-center" style="text-align: center;">{{ $item->quantity }}</td>
                                        <td class="text-right">{{ $item->price * $item->quantity }}৳</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-right">
                            <a href="{{ route('order.invoice.pdf', $order->order_id) }}" class="btn st-outline"><i class="fas fa-download"></i> Download Invoice</a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="ws-box content order-details-history">
                        <h3 class="m-b-15">Order History</h3>
                        @foreach ($order->histories as $history)
                            <div class="histories">
                                <div class="history">
                                    <h5>{{ ucfirst($history->status) }}</h5>
                                    <p>{{ $history->note }}</p>
                                    <span class="fade"><span> {{ \Carbon\Carbon::parse($history->created_at)->format('d M, Y')}}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

