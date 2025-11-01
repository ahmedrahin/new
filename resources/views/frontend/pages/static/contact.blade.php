@extends('frontend.layout.app')

@section('page-title')
    Contact Us
@endsection

@section('page-css')
    <style>
        .btn_black {
            width: 150px;
            height: 50px;
        }

        .btn_black span {
            color: white;
            font-size: 16px;
        }

        form input {
            margin-bottom: 0 !important;
        }
        .mb-3 {
            margin-bottom: 15px;
        }
        .mb-3 label {
            display: block;
            padding-bottom: 10px;
        }
    </style>
    <link href="{{ asset('frontend/style/contact.min.16.css') }}" type="text/css" rel="stylesheet" media="screen" />
@endsection

@section('body-content')
    <section class="after-header p-tb-10">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ url('/') }}"><i class="material-icons" title="Home">home</i></a></li>
                <li><a href="">Contact Us</a></li>
            </ul>
        </div>
    </section>

    <div class="info-page bg-bt-gray p-tb-15">
        <div class="container body">
            <div class="contact-us-content">
                <div class="row">
                    <div class="col-md-4">
                        <div class="c-card ws-box">
                            <div class="ic"><a href="tel:16793"><i class="material-icons">phone_in_talk</i></a></div>
                            <div class="each-card-text">
                                <label class="label">Contact Us</label>
                                <span class="blurb"><a href="tel:{{ config('app.phone') }}">{{ config('app.phone') }}</a> /
                                    <a href="tel:{{ config('app.phone2') }}">{{ config('app.phone2') }}</a></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="c-card ws-box">
                            <div class="ic"><a href="mailto:webteam@startechbd.com"><i
                                        class="material-icons">drafts</i></a></div>
                            <div class="each-card-text">
                                <label class="label">For Corporate Deals & Complain</label>
                                <span class="blurb"><a
                                        href="mailto:{{ config('app.email') }}">{{ config('app.email') }}</a></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="c-card ws-box">
                            <div class="ic"><a href="mailto:webteam@startechbd.com"><i
                                        class="material-icons">location_on</i></a></div>
                            <div class="each-card-text">
                                <label class="label">Our Address</label>
                                <span class="blurb"><a href="">{{ config('app.address') }}</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="contact-section container">
        <div class="">

            @livewire('frontend.user.contact-message')

        </div>
    </section>

@endsection

@section('page-script')
@endsection
