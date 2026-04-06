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

                        <form id ="registerForm" method="POST" action="{{ route('register.post') }}">
                            @csrf

                            <div class="form-group mb-4">
                                <label for="name"><i class="fas fa-user text-color mr-2"></i>Full Name</label>
                                <input type="text"
                                    class="form-control form-control-lg @error('name') is-invalid @enderror" id="name"
                                    name="name" placeholder="Enter your full name" value="{{ old('name') }}">
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
                                    <div class="input-group-append">
<button type="button" onclick="sendOtpCode(event)" class="btn btn-outline-primary btn-sm">                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Click button to send OTP</small>
                            </div>
<input type="hidden" id="otp_verified" name="otp_verified" value="0">
                            <div class="form-group mb-4">
                                <label for="email"><i class="fas fa-envelope text-color mr-2"></i>Email Address</label>
                                <input type="email"
                                    class="form-control form-control-lg @error('email') is-invalid @enderror" id="email"
                                    name="email" placeholder="Enter your email address" value="{{ old('email') }}"
                                    >
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

    <div class="input-group">
        <input type="password"
            class="form-control form-control-lg"
            id="password"
            name="password"
            placeholder="Create a strong password"
            required>

        <div class="input-group-append">
            <span class="input-group-text toggle-password" data-target="#password" style="cursor:pointer;">
                <i class="fa fa-eye"></i>
            </span>
        </div>
    </div>
</div>
            <div class="form-group mb-4">
    <label for="password_confirmation"><i class="fas fa-lock text-color mr-2"></i>Confirm Password</label>

    <div class="input-group">
        <input type="password"
            class="form-control form-control-lg"
            id="password_confirmation"
            name="password_confirmation"
            placeholder="Re-enter your password"
            required>

        <div class="input-group-append">
            <span class="input-group-text toggle-password" data-target="#password_confirmation" style="cursor:pointer;">
                <i class="fa fa-eye"></i>
            </span>
        </div>
    </div>
</div>

                            <div class="form-group mb-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="terms" name="terms"
                                        >
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

    <!-- OTP Verification Modal -->
    <div class="modal fade" id="otpModal" tabindex="-1" role="dialog" aria-labelledby="otpModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="otpModalLabel">Verify Your Phone Number</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">We've sent a 6-digit OTP to your phone number. Please enter it below to verify.</p>
                    <form id="otpForm">
                        <div class="form-group">
                            <label for="otp">Enter OTP</label>
                            <input type="text" class="form-control form-control-lg text-center" id="otp" name="otp" 
                                   placeholder="000000" maxlength="6" pattern="[0-9]{6}" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-main btn-lg">Verify OTP</button>
                        </div>
                    </form>
                    <div class="text-center mt-3">
                        <small class="text-muted">Didn't receive OTP? <a href="#" id="resendOtp" onclick="sendOtpCode(event)">Resend</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>

<script>
$(document).ready(function () {

    $("#registerForm").validate({
        rules: {
            name: {
                required: true,
                minlength: 3
            },
            phone: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 8,
                pwcheck: true
            },
            password_confirmation: {
                required: true,
                equalTo: "#password"
            },
            terms: {
                required: true
            }
        },

        messages: {
            name: "Enter your full name",
            phone: {
                required: "Enter phone number",
                digits: "Only numbers allowed",
                minlength: "Must be 10 digits",
                maxlength: "Must be 10 digits"
            },
            email: "Enter valid email",
            password: {
                required: "Enter password",
                minlength: "Minimum 8 characters"
            },
            password_confirmation: {
                required: "Confirm your password",
                equalTo: "Passwords do not match"
            },
            terms: "You must accept terms"
        },

        errorElement: "div",
        errorClass: "text-danger mt-1",

        // ⭐ FIX: ERROR POSITION BELOW INPUT
        errorPlacement: function (error, element) {

            if (element.closest('.input-group').length) {
                error.insertAfter(element.closest('.input-group'));
            } 
            else if (element.attr("type") === "checkbox") {
                error.insertAfter(element.closest('.custom-control'));
            } 
            else {
                error.insertAfter(element);
            }
        },

        highlight: function (element) {
            $(element).addClass('is-invalid');
        },

        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        },

        submitHandler: function (form) {

            // OTP CHECK
            if ($("#otp_verified").val() !== "1") {
                alert("Please verify your phone first");
                return false;
            }

            form.submit();
        }
    });

    // 🔐 Password validation
    $.validator.addMethod("pwcheck", function (value) {
        return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/.test(value);
    }, "Password must contain uppercase, lowercase and number");

});
</script>
<script>
function sendOtpCode(event) {
    const phone = document.getElementById('phone').value;

    if (!phone || phone.length !== 10) {
        alert('Enter valid 10-digit phone');
        return;
    }

    const button = event.target;
    const originalText = button.innerHTML;

    button.disabled = true;
    button.innerHTML = 'Sending...';

    fetch('{{ route("send.otp") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ phone: phone })
    })
    .then(res => res.json())
    .then(data => {
        console.log(data); // DEBUG

        if (data.success) {
            $('#otpModal').modal('show');
        } else {
            alert(data.message);
        }
    })
    .catch(err => {
        console.log(err);
        alert('Error occurred');
    })
    .finally(() => {
        button.disabled = false;
        button.innerHTML = originalText;
    });
}

</script>
<script>
document.getElementById('otpForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const otp = document.getElementById('otp').value;
    const phone = document.getElementById('phone').value;

    fetch('{{ route("verify.otp") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ phone: phone, otp: otp })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {

            // ✅ Mark verified
            document.getElementById('otp_verified').value = "1";

            // ✅ Disable phone field
            $('#phone').prop('readonly', true);

            // ✅ Disable send OTP button
            $('button[onclick="sendOtpCode(event)"]').prop('disabled', true);

            // ✅ Show VERIFIED text
            if ($('#verifiedText').length === 0) {
                $('#phone').closest('.input-group').after(
                    '<div id="verifiedText" class="text-success mt-1">✔ Phone Verified</div>'
                );
            }

            // ✅ Close modal
            $('#otpModal').modal('hide');

        } else {
            alert(data.message);
        }
    })
    .catch(() => alert('Verification failed'));
});
</script>
<script>
$(document).on('click', '.toggle-password', function () {

    let input = $($(this).attr("data-target"));
    let icon = $(this).find("i");

    if (input.attr("type") === "password") {
        input.attr("type", "text");
        icon.removeClass("fa-eye").addClass("fa-eye-slash");
    } else {
        input.attr("type", "password");
        icon.removeClass("fa-eye-slash").addClass("fa-eye");
    }

});
</script>
<script>
$('#phone').on('blur', function () {

    let phone = $(this).val();

    if (phone.length !== 10) return;

    fetch('{{ route("check.phone") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ phone: phone })
    })
    .then(res => res.json())
    .then(data => {

        // Remove old message
        $('#phone-exists-error').remove();

        if (data.exists) {

            // Show error below input
            $('#phone').closest('.input-group').after(
                '<div id="phone-exists-error" class="text-danger mt-1">Phone number already registered</div>'
            );

            // Disable OTP button
            $('button[onclick="sendOtpCode(event)"]').prop('disabled', true);

        } else {

            // Enable OTP button
            $('button[onclick="sendOtpCode(event)"]').prop('disabled', false);
        }
    });

});
</script>
@endsection
