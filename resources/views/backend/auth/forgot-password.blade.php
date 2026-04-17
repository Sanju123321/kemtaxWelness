@extends('backend.layouts.auth')

@section('title', 'Forgot Password')

@section('content')
    <div class="auth-card">

        {{-- Header --}}
        <div class="auth-header" style="background: linear-gradient(135deg, #92400e 0%, #d97706 100%)">
            <div class="brand-icon">
                <i class="fas fa-key fa-xl" style="color:#fff"></i>
            </div>
            <h4>Reset Password</h4>
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

            {{-- Step 1: Verify email --}}
            @if (!session('reset_email'))
                <p class="text-muted small mb-3">
                    <i class="fas fa-info-circle me-1 text-info"></i>
                    Enter your admin email address to verify your identity.
                </p>
                <form method="POST" action="{{ route('admin.forgot.password.post') }}" novalidate id="verifyForm">
                    @csrf
                    <input type="hidden" name="step" value="verify_email" />
                    <div class="mb-4">
                        <label class="input-label" for="email">Admin Email</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fas fa-envelope fa-sm"></i></span>
                            <input type="email" id="email" name="email"
                                class="form-control @error('email') is-invalid @enderror" placeholder="admin@example.com"
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
                            <i class="fas fa-magnifying-glass me-1"></i> Verify Email
                        </button>
                    </div>
                </form>

                {{-- Step 2: Set new password --}}
            @else
                <div class="alert alert-success py-2 mb-3" style="border-radius:10px;font-size:.85rem">
                    <i class="fas fa-circle-check me-1"></i>
                    Verified: <strong>{{ session('reset_email') }}</strong>
                </div>
                <form method="POST" action="{{ route('admin.forgot.password.post') }}" novalidate id="resetForm">
                    @csrf
                    <input type="hidden" name="step" value="reset_password" />
                    <input type="hidden" name="email" value="{{ session('reset_email') }}" />

                    <div class="mb-3">
                        <label class="input-label" for="password">New Password</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fas fa-lock fa-sm"></i></span>
                            <input type="password" id="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Minimum 8 characters" required minlength="8" />
                            <button class="btn btn-eye" type="button" onclick="togglePwd('password','icon1')"
                                tabindex="-1">
                                <i class="fas fa-eye fa-sm" id="icon1"></i>
                            </button>
                            <div class="invalid-feedback">
                                @error('password')
                                    {{ $message }}
                                @else
                                    Password must be at least 8 characters.
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="input-label" for="password_confirmation">Confirm Password</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fas fa-lock fa-sm"></i></span>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control" placeholder="Repeat password" required />
                            <button class="btn btn-eye" type="button" onclick="togglePwd('password_confirmation','icon2')"
                                tabindex="-1">
                                <i class="fas fa-eye fa-sm" id="icon2"></i>
                            </button>
                            <div class="invalid-feedback" id="confirmMsg">Passwords do not match.</div>
                        </div>
                    </div>
                    <hr class="auth-divider">
                    <div class="d-flex align-items-center justify-content-between">
                        <a href="{{ route('admin.login') }}" class="back-link">
                            <i class="fas fa-arrow-left fa-sm"></i> Back to Login
                        </a>
                        <button type="submit" class="btn btn-auth-success">
                            <i class="fas fa-floppy-disk me-1"></i> Update Password
                        </button>
                    </div>
                </form>
            @endif
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
        function togglePwd(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            input.type = input.type === 'password' ? 'text' : 'password';
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        }

        // Live confirm-password match check
        const pwdField = document.getElementById('password');
        const confirmField = document.getElementById('password_confirmation');
        if (confirmField) {
            const check = () => {
                if (confirmField.value && confirmField.value !== pwdField.value) {
                    confirmField.classList.add('is-invalid');
                } else {
                    confirmField.classList.remove('is-invalid');
                    if (confirmField.value) confirmField.classList.add('is-valid');
                }
            };
            confirmField.addEventListener('input', check);
            pwdField && pwdField.addEventListener('input', check);
        }

        // Reset form submit validation
        const resetForm = document.getElementById('resetForm');
        if (resetForm) {
            resetForm.addEventListener('submit', function(e) {
                let valid = true;
                if (!pwdField.value || pwdField.value.length < 8) {
                    pwdField.classList.add('is-invalid');
                    valid = false;
                } else {
                    pwdField.classList.remove('is-invalid');
                }
                if (!confirmField.value || confirmField.value !== pwdField.value) {
                    confirmField.classList.add('is-invalid');
                    valid = false;
                } else {
                    confirmField.classList.remove('is-invalid');
                }
                if (!valid) e.preventDefault();
            });
        }
    </script>
@endpush
