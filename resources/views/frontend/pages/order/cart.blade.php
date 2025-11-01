@extends('frontend.layout.app')

@section('page-title')
Cart
@endsection

@section('page-css')
<link href="{{ asset('frontend/style/checkout.min.12.css') }}" type="text/css" rel="stylesheet" media="screen" />
<style>
    .img-thumbnail {
        width: 60px;
    }

    .btnremove {
        padding: 0;
        width: 30px;
        height: 30px;
        background: red;
        border-color: red;
        font-size: 10px;
    }

    .btnremove i {
        font-size: 20px;
    }
</style>
<style>
    .quantity {
        display: inline-flex;
        align-items: center;
        border: 1px solid #ddd;
        border-radius: 6px;
        overflow: hidden;
        background-color: #f9f9f9;
        max-width: 140px;
    }

    .quantity button {
        background-color: #fff;
        border: none;
        padding: 3px 12px;
        cursor: pointer;
        font-size: 18px;
        color: #333;
        transition: background-color 0.2s ease;
    }

    .quantity button:hover {
        background-color: #eee;
    }

    .quantity .qty {
        width: 50px;
        text-align: center;
    }

    .quantity input[type=number] {
        width: 100%;
        height: 38px;
        border: none;
        text-align: center;
        font-size: 16px;
        background: transparent;
        outline: none;
    }
    .text-center {
        text-align: center;
    }
    .quantity input {
        border: none;
    }
</style>
@endsection


@section('body-content')

<livewire:frontend.cart.cart-list />


@endsection