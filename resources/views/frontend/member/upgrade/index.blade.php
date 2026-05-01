@extends('frontend.layouts.member')

@section('title', 'Upgrade Plan')

@push('styles')
    <style>
        /* ── Layout ─────────────────────────────────────────── */
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

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 20px 18px 16px;
            border-bottom: 1px solid #f0f0f0;
        }

        .sidebar-user .u-name {
            font-size: 13px;
            font-weight: 700;
            color: #333;
            line-height: 1.3;
        }

        .sidebar-user .u-role {
            font-size: 11px;
            font-weight: 600;
        }

        .sidebar-nav {
            padding: 10px 0;
            flex: 1;
        }

        .sidebar-nav .nav-label {
            padding: 10px 18px 4px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #aaa;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 18px;
            font-size: 14px;
            font-weight: 500;
            color: #555;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all .15s;
        }

        .sidebar-nav a:hover {
            background: #f4f9f6;
            color: #28a745;
            border-left-color: #28a745;
            text-decoration: none;
        }

        .sidebar-nav a.active {
            background: #eaf7ef;
            color: #28a745;
            font-weight: 700;
            border-left-color: #28a745;
        }

        .sidebar-nav a.disabled,
        .sidebar-nav a.disabled:hover {
            pointer-events: none;
            color: #bbb !important;
            background: #f8f9fa !important;
            border-left-color: #eee !important;
            opacity: .7;
        }

        .sidebar-nav a i.nav-icon {
            width: 18px;
            text-align: center;
            font-size: 14px;
        }

        .sidebar-footer {
            padding: 14px 18px;
            border-top: 1px solid #f0f0f0;
        }

        .dash-main {
            flex: 1;
            min-width: 0;
            padding: 24px 20px 60px;
        }

        .mobile-sidebar-toggle,
        .mobile-sidebar-backdrop {
            display: none;
        }

        .mobile-sidebar-toggle {
            border: 1px solid #dce4e8;
            background: #fff;
            color: #2f3a44;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 14px;
            align-items: center;
            gap: 8px;
            touch-action: manipulation;
        }

        @media (max-width:768px) {
            .dash-sidebar {
                display: flex;
                position: fixed;
                left: 0;
                top: 0;
                z-index: 1051;
                height: 100vh;
                width: min(84vw, 300px);
                min-height: 100vh;
                transform: translateX(-100%);
                transition: transform .22s ease;
            }

            .dash-main {
                padding: 14px 12px 40px;
            }

            .mobile-sidebar-toggle {
                display: inline-flex;
            }

            .mobile-sidebar-backdrop {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(16, 24, 32, .45);
                z-index: 1050;
                opacity: 0;
                visibility: hidden;
                transition: opacity .2s ease;
            }

            body.mobile-sidebar-open {
                overflow: hidden;
            }

            body.mobile-sidebar-open .dash-sidebar {
                transform: translateX(0);
            }

            body.mobile-sidebar-open .mobile-sidebar-backdrop {
                opacity: 1;
                visibility: visible;
            }
        }

        /* ── Plan Cards ─────────────────────────────────────── */
        .plan-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .plan-card {
            border-radius: 16px;
            border: 1px solid rgba(15, 23, 42, .08);
            padding: 16px 16px 14px;
            text-align: center;
            box-shadow: 0 10px 24px rgba(15, 23, 42, .08);
            position: relative;
            display: flex;
            flex-direction: column;
            min-height: 300px;
        }

        .plan-card.upgradeable:hover {
            transform: translateY(-3px);
        }

        .plan-card.plan-0 { background: linear-gradient(135deg, #f5c58d, #f2dcc2); }
        .plan-card.plan-1 { background: linear-gradient(135deg, #e8e8e8, #f9f9f9); }
        .plan-card.plan-2 { background: linear-gradient(135deg, #ffe86e, #fff8cf); }
        .plan-card.plan-3 { background: linear-gradient(135deg, #64d983, #d7f7e0); }
        .plan-card.plan-4 { background: linear-gradient(135deg, #54a7ff, #d6ebff); }

        .plan-pill {
            width: fit-content;
            margin: 0 auto 12px;
            border-radius: 999px;
            color: #fff;
            background: #1f2937;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .03em;
            text-transform: uppercase;
            padding: 7px 14px;
        }

        .plan-name {
            font-size: 14px;
            font-weight: 800;
            color: #111827;
            margin-bottom: 6px;
        }

        .plan-price {
            font-size: clamp(2rem, 2.4vw, 2.8rem);
            font-weight: 900;
            line-height: 1;
            color: #111827;
            margin-bottom: 8px;
        }

        .plan-detail {
            font-size: 15px;
            color: #364152;
            margin-bottom: 10px;
            min-height: 48px;
        }

        .btn-upgrade,
        .btn-disabled {
            margin-top: auto;
            width: 100%;
            height: 44px;
            border: 0;
            border-radius: 999px;
            font-size: 22px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-upgrade {
            background: #ff8a00;
            color: #fff;
        }

        .btn-disabled {
            background: #8b98a8;
            color: #e5e7eb;
            cursor: not-allowed;
        }

        .btn-disabled.active-plan {
            background: #28a745;
            color: #fff;
        }

        @media (max-width: 1399px) {
            .plan-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 767px) {
            .plan-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    @php
        $isInactive = auth()->check() && auth()->user()->status == 'inactive';
        $currentPrice = $currentPlan?->price ?? 0;
        $planPills = ['Bronze Core', 'Silver Edge', 'Gold Rise', 'Platinum Force', 'Diamond Elite'];
    @endphp

    <div class="dash-layout">

        {{-- Sidebar --}}
        <aside class="dash-sidebar">
            <div class="sidebar-user">
                <div
                    style="background:{{ $isInactive ? '#f8d7da' : '#e9f7ef' }};border:2px solid {{ $isInactive ? '#dc3545' : '#28a745' }};border-radius:50%;width:40px;height:40px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fas fa-user {{ $isInactive ? 'text-danger' : 'text-success' }}" style="font-size:18px;"></i>
                </div>
                <div>
                    <div class="u-name">@auth{{ Auth::user()->name }}
                    @else
                    Member @endauth
                </div>
                <div class="u-role" style="color:{{ $isInactive ? '#dc3545' : '#28a745' }};">
                    <i class="fas fa-circle" style="font-size:7px;margin-right:3px;"></i>
                    @auth{{ ucfirst(Auth::user()->status) }}
                @else
                Inactive @endauth
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-label">Main Menu</div>
        <a href="{{ route('member.dashboard') }}"><i class="fas fa-tachometer-alt nav-icon"></i> Dashboard</a>
        <a href="{{ route('member.wallet') }}" class="{{ $isInactive ? 'disabled' : '' }}"><i
                class="fas fa-wallet nav-icon"></i> Wallet</a>
        <a href="{{ route('member.credentials') }}" class="{{ $isInactive ? 'disabled' : '' }}"><i
                class="fas fa-award nav-icon"></i> Credentials</a>
        <div class="nav-label">Account</div>
        <a href="{{ route('member.kyc.index') }}" class="{{ request()->routeIs('member.kyc*') ? 'active' : '' }}">
            <i class="fas fa-id-card nav-icon"></i> KYC Documents
        </a>
        <a href="{{ route('member.profile') }}"
            class="{{ request()->routeIs('member.profile') ? 'active' : '' }}">
            <i class="fas fa-user-edit nav-icon"></i> My Profile
        </a>
        <div class="nav-label">More</div>
        <a href="{{ route('member.upgrade') }}" class="active"><i class="fas fa-arrow-circle-up nav-icon"></i>
            Upgrade Plan</a>
        <a href="{{ route('contact') }}"><i class="fas fa-headset nav-icon"></i> Support</a>
        <div class="nav-label">My Team</div>
        <a href="{{ route('member.team') }}"><i
                class="fas fa-sitemap nav-icon"></i> Genealogy Tree</a>
    </nav>

    <div class="sidebar-footer">
        <a href="{{ route('logout') }}"
            style="background:none;border:none;padding:0;width:100%;text-align:left;display:flex;align-items:center;gap:10px;font-size:14px;color:#dc3545;font-weight:600;cursor:pointer;text-decoration:none;">
            <i class="fas fa-sign-out-alt" style="width:18px;text-align:center;"></i> Logout
        </a>
    </div>
</aside>
<div class="mobile-sidebar-backdrop" data-sidebar-close></div>

{{-- Main Content --}}
<div class="dash-main">
    <button type="button" class="mobile-sidebar-toggle" data-sidebar-open>
        <i class="fas fa-bars"></i> Menu
    </button>

    {{-- Page header --}}
    <div
        style="background:linear-gradient(135deg,#28a745 0%,#1e7e34 100%);padding:20px 24px;color:white;margin-bottom:24px;border-radius:10px;display:flex;align-items:center;justify-content:space-between;">
        <div>
            <h5 class="mb-0 font-weight-bold"><i class="fas fa-arrow-circle-up mr-2"></i>Upgrade Your Plan</h5>
            <small class="opacity-75">
                @if ($currentPlan)
                    Current Plan: <strong>{{ $currentPlan->name }}
                        (₹{{ number_format($currentPlan->price) }})</strong> — select a higher plan to upgrade
                @else
                    No active plan — select a plan to get started
                @endif
            </small>
        </div>
        <a href="{{ route('member.dashboard') }}" class="btn btn-light btn-sm">
            <i class="fas fa-arrow-left mr-1"></i>Dashboard
        </a>
    </div>

    {{-- Plan Cards --}}
    <div class="plan-grid">
        @foreach ($plans as $index => $plan)
            @php
                $isCurrent = $currentPlan && $plan->id === $currentPlan->id;
                $isLocked = $currentPlan && $plan->price < $currentPlan->price;
                $isUpgradeable = !$isCurrent && !$isLocked;

                if ($isCurrent) {
                    $cardClass = 'current-plan';
                } elseif ($isLocked) {
                    $cardClass = 'locked';
                } else {
                    $cardClass = 'upgradeable';
                }
            @endphp
            <div class="plan-card {{ $cardClass }} plan-{{ $index }}">
                <span class="plan-pill">{{ $planPills[$index] ?? $plan->name }}</span>
                <div class="plan-name">{{ $plan->name }}</div>
                <div class="plan-price">₹{{ number_format($plan->price) }}</div>
                <div class="plan-detail">Start your journey and unlock earning potential 🚀</div>

                @if ($isUpgradeable)
                    <button class="btn-upgrade purchase-plan" data-amount="{{ $plan->price }}"
                        data-plan="{{ $plan->id }}">
                        Upgrade Now
                    </button>
                @else
                    <button class="btn-disabled {{ $isCurrent ? 'active-plan' : '' }}" disabled>
                        {{ $isCurrent ? 'Active Plan' : 'Not Available' }}
                    </button>
                @endif
            </div>
        @endforeach
    </div>

</div>{{-- /.dash-main --}}
</div>{{-- /.dash-layout --}}
@endsection

@section('scripts')
<script src="{{ asset('frontend/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('frontend/plugins/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('frontend/js/script.js') }}"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    (function() {
        var body = document.body;
        var openBtn = document.querySelector('[data-sidebar-open]');
        var closeTargets = document.querySelectorAll('[data-sidebar-close], .dash-sidebar a');

        if (!openBtn) return;

        openBtn.addEventListener('click', function() {
            body.classList.add('mobile-sidebar-open');
        });

        closeTargets.forEach(function(target) {
            target.addEventListener('click', function() {
                body.classList.remove('mobile-sidebar-open');
            });
        });
    })();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click', '.purchase-plan', function(e) {
        e.preventDefault();

        var amount = $(this).data('amount');
        var planId = $(this).data('plan');

        $.post("{{ url('member/create-order') }}", {
            _token: $('meta[name="csrf-token"]').attr('content'),
            amount: amount,
            plan_id: planId
        }, function(order) {

            var options = {
                key: "{{ config('services.razorpay.key') }}",
                amount: order.amount,
                currency: "INR",
                order_id: order.order_id,

                handler: function(response) {

                    $.post("{{ url('member/verify-payment') }}", {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        razorpay_payment_id: response.razorpay_payment_id,
                        razorpay_order_id: response.razorpay_order_id,
                        razorpay_signature: response.razorpay_signature,
                        plan_id: planId,
                        amount: amount
                    }, function(res) {

                        if (res.success) {
                            alert('✅ Plan Upgraded Successfully!');
                            window.location.reload();
                        } else {
                            alert('❌ ' + (res.message || 'Payment Failed'));
                        }

                    });
                }
            };

            var rzp = new Razorpay(options);
            rzp.open();

        });
    });
</script>
@endsection
