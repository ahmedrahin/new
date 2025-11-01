@extends('frontend.layout.app')

@section('page-title')
    Checkout 
@endsection

@section('page-css')
    <link href="{{ asset('frontend/style/checkout.min.12.css') }}" type="text/css" rel="stylesheet" media="screen" />
    <style>
         @media screen and (min-width: 991px) {
            .btncouopn {
                width: 200px;
            }
        }
        #cart, #cmpr-btn, .mc-wishlist {
            display: none;
        }
        .payment-methods label {
            display: block;
            margin-bottom: 10px;
        }
        label {
            cursor: pointer;
        }
    </style>
@endsection


@section('body-content')
    <section class="after-header p-tb-10">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ url('/') }}"><i class="material-icons" title="Home">home</i></a></li>
                <li><a href="{{ route('cart') }}">Shopping Cart</a></li>
                <li><a href="">Checkout</a></li>
            </ul>
        </div>
    </section>
    <livewire:frontend.order.checkout />
@endsection

@push('scripts')
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.hook('message.processed', (message, component) => {
                let url = component.get('sslcommerzUrl');
                if (url) {
                    window.location.href = url; // Full page redirect triggered after Livewire updates
                }
            });
        });
    </script>
@endpush
