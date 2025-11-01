@extends('frontend.layout.app')

@section('page-title')
    Terms & Condition | {{ config('app.name') }}
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
            <h2>Terms & Condition</h2>

            <div class="content" >
                @php
                    echo App\Models\PagesContent::first()->terms ?? '';
                @endphp
            </div>
        </div>
    </div>

@endsection

@section('page-script')

@endsection
