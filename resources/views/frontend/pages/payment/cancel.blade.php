@extends('frontend.layout.app')

@section('page-title')
    Checkout Cancel
@endsection

@section('page-css')

@endsection


@section('body-content')

<section class="py-5 bg-light text-center" style="margin: 40px 0;">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-50">
            <div class="col-md-8 col-lg-6">


                <h2 class="text-danger mb-3">Payment Cancelled</h2>
                <p class="text-muted mb-4">
                    Your checkout process was cancelled. If this was a mistake, you can try again or contact our support team.
                </p>

                <a href="{{ route('shop') }}" class="btn btn-primary me-2">
                    <i class="w-icon-cart"></i> Continue Shopping
                </a>

                <a href="{{ route('contact') }}" class="btn btn-outline-secondary">
                    <i class="w-icon-support"></i> Contact Support
                </a>
            </div>
        </div>
    </div>
</section>


@endsection
