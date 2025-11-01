@extends('frontend.layout.app')

@section('page-title')
    404 Not found
@endsection

@section('page-css')
    <style>
        .not-found-img {
            width: 300px;
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('body-content')
   <section class="after-header p-tb-10">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ url('/') }}"><i class="material-icons" title="Home">home</i></a></li>
                <li><a href="">404 page</a></li>
            </ul>
        </div>
    </section>

    <div class="container body">
        <div class="row">
            <div class="empty-content">
                    <img src="{{ asset('frontend/image/404.png') }}" alt="404 Not Found" class="not-found-img">
                    <div class="empty-text" style="padding: 0">
                <h3 style="color: var(--s-secondary)">Oops!</h3>
                <p>The page you requested cannot be found.</p>
            </div>
                <a href="{{ url('/') }}" class="btn btn-primary">Go to Home</a>
            </div>
        </div>
    </div>

@endsection
