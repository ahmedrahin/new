@extends('frontend.layout.app')

@section('page-title')
    Order History
@endsection


@section('page-css')
    <link href="{{ asset('frontend/style/accounts.min.12.css') }}" type="text/css" rel="stylesheet" media="screen" />
    <style>
        .status-container.pending .status {
            color: #6c757d !important;
        }
        .status-container.processing .status {
            color: #17a2b8 !important; /* Blue for Processing */
        }
        .status-container.delivered .status {
            color: #28a745 !important; /* Green for Delivered */
        }
        .status-container.completed .status {
            color: #218838 !important; /* Darker Green for Completed */
        }
        .status-container.canceled .status {
            color: #dc3545 !important; /* Red for Cancelled */
        }
        .status-container.fake .status {
            
        }
        .o-card .c-head .right .status {
            font-weight: 600;
            font-size: 14px;
        }

    </style>
@endsection

@section('body-content')

<section class="after-header p-tb-10">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="material-icons" title="Home">home</i></a></li>
            <li><a href="{{ route('user.dashboard') }}">Account</a></li>
            <li><a href="">Order History</a></li>
        </ul>
    </div>
</section>

<div class="container ac-layout">
    <div class="ac-header">
        <div class="left">
            <span class="avatar">
                <img src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : asset('frontend/image/user.png') }}"
                    width="80" height="80" alt="Ra"></span>
            <div class="name">
                <p>Hello,</p>
                <p class="user">{{ auth()->user()->name }}</p>
            </div>
        </div>
    </div>

    @include('frontend.pages.user.user-menu')
    
    <div class="ac-title">
        <h1>Order History</h1>
    </div>

    <div class="cards">
        @if($user->orders->count() > 0)
            @foreach($user->orders->sortByDesc('id') as $order)
                <div class="card o-card">
                    <div class="c-head">
                        <div class="left">
                            <span class="o-id"><span>Order {{ $order->order_id }}</span></span>
                            <span class="o-date">Order Date: {{ \Carbon\Carbon::parse($order->order_date)->format('d M, Y')}}</span>
                        </div>

                        <div class="right">
                            @php
                                $status = $order->delivery_status;
                                $icons = [
                                    'pending'    => 'hourglass_empty',
                                    'processing' => 'autorenew',
                                    'delivered'  => 'local_shipping',
                                    'completed'  => 'check_circle',
                                    'canceled'   => 'cancel',
                                    'fake'       => 'report_problem',
                                ];

                                $labels = [
                                    'pending'    => 'Pending',
                                    'processing' => 'Processing',
                                    'delivered'  => 'Delivered',
                                    'completed'  => 'Completed',
                                    'canceled'   => 'Cancelled',
                                    'fake'       => 'Fake Order',
                                ];
                            @endphp

                            <span class="status-container {{ $status }}">
                                <span class="material-icons">{{ $icons[$status] ?? 'help' }}</span>
                                <span class="status">{{ $labels[$status] ?? ucfirst($status) }}</span>
                            </span>

                        </div>

                    </div>

                    <div class="c-body">
                       @php
                            $firstItem = $order->orderItems->first();
                            $extraCount = $order->orderItems->count() - 1;
                        @endphp

                        @if($firstItem)
                            <div class="img-n-title">
                                <div class="img-wrap">
                                    <img src="{{ asset($firstItem->product->thumb_image ?? 'default.jpg') }}"
                                        alt="{{ $firstItem->product->name ?? '' }}">
                                </div>
                                <div class="title">
                                    <h6 class="item-name">
                                        {{ $firstItem->product->name ?? 'Unnamed Product' }}
                                    </h6>
                                    <p>
                                        @if($extraCount > 0)
                                            +{{ $extraCount }} Item(s)
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endif
                        <div class="amount">{{ format_price($order->grand_total) }}৳</div>
                        <div class="actions">
                            <a href="{{route('order.invoice', ['user_id' => auth()->user()->id, 'order_id' => $order->order_id])}}" title="View"
                                class="btn ac-btn">View</a>
                        </div>
                    </div>

                </div>
            @endforeach
        @else
        <div class="empty-content" style="padding:5px 0;">
            <span class="icon material-icons">assignment</span>
            <div class="empty-text ">
                <h5>No Orders Found</h5>
            </div>
        </div>
        @endif

    </div>

</div>

@endsection
