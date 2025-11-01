@extends('frontend.layout.app')

@section('page-title')
    Return & Refund Policy | {{ config('app.name') }}
@endsection

@section('page-css')

    <style>
        
        .content  {
            font-size: 18px !important;
            margin-top: 40px !important;
        }
    </style>

@endsection

@section('body-content')

    <div class="container" style="padding: 50px 0;">
        <div class="row">
            <h2>Return & Refund Policy </h2>

            <div class="content">
                @php
                    echo App\Models\PagesContent::first()->refund_policy ?? '';
                @endphp
            </div>
        </div>
    </div>

@endsection

@section('page-script')

@endsection
