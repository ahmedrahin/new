@extends('frontend.layout.app')

@section('page-title')
    Privacy Policy | {{ config('app.name') }}
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
            <h2>Privacy Policy</h2>

            <div class="content">
                @php
                    echo App\Models\PagesContent::first()->privacy_policy ?? '';
                @endphp
            </div>
        </div>
    </div>

@endsection

@section('page-script')

@endsection
