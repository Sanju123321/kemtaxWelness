@extends('backend.layouts.auth')

@section('title', 'Forgot Password')

@section('content')
    <div class="auth-card">

        {{-- Header --}}
        <div class="auth-header" style="background: linear-gradient(135deg, #92400e 0%, #d97706 100%)">
            <div class="brand-icon">
                <i class="fas fa-key fa-xl" style="color:#fff"></i>
            </div>
            <h4>Forgot Password</h4>
            <small>KemtexWellness Admin Portal</small>
        </div>

        {{-- Body --}}
        <div class="auth-body">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    @foreach ($errors->all() as $error)
                        <div><i class="fas fa-exclamation-circle me-1"></i>{{ $error }}</div>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <p class="text-muted small mb-3">
                <i class="fas fa-info-circle me-1 text-info"></i>
                Enter your admin email address and we will send you a password reset link.
            </p>

            <form method="POST" action="{{ route('admin.forgot.password.post') }}" novalidate>
                @csrf
                <div class="mb-4">
                    <label class="input-label" for="email">Admin Email</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><i class="fas fa-envelope fa-sm"></i></span>
                        <input type="email" id="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="admin@example.com"
                            value="{{ old('email') }}" required autofocus />
                        <div class="invalid-feedback">
                            @error('email')
                                {{ $message }}
                            @else
                                Please enter a valid email address.
                            @enderror
                        </div>
                    </div>
                </div>
                <hr class="auth-divider">
                <div class="d-flex align-items-center justify-content-between">
                    <a href="{{ route('admin.login') }}" class="back-link">
                        <i class="fas fa-arrow-left fa-sm"></i> Back to Login
                    </a>
                    <button type="submit" class="btn btn-auth-warning">
                        <i class="fas fa-paper-plane me-1"></i> Send Reset Link
                    </button>
                </div>
            </form>

        </div>

        {{-- Footer strip --}}
        <div class="auth-footer-card">
            <small class="text-muted">
                <i class="fas fa-lock me-1"></i> Restricted access &mdash; authorised personnel only
            </small>
        </div>
    </div>
@endsection
