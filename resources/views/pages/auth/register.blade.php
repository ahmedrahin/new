@extends('frontend.layout.app')

@section('page-title')
    Register
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
                <li><a href="{{ route('register') }}">Register</a></li>
            </ul>
        </div>
    </section>

     <div class="container ac-layout before-login">
        <div class="panel m-auto">
            <div class="p-head">
                <h2 class="text-center">Register Account</h2>
            </div>
            <div class="p-body">
                <form  method="post" id="registerForm" >
                    @csrf
                     <div class="required mb-3">
                        <label for="input-firstname">Name</label>
                        <input type="text" name="firstname" placeholder="Your Name" class="form-control" id="name" />
                        <div class="text-danger mt-2" id="nameError"></div>
                    </div>

                    <div class="required mb-3">
                        <label for="input-email">E-Mail</label>
                        <input type="text" name="email" placeholder="E-Mail" id="email" class="form-control" />
                        <div class="text-danger mt-2" id="emailError"></div>
                    </div>

                    <div class="required mb-3">
                        <label for="input-telephone">Your Password</label>
                        <input type="password" name="password" placeholder="******" class="form-control" id="password" />
                        <div class="text-danger mt-2" id="passwordError"></div>
                    </div>

                    <div class="required mb-0">
                        <label for="input-telephone">Confirm Password</label>
                        <input type="password" name="password_confirmation" placeholder="******" class="form-control" id="password_confirmation" />
                        <div class="text-danger mt-2" id="passwordConfirmationError"></div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <div class="text">Register</div>
                        <span class="formloader" style="display: none;"></span>
                    </button>


                    <p class="no-account-text"><span>Already have an account?</span></p>
                    <p>If you already have an account with us, please login at the <a href="{{ route('user.login') }}">login page</a>.</p>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('page-script')

    <script>

        jQuery(function($) {
            $("#registerForm").on("submit", function (e) {
                e.preventDefault();

                // Clear previous errors
                $(".text-danger").text("");
                $("#name, #email, #password, #password_confirmation").removeClass("error-border");

                let formData = {
                    name: $("#name").val(),
                    email: $("#email").val(),
                    password: $("#password").val(),
                    password_confirmation: $("#password_confirmation").val(),
                };

                $(".formloader").css("display", "inline-block");
                $(".text").css("display", "none");
                $("#loginButton").prop("disabled", true);

                $.ajax({
                    url: "{{ route('user.register') }}",
                    type: "POST",
                    data: formData,
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        $(".formloader").css("display", "none");
                        $(".text").css("display", "block");
                        $("#loginButton").prop("disabled", false);

                        window.location.href = "{{ route('user.dashboard') }}";
                    },
                    error: function (xhr) {
                        $(".formloader").css("display", "none");
                        $(".text").css("display", "block");
                        $("#loginButton").prop("disabled", false);

                        if (xhr.responseJSON.errors) {
                            let errors = xhr.responseJSON.errors;

                            if (errors.name || errors.firstname) {
                                $("#nameError").text(errors.name ? errors.name[0] : errors.firstname[0]);
                                $("#name").addClass("error-border");
                            }
                            if (errors.email) {
                                $("#emailError").text(errors.email[0]);
                                $("#email").addClass("error-border");
                            }
                            if (errors.password) {
                                $("#passwordError").text(errors.password[0]);
                                $("#password").addClass("error-border");
                            }
                            if (errors.password_confirmation) {
                                $("#passwordConfirmationError").text(errors.password_confirmation[0]);
                                $("#password_confirmation").addClass("error-border");
                            }
                        }
                    }
                });
            });

            // Remove error border on input
            $("#name, #email, #password, #password_confirmation").on("input", function () {
                $(this).removeClass("error-border");
            });
        });


    </script>
@endsection

