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
                    <p class="text-muted text-center mb-4">
                        Enter your phone number to receive OTP and reset your password.
                    </p>

                    {{-- ALERT --}}
                    <div id="alertBox"></div>

                    {{-- PHONE --}}
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" id="phone" class="form-control"
                            placeholder="Enter 10 digit phone">
                    </div>

                    <div class="form-group">
                        <button type="button" onclick="sendOtp()"
                            class="btn btn-main btn-round-full btn-block">
                            Send OTP
                        </button>
                    </div>

                    {{-- OTP --}}
                    <div id="otpSection" style="display:none;">
                        <div class="form-group">
                            <label>Enter OTP</label>
                            <input type="text" id="otp" class="form-control"
                                placeholder="Enter 4 digit OTP" maxlength="4" pattern="[0-9]{4}">
                        </div>

                        <button type="button" onclick="verifyOtp()"
                            class="btn btn-success btn-block">
                            Verify OTP
                        </button>
                    </div>

                    {{-- RESET PASSWORD --}}
                    <div id="resetSection" style="display:none;">
                        <form method="POST" action="{{ url('/reset-password-phone') }}">
                            @csrf

                            <input type="hidden" name="phone" id="hiddenPhone">

                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" name="password" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control">
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

let currentPhone = '';

function showAlert(msg, type = 'success') {
    $('#alertBox').html(
        `<div class="alert alert-${type}">${msg}</div>`
    );
}

// SEND OTP
function sendOtp() {

    let phone = $('#phone').val();

    if (phone.length != 10) {
        showAlert('Enter valid 10 digit number', 'danger');
        return;
    }

    $.ajax({
        url: "{{ url('/send-otp') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            phone: phone
        },
        success: function (res) {

            if (res.success) {

                currentPhone = res.phone;

                showAlert(res.message, 'success');

                $('#otpSection').show();

            } else {
                showAlert(res.message, 'danger');
            }
        },
        error: function () {
            showAlert('Failed to send OTP', 'danger');
        }
    });
}


// VERIFY OTP
function verifyOtp() {

    let otp = $('#otp').val();

    $.ajax({
        url: "{{ url('/verify-otp') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            phone: currentPhone,
            otp: otp
        },
        success: function (res) {

            if (res.success) {

                showAlert('OTP Verified Successfully', 'success');

                $('#hiddenPhone').val(currentPhone);

                $('#otpSection').hide();
                $('#resetSection').show();

            } else {
                showAlert(res.message, 'danger');
            }
        },
        error: function () {
            showAlert('Invalid OTP', 'danger');
        }
    });
}

</script>

@endsection