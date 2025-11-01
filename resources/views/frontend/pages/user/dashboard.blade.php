@extends('frontend.layout.app')

@section('page-title')
My Account
@endsection


@section('page-css')
<link href="{{ asset('frontend/style/accounts.min.12.css') }}" type="text/css" rel="stylesheet" media="screen" />
@endsection

@section('body-content')

    <section class="after-header p-tb-10">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ url('/') }}"><i class="material-icons" title="Home">home</i></a></li>
                <li><a href="">Account</a></li>
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

        <div class="ac-menus">
            <div class="ac-menu-item">
                <a href="{{ route('user.orders') }}" class="ico-btn">
                    <span class="material-icons">chrome_reader_mode</span><span>Orders</span>
                </a>
            </div>

            <div class="ac-menu-item">
                <a href="{{ route('user.edit.profile') }}" class="ico-btn"><span
                        class="material-icons">person</span><span>Edit Profile</span></a>
            </div>
            <div class="ac-menu-item">
                <a href="{{ route('user.edit.password') }}" class="ico-btn"><span
                        class="material-icons">lock</span><span>Change Password</span></a>
            </div>

            <div class="ac-menu-item">
                <a href="{{ route('user.wishlist') }}" class="ico-btn"><span
                        class="material-icons">favorite_border</span><span>Wish List</span></a>
            </div>


            {{-- <div class="ac-menu-item">
                <a href="" class="ico-btn"><span
                        class="material-icons">account_balance_wallet</span><span>Your Transactions</span></a>
            </div> --}}
            {{-- <div class="ac-menu-item ">
                <a href="" class="ico-btn"><span
                        class="material-icons">delete</span><span>Delete Account</span></a>
            </div> --}}
            <div class="ac-menu-item">
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="ico-btn">
                    <span class="material-icons">input</span><span>Logout</span>
                </a>
            </div>
        </div>
    </div>

     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
@endsection
