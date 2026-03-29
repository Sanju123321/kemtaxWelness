@extends('frontend.layouts.member')

@section('title', 'Complete Your Setup')

@push('styles')
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .setup-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 15px;
        }

        .header-welcome {
            background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
            color: white;
            padding: 50px 30px;
            border-radius: 15px;
            margin-bottom: 40px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .status-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border-left: 4px solid #ff6b6b;
            text-align: center;
        }

        .plan-card-wrapper {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 2px solid #28a745;
        }

        .plan-card-header {
            background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .plan-price {
            font-size: 48px;
            font-weight: 800;
        }

        .feature-item {
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .feature-item:last-child {
            border-bottom: none;
        }

        .btn-pay {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            text-transform: uppercase;
        }

        .btn-pay:hover {
            opacity: 0.9;
        }

        .referral-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 2px solid #ff6b6b;
            opacity: 0.7;
        }
    </style>
@endpush

@section('content')
    <div class="setup-container">

        {{-- Welcome Header --}}
        <div class="header-welcome">
            <h1 style="font-size: 36px; font-weight: 800; margin-bottom: 10px;">
                🎉 Welcome to Kemtex Wellness!
            </h1>
            <p style="font-size: 16px; opacity: 0.95; margin: 0;">
                Complete your first plan payment to activate your account and start earning
            </p>
        </div>

        {{-- Alert --}}
        <div
            style="background: linear-gradient(135deg, #fff3cd 0%, #ffe69c 100%); border-left: 4px solid #ffc107; padding: 20px; border-radius: 8px; margin-bottom: 30px; display: flex; align-items: flex-start; gap: 15px;">
            <i class="fas fa-exclamation-circle" style="font-size: 24px; color: #ff9800; flex-shrink: 0;"></i>
            <div>
                <h6 style="margin: 0 0 5px 0; font-weight: 700; color: #333;">Account Setup Required</h6>
                <p style="margin: 0; font-size: 14px; color: #666;">Your account is active but needs a plan to unlock
                    referral features and start earning. Complete payment to proceed.</p>
            </div>
        </div>

        {{-- Status Cards --}}
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="status-card">
                    <i class="fas fa-clock fa-2x mb-3 text-danger"></i>
                    <div class="text-muted small text-uppercase font-weight-bold mb-1">Account Status</div>
                    <div class="font-weight-bold" style="color: #ff6b6b;">Pending Payment</div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="status-card">
                    <i class="fas fa-users fa-2x mb-3 text-warning"></i>
                    <div class="text-muted small text-uppercase font-weight-bold mb-1">Referrals</div>
                    <div class="font-weight-bold">0</div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="status-card">
                    <i class="fas fa-wallet fa-2x mb-3 text-secondary"></i>
                    <div class="text-muted small text-uppercase font-weight-bold mb-1">Wallet Balance</div>
                    <div class="font-weight-bold">₹0.00</div>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="row">
            {{-- Plan Card --}}
            <div class="col-md-6 mb-4">
                <div class="plan-card-wrapper">
                    <div class="plan-card-header">
                        <div
                            style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; opacity: 0.9;">
                            ⭐ Starter Plan</div>
                        <div style="font-size: 22px; font-weight: 700; margin: 10px 0 5px;">Starter</div>
                        <div style="font-size: 12px; opacity: 0.8;">Lifetime Membership</div>
                        <div class="plan-price">₹1,000</div>
                        <p style="font-size: 12px; opacity: 0.9; margin: 0;">One-time payment • Lifetime access</p>
                    </div>
                    <div class="p-4">
                        @php
                            $features = [
                                'Referral Program Access',
                                'Wallet Features',
                                'Commission on Referrals',
                                'Genealogy Tree View',
                                'Email Support',
                                'Upgrade Anytime',
                            ];
                        @endphp
                        @foreach ($features as $feature)
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success"></i>
                                <span>{{ $feature }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="p-4 bg-light" style="border-top: 1px solid #e0e0e0;">
                        <a href="{{ route('pricing') }}"
                            class="btn-pay d-block text-white text-center text-decoration-none">
                            <i class="fas fa-lock-open mr-2"></i>Complete Payment
                        </a>
                        <p class="text-muted text-center mt-2 mb-0 small">Secure payment powered by Razorpay</p>
                    </div>
                </div>
            </div>

            {{-- Referral Card (locked) --}}
            <div class="col-md-6 mb-4">
                <div class="referral-card">
                    <div
                        style="background: linear-gradient(135deg, #ff6b6b 0%, #d63031 100%); color: white; padding: 30px; text-align: center;">
                        <h4><i class="fas fa-lock mr-2"></i>Invite &amp; Earn</h4>
                        <p class="mb-0 small opacity-90">Unlock after plan payment</p>
                    </div>
                    <div class="p-5 text-center">
                        <i class="fas fa-lock fa-4x text-danger mb-4 opacity-50"></i>
                        <h5 class="text-danger">Referral Feature Locked</h5>
                        @php
                            $steps = [
                                'Complete your ₹1,000 plan payment',
                                'Unlock referral features instantly',
                                'Start inviting and earning commissions',
                            ];
                        @endphp
                        <div class="mt-4 text-left">
                            @foreach ($steps as $i => $step)
                                <div class="d-flex align-items-center mb-3" style="gap: 12px;">
                                    <div
                                        style="background: #ff6b6b; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">
                                        {{ $i + 1 }}</div>
                                    <span class="text-muted">{{ $step }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
