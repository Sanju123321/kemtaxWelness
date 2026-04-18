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

        @media (max-width:768px) {
            .dash-sidebar {
                display: none;
            }

            .dash-main {
                padding: 14px 12px 40px;
            }
        }

        /* ── Plan Cards ─────────────────────────────────────── */
        .plan-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .plan-card {
            background: #fff;
            border-radius: 14px;
            border: 2px solid #e0e0e0;
            padding: 24px 18px 20px;
            text-align: center;
            transition: transform .2s, box-shadow .2s;
            position: relative;
        }

        .plan-card.upgradeable {
            border-color: #28a745;
            cursor: pointer;
        }

        .plan-card.upgradeable:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 28px rgba(40, 167, 69, .2);
        }

        .plan-card.current-plan {
            border-color: #3498db;
            background: #f0f8ff;
        }

        .plan-card.locked {
            opacity: .55;
            background: #f8f9fa;
            border-color: #dee2e6;
        }

        .plan-badge-top {
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            padding: 2px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .badge-current {
            background: #3498db;
            color: #fff;
        }

        .badge-upgrade {
            background: #28a745;
            color: #fff;
        }

        .badge-locked {
            background: #aaa;
            color: #fff;
        }

        .plan-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #fff;
            margin: 0 auto 14px;
        }

        .plan-name {
            font-size: 16px;
            font-weight: 700;
            color: #333;
            margin-bottom: 4px;
        }

        .plan-price {
            font-size: 26px;
            font-weight: 800;
            color: #28a745;
            margin-bottom: 6px;
        }

        .plan-detail {
            font-size: 12px;
            color: #777;
            margin-bottom: 4px;
        }

        .btn-upgrade {
            display: inline-block;
            margin-top: 14px;
            padding: 8px 22px;
            background: linear-gradient(135deg, #28a745, #1e7e34);
            color: #fff;
            border: none;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: opacity .2s;
            width: 100%;
        }

        .btn-upgrade:hover {
            opacity: .88;
        }

        .btn-disabled {
            display: inline-block;
            margin-top: 14px;
            padding: 8px 22px;
            background: #e9ecef;
            color: #aaa;
            border: none;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 700;
            cursor: not-allowed;
            width: 100%;
        }

        /* plan colour palette */
        .plan-icon-a {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .plan-icon-b {
            background: linear-gradient(135deg, #11998e, #38ef7d);
        }

        .plan-icon-c {
            background: linear-gradient(135deg, #f093fb, #f5576c);
        }

        .plan-icon-d {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
        }

        .plan-icon-e {
            background: linear-gradient(135deg, #f7971e, #ffd200);
        }
    </style>
@endpush

@section('content')
    @php
        $isInactive = auth()->check() && auth()->user()->status == 'inactive';
        $currentPrice = $currentPlan?->price ?? 0;
        $iconClasses = ['plan-icon-a', 'plan-icon-b', 'plan-icon-c', 'plan-icon-d', 'plan-icon-e'];
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
        <a href="{{ route('member.team') }}" class="{{ $isInactive ? 'disabled' : '' }}"><i
                class="fas fa-sitemap nav-icon"></i> Genealogy Tree</a>
    </nav>

    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                style="background:none;border:none;padding:0;width:100%;text-align:left;display:flex;align-items:center;gap:10px;font-size:14px;color:#dc3545;font-weight:600;cursor:pointer;">
                <i class="fas fa-sign-out-alt" style="width:18px;text-align:center;"></i> Logout
            </button>
        </form>
    </div>
</aside>

{{-- Main Content --}}
<div class="dash-main">

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
                $iconClass = $iconClasses[$index] ?? 'plan-icon-a';

                if ($isCurrent) {
                    $cardClass = 'current-plan';
                } elseif ($isLocked) {
                    $cardClass = 'locked';
                } else {
                    $cardClass = 'upgradeable';
                }
            @endphp
            <div class="plan-card {{ $cardClass }}">
                @if ($isCurrent)
                    <span class="plan-badge-top badge-current"><i class="fas fa-check-circle mr-1"></i>Current
                        Plan</span>
                @elseif($isLocked)
                    <span class="plan-badge-top badge-locked"><i class="fas fa-lock mr-1"></i>Locked</span>
                @else
                    <span class="plan-badge-top badge-upgrade"><i class="fas fa-arrow-up mr-1"></i>Upgrade</span>
                @endif

                <div class="plan-icon {{ $iconClass }} mt-3">
                    <i class="fas fa-crown"></i>
                </div>

                <div class="plan-name">{{ $plan->name }}</div>
                <div class="plan-price">₹{{ number_format($plan->price) }}</div>
                <div class="plan-detail"><i class="fas fa-calendar-day mr-1 text-muted"></i>Daily Cap:
                    <strong>₹{{ number_format($plan->daily_cap) }}</strong>
                </div>
                <div class="plan-detail"><i class="fas fa-flag-checkered mr-1 text-muted"></i>Max Cap:
                    <strong>₹{{ number_format($plan->total_cap) }}</strong>
                </div>
                <div class="plan-detail"><i class="fas fa-chart-line mr-1 text-muted"></i>2X Daily Income</div>

                @if ($isUpgradeable)
                    <button class="btn-upgrade purchase-plan" data-amount="{{ $plan->price }}"
                        data-plan="{{ $plan->id }}">
                        <i class="fas fa-bolt mr-1"></i>Upgrade Now
                    </button>
                @else
                    <button class="btn-disabled" disabled>
                        {{ $isCurrent ? 'Active Plan' : 'Locked' }}
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
