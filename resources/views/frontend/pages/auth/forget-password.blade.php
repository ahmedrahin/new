@extends('frontend.layout.app')

@section('page-title')
    Forgot Password
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
    <section class="after-header p-tb-10">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ url('/') }}"><i class="material-icons" title="Home">home</i></a></li>
                <li><a href="{{ route('user.login') }}">Login</a></li>
                <li><a href="{{ route('password.request') }}">Forgot Password</a></li>
            </ul>
        </div>
    </section>

    <div class="container ac-layout before-login">
        <div class="panel m-auto">
            <div class="p-head">
                <h2 class="text-center">Forgot Your Password?</h2>
            </div>
            <div class="p-body">
                <form method="post" id="otpForm">
                    @csrf
                    <div class="mb-3 required">
                        <label class="control-label" for="email">E-Mail Address</label>
                        <input type="text" name="email" placeholder="E-Mail Address" id="email"
                            class="form-control" />
                        <div class="text-danger mt-2" id="emailError"></div>
                    </div>
                    <div style="text-align: right;padding:4px 0;">
                        <a class="forgot-password" href="{{ route('user.login') }}">Back to login</a>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <div class="text">Continue</div>
                        <span class="formloader" style="display: none;"></span>
                    </button>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        jQuery(function($) {
            $("#otpForm").on("submit", function(e) {
                e.preventDefault();

                // Clear previous errors
                $("#emailError").text("");

                // Show spinner and disable button
                $(".text-danger").text("");
                $("#email, #password").removeClass("error-border");

                $(".formloader").css("display", "inline-block");
                $(".text").css("display", "none");
                $("#loginButton").prop("disabled", true);

                let formData = {
                    email: $("#email").val(),
                };

                $.ajax({
                    url: "{{ route('password.email') }}",
                    type: "POST",
                    data: formData,
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        $(".formloader").css("display", "none");
                        $(".text").css("display", "block");
                        $("#loginButton").prop("disabled", false);

                        message('success', 'Password reset link sent to your email!');
                    },
                    error: function(xhr) {
                        $(".formloader").css("display", "none");
                        $(".text").css("display", "block");
                        $("#loginButton").prop("disabled", false);

                        let errors = xhr.responseJSON.errors;
                        if (errors.email) {
                            $("#emailError").text(errors.email);
                            $("#email").addClass("error-border");
                        }
                    },
                    complete: function() {
                        $("#spinner").addClass("d-none");
                        $("#otpButton").prop("disabled", false);
                    },
                });
            });
        });
    </script>
@endsection
