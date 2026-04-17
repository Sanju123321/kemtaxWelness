@extends('backend.layouts.auth')

@section('title', 'Admin Login')

@section('content')
    <div class="auth-card">

        {{-- Header --}}
        <div class="auth-header">
            <div class="brand-icon">
                <i class="fas fa-shield-halved fa-xl" style="color:#fff"></i>
            </div>
            <h4>KemtexWellness Admin</h4>
            <small>Secure Administrative Access</small>
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

            <form method="POST" action="{{ route('admin.login.post') }}" autocomplete="on" novalidate id="loginForm">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label class="input-label" for="inputEmail">Email Address</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><i class="fas fa-envelope fa-sm"></i></span>
                        <input type="email" id="inputEmail" name="email"
                            class="form-control @error('email') is-invalid @enderror" placeholder="admin@example.com"
                            value="{{ old('email') }}" required autocomplete="email" autofocus />
                        <div class="invalid-feedback">
                            @error('email')
                                {{ $message }}
                            @else
                                Please enter a valid email address.
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Password with show/hide --}}
                <div class="mb-3">
                    <label class="input-label" for="inputPassword">Password</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><i class="fas fa-lock fa-sm"></i></span>
                        <input type="password" id="inputPassword" name="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="Enter your password"
                            required autocomplete="current-password" minlength="6" />
                        <button class="btn btn-eye" type="button" id="togglePassword" tabindex="-1"
                            title="Show / hide password">
                            <i class="fas fa-eye fa-sm" id="toggleIcon"></i>
                        </button>
                        <div class="invalid-feedback">
                            @error('password')
                                {{ $message }}
                            @else
                                Password is required (min 6 characters).
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Remember me --}}
                <div class="form-check mb-3">
                    <input class="form-check-input" id="rememberMe" name="remember" type="checkbox" value="1"
                        {{ old('remember') ? 'checked' : '' }} />
                    <label class="form-check-label small" for="rememberMe">
                        Keep me signed in for 30 days
                    </label>
                </div>

                <hr class="auth-divider">

                <div class="d-flex align-items-center justify-content-between">
                    <a class="back-link" href="{{ route('admin.forgot.password') }}">
                        <i class="fas fa-key fa-sm"></i> Forgot Password?
                    </a>
                    <button class="btn btn-auth-primary" type="submit">
                        <i class="fas fa-right-to-bracket me-1"></i> Sign In
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

@push('scripts')
    <script>
        // Show/hide password toggle
        document.getElementById('togglePassword').addEventListener('click', function() {
            const input = document.getElementById('inputPassword');
            const icon = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
                this.title = 'Hide password';
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
                this.title = 'Show password';
            }
        });

        // Client-side validation: mark fields before submit
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            let valid = true;
            const email = document.getElementById('inputEmail');
            const pass = document.getElementById('inputPassword');

            if (!email.value.trim() || !/^[^@]+@[^@]+\.[^@]+$/.test(email.value.trim())) {
                email.classList.add('is-invalid');
                valid = false;
            } else {
                email.classList.remove('is-invalid');
                email.classList.add('is-valid');
            }

            if (!pass.value || pass.value.length < 6) {
                pass.classList.add('is-invalid');
                valid = false;
            } else {
                pass.classList.remove('is-invalid');
                pass.classList.add('is-valid');
            }

            if (!valid) e.preventDefault();
        });
    </script>
@endpush
