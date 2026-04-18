@extends('backend.layouts.auth')

@section('title', 'Reset Password')

@section('content')
    <div class="auth-card">

        <div class="auth-header" style="background: linear-gradient(135deg, #92400e 0%, #d97706 100%)">
            <div class="brand-icon">
                <i class="fas fa-lock fa-xl" style="color:#fff"></i>
            </div>
            <h4>Set New Password</h4>
            <small>KemtexWellness Admin Portal</small>
        </div>

        <div class="auth-body">

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
                Enter your new password below.
            </p>

            <form method="POST" action="{{ route('admin.reset.password.post') }}" novalidate>
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                    <label class="input-label" for="email">Admin Email</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><i class="fas fa-envelope fa-sm"></i></span>
                        <input type="email" id="email" name="email"
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $email) }}"
                            required autofocus />
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="input-label" for="password">New Password</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><i class="fas fa-lock fa-sm"></i></span>
                        <input type="password" id="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="Min. 8 characters"
                            required />
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="input-label" for="password_confirmation">Confirm Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock fa-sm"></i></span>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                            placeholder="Repeat new password" required />
                    </div>
                </div>

                <hr class="auth-divider">
                <div class="d-flex align-items-center justify-content-between">
                    <a href="{{ route('admin.login') }}" class="back-link">
                        <i class="fas fa-arrow-left fa-sm"></i> Back to Login
                    </a>
                    <button type="submit" class="btn btn-auth-warning">
                        <i class="fas fa-key me-1"></i> Reset Password
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
