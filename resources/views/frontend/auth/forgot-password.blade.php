@extends('frontend.layouts.master')

@section('title', 'Forgot Password')

@php
    $verifiedReset = session('verified_password_reset');
    $prefillUserId = old('user_id', $verifiedReset['user_id'] ?? '');
    $prefillPhone = old('phone', $verifiedReset['phone'] ?? '');
    $hasVerifiedReset = filled($prefillUserId) && filled($prefillPhone);
@endphp

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
                    <p class="text-muted text-center mb-4">
                        Enter your user ID and phone number, verify the OTP, then choose a new password.
                    </p>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <div id="alertBox"></div>

                    <div id="identitySection">
                        <div class="form-group">
                            <label for="user_id">User ID</label>
                            <input type="text" id="user_id" class="form-control" placeholder="Enter your user ID"
                                value="{{ $prefillUserId }}">
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" id="phone" class="form-control" placeholder="Enter 10 digit phone number"
                                value="{{ $prefillPhone }}">
                        </div>

                        <div class="form-group">
                            <button type="button" id="sendOtpButton" onclick="sendOtp()"
                                class="btn btn-main btn-round-full btn-block">
                                Check & Send OTP
                            </button>
                        </div>
                    </div>

                    <div id="otpSection" style="display:none;">
                        <div class="form-group">
                            <label for="otp">Enter OTP</label>
                            <input type="text" id="otp" class="form-control" placeholder="Enter 6 digit OTP"
                                maxlength="6">
                        </div>

                        <button type="button" id="verifyOtpButton" onclick="verifyOtp()"
                            class="btn btn-success btn-block">
                            Verify OTP
                        </button>
                    </div>

                    <div id="resetSection" style="display:none;">
                        <form method="POST" action="{{ route('reset.password.phone') }}">
                            @csrf

                            <input type="hidden" name="user_id" id="hiddenUserId" value="{{ $prefillUserId }}">
                            <input type="hidden" name="phone" id="hiddenPhone" value="{{ $prefillPhone }}">

                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Enter new password">
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" placeholder="Confirm new password">
                            </div>

                            <button class="btn btn-danger btn-block">
                                Reset Password
                            </button>
                        </form>
                    </div>

                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="text-color">
                            <i class="fas fa-arrow-left mr-1"></i>Back to Login
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
let currentUserId = @json($prefillUserId);
let currentPhone = @json($prefillPhone);
const hasVerifiedReset = @json($hasVerifiedReset);

function showAlert(message, type = 'success') {
    $('#alertBox').html(`<div class="alert alert-${type}">${message}</div>`);
}

function toggleIdentityInputs(readonly) {
    $('#user_id').prop('readonly', readonly);
    $('#phone').prop('readonly', readonly);
    $('#sendOtpButton').prop('disabled', readonly);
}

function resetFlow() {
    $('#otpSection').hide();
    $('#resetSection').hide();
    $('#otp').val('');
    $('#hiddenUserId').val('');
    $('#hiddenPhone').val('');
}

function sendOtp() {
    const userId = $('#user_id').val().trim();
    const phone = $('#phone').val().trim();

    if (!userId) {
        showAlert('Enter your user ID', 'danger');
        return;
    }

    if (!/^\d{10}$/.test(phone)) {
        showAlert('Enter a valid 10 digit phone number', 'danger');
        return;
    }

    resetFlow();
    showAlert('Checking account and sending OTP...', 'info');

    $.ajax({
        url: "{{ route('send.otp') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            user_id: userId,
            phone: phone,
            purpose: 'password_reset'
        },
        success: function (response) {
            if (!response.success) {
                showAlert(response.message || 'Failed to send OTP', 'danger');
                return;
            }

            currentUserId = userId;
            currentPhone = response.phone;

            $('#hiddenUserId').val(currentUserId);
            $('#hiddenPhone').val(currentPhone);
            toggleIdentityInputs(true);
            $('#otpSection').show();
            showAlert(response.message, 'success');
        },
        error: function (xhr) {
            const message = xhr.responseJSON?.message
                || xhr.responseJSON?.errors?.user_id?.[0]
                || xhr.responseJSON?.errors?.phone?.[0]
                || 'Failed to send OTP';
            showAlert(message, 'danger');
        }
    });
}

function verifyOtp() {
    const otp = $('#otp').val().trim();

    if (!currentUserId || !currentPhone) {
        showAlert('Enter your user ID and phone number first', 'danger');
        return;
    }

    if (!/^\d{6}$/.test(otp)) {
        showAlert('Enter a valid 6 digit OTP', 'danger');
        return;
    }

    $.ajax({
        url: "{{ route('verify.otp') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            user_id: currentUserId,
            phone: currentPhone,
            otp: otp,
            purpose: 'password_reset'
        },
        success: function (response) {
            if (!response.success) {
                showAlert(response.message || 'Invalid OTP', 'danger');
                return;
            }

            $('#hiddenUserId').val(currentUserId);
            $('#hiddenPhone').val(currentPhone);
            $('#otpSection').hide();
            $('#resetSection').show();
            showAlert('OTP verified successfully. You can now set a new password.', 'success');
        },
        error: function (xhr) {
            const message = xhr.responseJSON?.message
                || xhr.responseJSON?.errors?.otp?.[0]
                || xhr.responseJSON?.errors?.user_id?.[0]
                || 'Invalid OTP';
            showAlert(message, 'danger');
        }
    });
}

$(function () {
    if (hasVerifiedReset) {
        toggleIdentityInputs(true);
        $('#hiddenUserId').val(currentUserId);
        $('#hiddenPhone').val(currentPhone);
        $('#resetSection').show();
        showAlert('OTP already verified for this account. Set your new password below.', 'success');
    }
});

$('form').on('submit', function (e) {
    const password = $('#password').val().trim();
    const confirmPassword = $('#password_confirmation').val().trim();

    // Minimum 8 chars, uppercase, lowercase, number, special char
    const passwordRegex =
        /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&^#()_\-+=])[A-Za-z\d@$!%*?&^#()_\-+=]{8,}$/;

    if (!passwordRegex.test(password)) {
        e.preventDefault();
        showAlert(
            'Password must contain at least 8 characters, one uppercase letter, one lowercase letter, one number, and one special character.',
            'danger'
        );
        return false;
    }

    if (password !== confirmPassword) {
        e.preventDefault();
        showAlert('Password and confirm password do not match.', 'danger');
        return false;
    }

    return true;
});
</script>

@endsection