@extends('frontend.layout.app')

@section('page-title')
    My Wishlist
@endsection


@section('page-css')
    <link href="{{ asset('frontend/style/accounts.min.12.css') }}" type="text/css" rel="stylesheet" media="screen" />
    
@endsection

@section('body-content')

<section class="after-header p-tb-10">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="material-icons" title="Home">home</i></a></li>
            <li><a href="">My Wishlist</a></li>
        </ul>
    </div>
</section>

<div class="container ac-layout">
    
    <div class="ac-title">
        <h1>My Wishlist</h1>
    </div>

    <livewire:frontend.wishlist.wishlist-list  />

</div>

@endsection
