@extends('backend.layouts.app')

@section('title', 'Change Password')

@section('content')
    <h1 class="mt-4">Change Password</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Change Password</li>
    </ol>

    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-key me-2"></i> Change Admin Password
                </div>
                <div class="card-body p-4">

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

                    <form method="POST" action="{{ route('admin.change.password.post') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Current Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                    name="current_password" id="currentPassword" placeholder="Enter current password"
                                    required />
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="togglePassword('currentPassword', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" id="newPassword" placeholder="Minimum 8 characters" required />
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="togglePassword('newPassword', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Confirm New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password_confirmation"
                                    id="confirmPassword" placeholder="Repeat new password" required />
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="togglePassword('confirmPassword', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Password
                            </button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
@endpush
