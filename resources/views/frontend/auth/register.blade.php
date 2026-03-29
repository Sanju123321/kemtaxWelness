@extends('frontend.layouts.master')

@section('title', 'Join KemtexWellness - Register Now')

@section('content')

    <section class="page-title bg-1">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block text-center">
                        <span class="text-white">🚀 Start Your Journey</span>
                        <h1 class="text-capitalize mb-4 text-lg">Join KemtexWellness</h1>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="{{ route('home') }}" class="text-white">Home</a></li>
                            <li class="list-inline-item"><span class="text-white">/</span></li>
                            <li class="list-inline-item text-white-50">Register</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section registration-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="registration-card bg-white p-5 rounded shadow-sm">
                        <div class="text-center mb-4">
                            <h2 class="mb-2">Create Your Account</h2>
                            <p class="text-muted">Join 50,000+ successful entrepreneurs building wealth with Kemtex Wellness
                            </p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register.post') }}">
                            @csrf

                            <div class="form-group mb-4">
                                <label for="name"><i class="fas fa-user text-color mr-2"></i>Full Name</label>
                                <input type="text"
                                    class="form-control form-control-lg @error('name') is-invalid @enderror" id="name"
                                    name="name" placeholder="Enter your full name" value="{{ old('name') }}" required>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">Please enter your first and last name</small>
                            </div>

                            <div class="form-group mb-4">
                                <label for="phone"><i class="fas fa-phone text-color mr-2"></i>Phone Number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">+91</span>
                                    </div>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" placeholder="10-digit phone number"
                                        pattern="[0-9]{10}" value="{{ old('phone') }}">
                                </div>
                                <small class="form-text text-muted">Enter 10-digit number without country code</small>
                            </div>

                            <div class="form-group mb-4">
                                <label for="email"><i class="fas fa-envelope text-color mr-2"></i>Email Address</label>
                                <input type="email"
                                    class="form-control form-control-lg @error('email') is-invalid @enderror" id="email"
                                    name="email" placeholder="Enter your email address" value="{{ old('email') }}"
                                    required>
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="reference_code"><i class="fas fa-link text-color mr-2"></i>Reference
                                    Code</label>
                                <input type="text" class="form-control form-control-lg" id="reference_code"
                                    name="reference_code" placeholder="Enter your referrer's code"
                                    value="{{ old('reference_code') }}">
                                <small class="form-text text-muted">A team member's reference code is required to
                                    join</small>
                            </div>



                            <div class="form-group mb-4">
                                <label for="password"><i class="fas fa-lock text-color mr-2"></i>Password</label>
                                <input type="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Create a strong password" required>
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">Minimum 8 characters with uppercase, lowercase &
                                    numbers</small>
                            </div>

                            <div class="form-group mb-4">
                                <label for="password_confirmation"><i class="fas fa-lock text-color mr-2"></i>Confirm
                                    Password</label>
                                <input type="password" class="form-control form-control-lg" id="password_confirmation"
                                    name="password_confirmation" placeholder="Re-enter your password" required>
                            </div>

                            <div class="form-group mb-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="terms" name="terms"
                                        required>
                                    <label class="custom-control-label" for="terms">
                                        I agree to the <a href="{{ route('about') }}"
                                            class="text-color font-weight-600">Terms &amp; Conditions</a> and <a
                                            href="{{ route('about') }}" class="text-color font-weight-600">Privacy
                                            Policy</a>
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-main btn-lg btn-block btn-round-full mb-3">
                                <i class="fas fa-rocket mr-2"></i>Create My Account
                            </button>

                            <div class="text-center">
                                <p class="text-muted">Already have an account? <a href="{{ route('login') }}"
                                        class="text-color font-weight-600">Login here</a></p>
                            </div>
                        </form>
                    </div>

                    <div class="row mt-5 pt-4">
                        <div class="col-md-4 text-center mb-3">
                            <i class="ti-check text-color" style="font-size: 2rem;"></i>
                            <h6 class="mt-2">FREE Registration</h6>
                            <p class="text-muted small">No hidden charges or fees</p>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <i class="ti-timer text-color" style="font-size: 2rem;"></i>
                            <h6 class="mt-2">Instant Activation</h6>
                            <p class="text-muted small">Start earning immediately</p>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <i class="ti-headphone-alt text-color" style="font-size: 2rem;"></i>
                            <h6 class="mt-2">24/7 Support</h6>
                            <p class="text-muted small">Dedicated support team</p>
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
                        <span class="text-color">🌟 Join Thousands of Successful Members</span>
                        <h2 class="mt-2 text-white mb-3">Build Your Wellness Empire and Earn Unlimited Income</h2>
                        <p class="text-white">Complete your registration above and start your journey to financial freedom
                            today!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
