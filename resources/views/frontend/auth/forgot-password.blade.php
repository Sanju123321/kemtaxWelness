@extends('frontend.layouts.master')

@section('title', 'Forgot Password')

@section('content')

    <section class="page-title bg-1">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block text-center">
                        <h1 class="text-capitalize mb-5 text-lg">Forgot Password</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section contact-form">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="contact-form-wrapper p-5 rounded shadow">
                        <h3 class="mb-3 text-center">Reset Your Password</h3>
                        <p class="text-muted text-center mb-4">Enter your email address and we'll send you a link to reset
                            your password.</p>

                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle mr-2"></i>{{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}" class="contact__form">
                            @csrf

                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" required autofocus
                                    placeholder="Enter your registered email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-main btn-round-full btn-block">
                                    <i class="fas fa-paper-plane mr-2"></i>Send Reset Link
                                </button>
                            </div>

                            <div class="text-center mt-3">
                                <p class="mb-0">
                                    <a href="{{ route('login') }}" class="text-color">
                                        <i class="fas fa-arrow-left mr-1"></i>Back to Login
                                    </a>
                                </p>
                            </div>
                        </form>

                        <div class="mt-4 p-3 bg-light rounded">
                            <h6 class="mb-2"><i class="fas fa-info-circle text-color mr-2"></i>Need Help?</h6>
                            <p class="text-muted small mb-0">If you don't receive the email within a few minutes, please
                                check your spam folder or <a href="{{ route('contact') }}" class="text-color">contact
                                    support</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
