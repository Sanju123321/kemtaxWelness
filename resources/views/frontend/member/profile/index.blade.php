@extends('frontend.layouts.member')

@section('title', 'My Profile')

@push('styles')
<style>
    .profile-header {
        background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
        padding: 30px 0;
        color: white;
        margin-bottom: 30px;
    }

    .profile-card {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
    }

    .avatar-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: #e9f7ef;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 4px solid #28a745;
        margin: 0 auto 15px;
        font-size: 48px;
        color: #28a745;
    }

    .form-section-title {
        font-size: 14px;
        text-transform: uppercase;
        font-weight: 700;
        color: #999;
        letter-spacing: 1px;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f0f0f0;
    }

    .badge-rank {
        display: inline-block;
        padding: 5px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        background: #d4edda;
        color: #155724;
    }

    .avatar-circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        overflow: hidden;
        /* This makes image stay inside circle */
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f0f0f0;
    }

    .avatar-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Prevents stretching */
    }

    .avatar-circle i {
        font-size: 40px;
        color: #999;
    }
</style>
@endpush

@section('content')

<div class="profile-header">
    <div class="container">
        <h4 class="mb-1"><i class="fas fa-user mr-2"></i>My Profile</h4>
        <p class="mb-0 small opacity-75">Manage your account information and security settings</p>
    </div>
</div>

<div class="container" style="padding-bottom: 60px;">
    <div class="row">
        {{-- Left: Avatar & Quick Info --}}
        <div class="col-lg-4 mb-4">
            <div class="profile-card text-center">
                <div class="avatar-circle">
                    @if(auth()->user()->profile_photo)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}">
                    @else
                    <i class="fas fa-user"></i>
                    @endif
                </div>
                <h5 class="mb-1">@auth {{ Auth::user()->name }}
                    @else
                    Member @endauth
                </h5>
                <p class="text-muted small mb-2">@auth {{ Auth::user()->email }}
                    @else
                    - @endauth
                </p>
                <span class="badge-rank mb-3 d-inline-block">Active Member</span>
                <form action="{{ url('/member/profile/photo') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="file" name="photo" id="photoInput" hidden onchange="this.form.submit()">

                    <button type="button" onclick="document.getElementById('photoInput').click()"
                        class="btn btn-outline-success btn-sm btn-round-full">
                        <i class="fas fa-camera mr-1"></i>Change Photo
                    </button>
                </form>
            </div>

            <div class="profile-card p-0 overflow-hidden">
                <div
                    style="background: #f8f9fa; padding: 15px 20px; border-bottom: 1px solid #e9ecef; font-weight: 700;">
                    <i class="fas fa-chart-bar mr-2 text-color"></i>My Stats
                </div>
                @php
                $memberStats = [
                [
                'label' => 'Member Since',
                'value' => auth()->user()->created_at->format('M Y') ?? 'Jan 2026',
                ],
                ['label' => 'Total Referrals', 'value' => '0'],
                ['label' => 'Team Size', 'value' => '0'],
                ['label' => 'Total Earned', 'value' => '₹0.00'],
                ];
                @endphp
                @foreach ($memberStats as $s)
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                    <span class="text-muted small">{{ $s['label'] }}</span>
                    <strong class="text-color">{{ $s['value'] }}</strong>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Right: Edit Forms --}}
        <div class="col-lg-8">
            {{-- Personal Info --}}
            <div class="profile-card mb-4">
                <div class="form-section-title">Personal Information</div>

                @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" id="personalinformation" action="{{ url('member/profile/update') }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Full Name</label>
                            <input type="text" class="form-control" name="name"
                                value="{{ old('name', auth()->user()->name) }}">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Email Address</label>
                            <input type="email" class="form-control" name="email"
                                value="{{ old('email', auth()->user()->email) }}">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Phone Number</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">+91</span>
                                </div>
                                <input type="tel" class="form-control" name="phone"
                                    value="{{ old('phone', auth()->user()->phone) }}"
                                    placeholder="10-digit phone number" readonly>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>City</label>
                            <input type="text" class="form-control" name="city"
                                value="{{ old('city', auth()->user()->city) }}"
                                placeholder="Your city">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>State</label>
                            <select class="form-control" name="state">
                                <option value="">Select State</option>
                                @foreach (['Maharashtra','Delhi','Karnataka','Tamil Nadu','Gujarat','Rajasthan','Uttar Pradesh','West Bengal','Telangana','Madhya Pradesh'] as $state)
                                <option value="{{ $state }}"
                                    {{ old('state', auth()->user()->state) == $state ? 'selected' : '' }}>
                                    {{ $state }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Pincode</label>
                            <input type="text" class="form-control" name="pincode"
                                value="{{ old('pincode', auth()->user()->pincode) }}"
                                placeholder="6-digit pincode">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-main btn-round-full">
                        <i class="fas fa-save mr-2"></i>Save Changes
                    </button>
                </form>
            </div>

            {{-- Bank Details --}}
            <div class="profile-card mb-4">
                <div class="form-section-title">Bank Account Details (for Withdrawals)</div>
                <form method="POST" id="bankForm" action="{{ url('member/bank/save') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Account Holder Name</label>
                            <input type="text" class="form-control" name="account_holder"
                                value="{{ old('account_holder', auth()->user()->bankDetail->account_holder ?? '') }}">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Account Number</label>
                            <input type="text" class="form-control" name="account_number"
                                value="{{ old('account_number', auth()->user()->bankDetail->account_number ?? '') }}">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>IFSC Code</label>
                            <input type="text" class="form-control" name="ifsc"
                                value="{{ old('ifsc', auth()->user()->bankDetail->ifsc ?? '') }}">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Bank Name</label>
                            <input type="text" class="form-control" name="bank_name"
                                value="{{ old('bank_name', auth()->user()->bankDetail->bank_name ?? '') }}">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>UPI ID</label>
                            <input type="text" class="form-control" name="upi_id"
                                value="{{ old('upi_id', auth()->user()->bankDetail->upi_id ?? '') }}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-main btn-round-full">
                        Save Bank Details
                    </button>
                </form>
            </div>

            {{-- Change Password --}}
            <div class="profile-card">
                <div class="form-section-title">Change Password</div>

                <form method="POST" id="changePasswordForm" action="{{ url('member/change/password') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password"
                                placeholder="Current password">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>New Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="New password">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Confirm New Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                                placeholder="Confirm new password">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-main btn-round-full">
                        Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
    $(document).ready(function() {

        console.log("Validation Loaded ✅");

        // Custom Password Rule
        $.validator.addMethod("strongPassword", function(value) {
            return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{1,8}$/.test(value);
        }, "Password must contain at least 1 uppercase, 1 lowercase,  and max 8 characters");

        $("#changePasswordForm").validate({
            rules: {
                current_password: {
                    required: true,
                    maxlength: 8
                },
                password: {
                    required: true,
                    maxlength: 8,
                    strongPassword: true
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                }
            },
            messages: {
                current_password: {
                    required: "Enter current password"
                },
                password: {
                    required: "Enter new password"
                },
                password_confirmation: {
                    required: "Confirm password",
                    equalTo: "Passwords do not match"
                }
            },
            errorElement: "span",
            errorClass: "text-danger"
        });

    });
</script>
<script>
    $("#bankForm").validate({
        rules: {
            account_number: {
                required: true,

            },
            account_holder: {
                required: true,
            },
            ifsc: {
                required: true,
            },
            bank_name: {
                required: true,
            },
            upi_id: {
                required: true,
            }
        },
        messages: {
            account_number: {
                required: "Enter account number"
            },
            account_holder: {
                required: "Enter account holder name"
            },
            ifsc: {
                required: "Enter IFSC code"
            },
            bank_name: {
                required: "Enter bank name"
            },
            upi_id: {
                required: "Enter UPI ID"
            }
        },
        errorElement: "span",
        errorClass: "text-danger"
    });
</script>
<script>
    $("#personalinformation").validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true
            },
            phone: {
                required: true,
                maxlength: 10,
                minlength: 10,
                digits: true
            },
            city: {
                required: true,
            },
            state: {
                required: true,
            },
            pincode: {
                required: true,
            }
        },
        messages: {
            name: {
                required: "Enter your name"
            },
            email: {
                required: "Enter your email",
                email: "Enter a valid email"
            },
            phone: {
                required: "Enter your phone number",
                maxlength: "Phone number must be 10 digits",
                minlength: "Phone number must be 10 digits",
                digits: "Phone number must contain only digits"

            },
            city: {
                required: "Enter your city"
            },
            state: {
                required: "Select your state"
            },
            pincode: {
                required: "Enter your pincode"
            },

        },
        errorElement: "span",
        errorClass: "text-danger"
    });
</script>
@endpush