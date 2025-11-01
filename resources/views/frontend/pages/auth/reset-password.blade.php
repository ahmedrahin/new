@extends('frontend.layout.app')

@section('page-title')
Reset Password | {{ config('app.name') }}
@endsection

@section('page-css')
<link href="{{ asset('frontend/style/accounts.min.12.css') }}" type="text/css" rel="stylesheet" media="screen" />
<style>
    .mb-3 {
        margin-bottom: 10px;
    }

    form label {
        padding-bottom: 10px;
        display: inline-block;
    }
</style>
@endsection

@section('body-content')


<div class="container ac-layout before-login">
    <div class="panel m-auto">
        <div class="p-head">
            <h2 class="text-center">Reset Your Password</h2>
        </div>
        <div class="p-body">
            <form method="post" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->token }}">
                <input type="hidden" name="email" value="{{ old('email', $request->email) }}">

                <div class="mb-3 required">
                    <label class="control-label" for="input-password">Password</label>
                    <input type="password" name="password" placeholder="******" class="form-control @error('password') error-border @enderror " id="password" />
                    @error('password')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                 <div class="required mb-0">
                    <label for="input-telephone">Confirm Password</label>
                    <input type="password" name="password_confirmation" placeholder="******" class="form-control" id="password_confirmation" />
                </div>

                <div style="text-align: right;padding:4px 0;">
                    <a class="forgot-password" href="{{ route('user.login') }}">Back to login</a>
                </div>

                <button type="submit" class="btn btn-primary">Confirm</button>

            </form>
        </div>
    </div>
</div>

@endsection