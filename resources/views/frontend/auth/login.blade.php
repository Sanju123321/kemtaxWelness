@extends('frontend.layouts.master')

@section('title', 'Member Login - KemtexWellness')

@section('content')

    <section class="page-title bg-1">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block text-center">
                        <span class="text-white">🔐 Member Access</span>
                        <h1 class="text-capitalize mb-4 text-lg">Welcome Back</h1>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="{{ route('home') }}" class="text-white">Home</a></li>
                            <li class="list-inline-item"><span class="text-white">/</span></li>
                            <li class="list-inline-item text-white-50">Login</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section login-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="login-card bg-white p-5 rounded shadow-sm">
                        <div class="login-header text-center mb-4">
                            <div class="login-icon mb-3">
                                <i class="fas fa-lock text-color" style="font-size: 3rem;"></i>
                            </div>
                            <h2 class="mb-2">Member Login</h2>
                            <p class="text-muted">Access your Kemtex Wellness account</p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form id="loginForm" class="login-form"   method="POST" action="{{ route('login.post') }}">
                            @csrf

                            <div class="form-group mb-4">
                                <label for="user_id"><i class="fas fa-id-card text-color mr-2"></i>User ID</label>
                                <input type="text"
                                    class="form-control form-control-lg @error('user_id') is-invalid @enderror" id="user_id"
                                    name="user_id" placeholder="Enter your User ID" value="{{ old('user_id') }}" required
                                    autofocus>
                                @error('user_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="password"><i class="fas fa-key text-color mr-2"></i>Password</label>
                                <input type="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Enter your password" required>
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="text-right mb-4">
                                <a href="{{ url('/forgot-password') }}" class="text-color font-weight-600 small">Forgot
                                    password?</a>
                            </div>

                            <div class="form-group mb-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="rememberMe" name="remember">
                                    <label class="custom-control-label" for="rememberMe">Remember me for 30 days</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-main btn-lg btn-block btn-round-full mb-3">
                                <i class="fas fa-sign-in-alt mr-2"></i>Login to Account
                            </button>

                            <div class="text-center">
                                <p class="text-muted">Don't have an account? <a href="{{ route('register') }}"
                                        class="text-color font-weight-600">Sign up here</a></p>
                            </div>
                        </form>
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-6 mb-3">
                            <div class="info-card text-center bg-white p-4 rounded shadow-sm">
                                <i class="ti-help text-color mb-2" style="font-size: 1.8rem;"></i>
                                <h6 class="mt-2">Need Help?</h6>
                                <p class="text-muted small">Contact our support team</p>
                                <a href="{{ route('contact') }}" class="text-color small font-weight-600">Get Support</a>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-card text-center bg-white p-4 rounded shadow-sm">
                                <i class="ti-key text-color mb-2" style="font-size: 1.8rem;"></i>
                                <h6 class="mt-2">Account Issues?</h6>
                                <p class="text-muted small">Verify your credentials</p>
                                <a href="{{ url('/forgot-password') }}" class="text-color small font-weight-600">Reset
                                    Password</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-2">
        <div class="container">
            <div class="cta-block p-5 rounded">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-8 text-center">
                        <span class="text-color">🚀 New to Kemtex Wellness?</span>
                        <h2 class="mt-2 text-white mb-3">Join Our Growing Community Today</h2>
                        <p class="text-white mb-4">Start your journey to financial freedom with our proven MLM opportunity
                        </p>
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-round-full">Create Your
                            Account</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>

<script>
$(document).ready(function () {

    $("#loginForm").validate({
        rules: {
            user_id: {
                required: true,
                
            },
            password: {
                required: true,
               
            },
        },

        messages: {
          
            user_id: {
                required: "Enter user ID",
               
            },
           
            password: {
                required: "Enter password",
                minlength: "Minimum 8 characters"
            },
           
        },

    });

    // 🔐 Password validation
    $.validator.addMethod("pwcheck", function (value) {
        return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/.test(value);
    }, "Password must contain uppercase, lowercase and number");

});
</script>
@endsection