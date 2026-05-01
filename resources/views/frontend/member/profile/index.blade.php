@extends('frontend.layouts.member')

@section('title', 'My Profile')

@push('styles')
<style>
    .dash-layout {
        display: flex;
        align-items: flex-start;
        background: #f4f6f9;
        min-height: calc(100vh - 80px);
    }

    .dash-sidebar {
        width: 230px;
        flex-shrink: 0;
        background: white;
        min-height: calc(100vh - 80px);
        box-shadow: 2px 0 12px rgba(0, 0, 0, .06);
        position: sticky;
        top: 0;
        display: flex;
        flex-direction: column;
    }

    .sidebar-user { display: flex; align-items: center; gap: 12px; padding: 20px 18px 16px; border-bottom: 1px solid #f0f0f0; }
    .sidebar-user .u-name { font-size: 13px; font-weight: 700; color: #333; line-height: 1.3; }
    .sidebar-user .u-role { font-size: 11px; font-weight: 600; }
    .sidebar-nav { padding: 10px 0; flex: 1; }
    .sidebar-nav .nav-label { padding: 10px 18px 4px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #aaa; }
    .sidebar-nav a { display: flex; align-items: center; gap: 10px; padding: 11px 18px; font-size: 14px; font-weight: 500; color: #555; text-decoration: none; border-left: 3px solid transparent; transition: all .15s; }
    .sidebar-nav a:hover { background: #f4f9f6; color: #28a745; border-left-color: #28a745; text-decoration: none; }
    .sidebar-nav a.active { background: #eaf7ef; color: #28a745; font-weight: 700; border-left-color: #28a745; }
    .sidebar-nav a.disabled,
    .sidebar-nav a.disabled:hover { pointer-events: none; color: #bbb !important; background: #f8f9fa !important; border-left-color: #eee !important; opacity: .7; }
    .sidebar-nav a i.nav-icon { width: 18px; text-align: center; font-size: 14px; }
    .sidebar-footer { padding: 14px 18px; border-top: 1px solid #f0f0f0; }
    .dash-main { flex: 1; min-width: 0; padding: 24px 20px 60px; }

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

    @media (max-width: 991px) {
        .dash-layout { display: block; }
        .dash-sidebar { display: none; }
        .dash-main { padding: 14px 12px 40px; }
    }
</style>
@endpush

@section('content')
@php $isInactive = auth()->check() && auth()->user()->status == 'inactive'; @endphp
<div class="dash-layout">
    <aside class="dash-sidebar">
        <div class="sidebar-user">
            <div style="background:{{ $isInactive ? '#f8d7da' : '#e9f7ef' }};border:2px solid {{ $isInactive ? '#dc3545' : '#28a745' }};border-radius:50%;width:40px;height:40px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fas fa-user {{ $isInactive ? 'text-danger' : 'text-success' }}" style="font-size:18px;"></i>
            </div>
            <div>
                <div class="u-name">{{ Auth::user()->name ?? 'Member' }}</div>
                <div class="u-role" style="color:{{ $isInactive ? '#dc3545' : '#28a745' }};"><i class="fas fa-circle" style="font-size:7px;margin-right:3px;"></i>{{ ucfirst(Auth::user()->status ?? 'inactive') }}</div>
            </div>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-label">Main Menu</div>
            <a href="{{ route('member.dashboard') }}"><i class="fas fa-tachometer-alt nav-icon"></i> Dashboard</a>
            <a href="{{ route('member.wallet') }}" class="{{ request()->routeIs('member.wallet') ? 'active' : '' }}{{ $isInactive ? ' disabled' : '' }}"><i class="fas fa-wallet nav-icon"></i> Wallet</a>
            <div class="nav-label">My Team</div>
            <a href="{{ route('member.team') }}" class="{{ request()->routeIs('member.team') ? 'active' : '' }}"><i class="fas fa-sitemap nav-icon"></i> Genealogy Tree</a>
            <a href="{{ route('member.credentials') }}" class="{{ request()->routeIs('member.credentials') ? 'active' : '' }}{{ $isInactive ? ' disabled' : '' }}"><i class="fas fa-award nav-icon"></i> My Achievements</a>
            <div class="nav-label">Account</div>
            <a href="{{ route('member.kyc.index') }}" class="{{ request()->routeIs('member.kyc*') ? 'active' : '' }}"><i class="fas fa-id-card nav-icon"></i> KYC Documents</a>
            <a href="{{ route('member.profile') }}" class="active"><i class="fas fa-user-edit nav-icon"></i> My Profile</a>
            <div class="nav-label">More</div>
            <a href="{{ route('pricing') }}" class="{{ request()->routeIs('pricing') ? 'active' : '' }}"><i class="fas fa-tags nav-icon"></i> Pricing &amp; Plans</a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}"><i class="fas fa-headset nav-icon"></i> Support</a>
            <a href="{{ route('member.commissions.history') }}" class="{{ $isInactive ? 'disabled' : '' }}"><i class="fas fa-hand-holding-usd nav-icon"></i> Recent Commissions</a>
        </nav>
        <div class="sidebar-footer">
            <a href="{{ route('logout') }}" style="display:flex;align-items:center;gap:10px;font-size:14px;color:#dc3545;font-weight:600;text-decoration:none;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </aside>
    <div class="dash-main">
<div class="profile-header">
    <div class="container-fluid px-0">
        <h4 class="mb-1"><i class="fas fa-user mr-2"></i>My Profile</h4>
        <p class="mb-0 small opacity-75">Manage your account information and security settings</p>
    </div>
</div>

<div class="container-fluid px-0" style="padding-bottom: 60px;">
    <div class="row">
        {{-- Left: Avatar & Quick Info --}}
        <div class="col-lg-4 mb-4">
            <div class="profile-card text-center">
                <div class="avatar-circle">
                    @if(auth()->user()->profile_photo)
                    <img src="{{ Storage::url(auth()->user()->profile_photo) }}"
                        alt="Profile Photo"
                        onerror="this.style.display='none';this.parentElement.querySelector('i').style.display='block';">
                    @else
                    <i class="fas fa-user"></i>
                    @endif
                </div>
                <h5 class="mb-1">@auth {{ Auth::user()->name }}
                    @else
                    Member @endauth
                </h5>
                <p class="text-muted small mb-2">@auth {{ Auth::user()->user_id }}
                    @else
                    - @endauth
                </p>
                <span class="badge-rank mb-3 d-inline-block 
    @auth 
        {{ Auth::user()->status == 'active' ? 'bg-success' : 'bg-danger' }} 
    @else 
        bg-danger 
    @endauth">

                    @auth
                    {{ ucfirst(Auth::user()->status) }}
                    @else
                    Inactive Member
                    @endauth

                </span>
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
                            'value' => $user->created_at?->format('M Y') ?? 'Jan 2026',
                        ],
                        ['label' => 'Total Referrals', 'value' => $totalReferrals ?? 0],
                        ['label' => 'Team Size', 'value' => $teamSize ?? 0],
                        ['label' => 'Total Earned', 'value' => '₹' . number_format((float) ($user->total_earned ?? 0), 2)],
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
                        <div class="col-12 form-group">
                            <label>User ID</label>
                            <input type="text" class="form-control bg-light" value="{{ auth()->user()->user_id }}"
                                disabled readonly aria-readonly="true">
                        </div>

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
                                @foreach ([
                                'Andhra Pradesh',
                                'Arunachal Pradesh',
                                'Assam',
                                'Bihar',
                                'Chhattisgarh',
                                'Goa',
                                'Gujarat',
                                'Haryana',
                                'Himachal Pradesh',
                                'Jharkhand',
                                'Karnataka',
                                'Kerala',
                                'Madhya Pradesh',
                                'Maharashtra',
                                'Manipur',
                                'Meghalaya',
                                'Mizoram',
                                'Nagaland',
                                'Odisha',
                                'Punjab',
                                'Rajasthan',
                                'Sikkim',
                                'Tamil Nadu',
                                'Telangana',
                                'Tripura',
                                'Uttar Pradesh',
                                'Uttarakhand',
                                'West Bengal',
                                'Andaman and Nicobar Islands',
                                'Chandigarh',
                                'Dadra and Nagar Haveli and Daman and Diu',
                                'Delhi',
                                'Jammu and Kashmir',
                                'Ladakh',
                                'Lakshadweep',
                                'Puducherry',
                                ] as $state)
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

                        <div class="col-12 form-group">
                            <label>Address</label>
                            <textarea class="form-control" name="address" rows="3"
                                placeholder="Street, area, landmark">{{ old('address', auth()->user()->address) }}</textarea>
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