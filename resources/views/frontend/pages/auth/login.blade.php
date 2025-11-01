@extends('frontend.layout.app')

@section('page-title')
    Login
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
                <li><a href="{{ route('user.dashboard') }}">Account</a></li>
                <li><a href="{{ route('user.login') }}">Login</a></li>
            </ul>
        </div>
    </section>

    <div class="container ac-layout before-login">
        <div class="panel m-auto">
            <div class="p-head">
                <h2 class="text-center">Account Login</h2>
            </div>
            <div class="p-body">
                <form  method="post" id="loginForm">
                    @csrf
                    <div class="mb-3 required">
                        <label class="control-label" for="email">E-Mail Address</label>
                        <input type="text" name="email" value="" placeholder="E-Mail Address" id="email" class="form-control" />
                        <div class="text-danger mt-2" id="emailError"></div>
                    </div>
                    <div class="mb-3 required">
                        <label class="control-label" for="input-password">Password</label>
                         <input type="password" name="password" placeholder="******" class="form-control" id="password" />
                         <div class="text-danger mt-2" id="passwordError"></div>
                    </div>
                    <div style="text-align: right;padding:4px 0;">
                         <a class="forgot-password" href="{{ route('password.request') }}">Forgotten Password?</a>
                    </div>
                    <button type="submit" class="btn btn-primary" id="loginButton">
                        <span class="text">Login</span>
                        <span class="formloader" style="display: none;"></span>
                    </button>

                </form>
                <p class="no-account-text"><span>Don't have an account?</span></p>
                <a class="btn st-outline" href="{{ route('register') }}">Create Your Account</a>
            </div>
        </div>
    </div>

@endsection

@section('page-script')

<script>
  jQuery(function($) {
        $("#loginForm").on("submit", function (e) {
            e.preventDefault();

            // Clear previous errors
            $("#emailError").text("");
            $("#passwordError").text("");

           $(".text-danger").text("");
           $("#email, #password").removeClass("error-border");

           $(".formloader").css("display", "inline-block");
           $(".text").css("display", "none");
           $("#loginButton").prop("disabled", true);


            // Form data
            let formData = {
                email: $("#email").val(),
                password: $("#password").val(),
                remember: $("#remember").is(":checked"),
            };

            $.ajax({
                url: "{{ route('user.login') }}",
                type: "POST",
                data: formData,
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                success: function (response) {
                    $(".formloader").css("display", "none");
                    $(".text").css("display", "block");
                    $("#loginButton").prop("disabled", false);

                    // Redirect to homepage on successful login
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    }
                },
                error: function (xhr) {
                    $(".formloader").css("display", "none");
                    $(".text").css("display", "block");
                    $("#loginButton").prop("disabled", false);

                    if (xhr.responseJSON.errors) {
                        let errors = xhr.responseJSON.errors;

                        if (errors.email) {
                            $("#emailError").text(errors.email);
                             $("#email").addClass("error-border");
                        }

                        if (errors.password) {
                            $("#passwordError").text(errors.password[0]);
                            $("#password").addClass("error-border");
                        }
                    }
                }
            });
        });
    });


</script>

@if (session('info'))
<script>
  toastr.error("{{ session('info') }}");
</script>
@endif
@endsection
