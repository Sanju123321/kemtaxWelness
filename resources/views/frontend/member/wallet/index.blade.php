@extends('frontend.layouts.member')

@section('title', 'My Wallet')

@push('styles')
<style>
    .dash-layout {
        display: flex;
        align-items: flex-start;
        background:
            radial-gradient(circle at top right, rgba(40, 167, 69, 0.10), transparent 22%),
            linear-gradient(180deg, #f6f8fb 0%, #eef3f8 100%);
        min-height: calc(100vh - 80px);
    }

    .dash-sidebar {
        width: 230px;
        flex-shrink: 0;
        background: #fff;
        min-height: calc(100vh - 80px);
        box-shadow: 2px 0 12px rgba(0, 0, 0, 0.06);
        position: sticky;
        top: 0;
        display: flex;
        flex-direction: column;
        z-index: 3;
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
        opacity: 0.7;
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
        padding: 28px 24px 60px;
    }

    .wallet-shell {
        width: 100%;
    }

    .wallet-hero {
        display: grid;
        grid-template-columns: minmax(0, 1.65fr) minmax(320px, 1fr);
        gap: 22px;
        margin-bottom: 24px;
    }

    .wallet-balance-panel {
        background: linear-gradient(135deg, #1f9d47 0%, #167736 55%, #0f5b29 100%);
        color: #fff;
        border-radius: 24px;
        padding: 28px;
        position: relative;
        overflow: hidden;
        min-height: 270px;
        box-shadow: 0 22px 50px rgba(21, 92, 45, 0.22);
    }

    .wallet-balance-panel::before,
    .wallet-balance-panel::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.10);
    }

    .wallet-balance-panel::before {
        width: 220px;
        height: 220px;
        top: -70px;
        right: -40px;
    }

    .wallet-balance-panel::after {
        width: 150px;
        height: 150px;
        bottom: -60px;
        right: 90px;
    }

    .hero-kicker,
    .hero-note {
        position: relative;
        z-index: 1;
    }

    .hero-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 18px;
    }

    .hero-balance {
        position: relative;
        z-index: 1;
        font-size: clamp(2.5rem, 5vw, 4rem);
        line-height: 1;
        font-weight: 800;
        margin-bottom: 16px;
    }

    .hero-stats {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
        margin-top: 24px;
    }

    .hero-stat {
        padding: 14px 16px;
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(4px);
    }

    .hero-stat-label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: rgba(255, 255, 255, 0.72);
        margin-bottom: 4px;
        font-weight: 700;
    }

    .hero-stat-value {
        font-size: 1.2rem;
        font-weight: 800;
        color: #fff;
    }

    .hero-note {
        margin-top: 14px;
        font-size: 13px;
        color: rgba(255, 255, 255, 0.86);
    }

    .wallet-side-grid {
        display: grid;
        gap: 18px;
    }

    .wallet-card {
        background: #fff;
        border-radius: 22px;
        padding: 22px;
        border: 1px solid rgba(28, 55, 90, 0.08);
        box-shadow: 0 18px 40px rgba(17, 38, 66, 0.08);
    }

    .wallet-card h5,
    .wallet-card h6 {
        margin-bottom: 0;
    }

    .card-kicker {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #7d8da1;
        margin-bottom: 8px;
    }

    .mini-amount {
        font-size: 2rem;
        line-height: 1.1;
        font-weight: 800;
        color: #14243a;
    }

    .muted-note {
        font-size: 12px;
        color: #8390a2;
    }

    .wallet-breakdown {
        display: grid;
        gap: 12px;
    }

    .breakdown-row {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        align-items: center;
        padding: 12px 14px;
        border-radius: 16px;
        background: #f7f9fc;
    }

    .breakdown-label {
        font-size: 13px;
        color: #5e6a7d;
        font-weight: 600;
    }

    .breakdown-value {
        font-size: 15px;
        font-weight: 800;
        color: #13233a;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: #fff;
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 16px 38px rgba(17, 38, 66, 0.07);
        border-top: 4px solid var(--accent);
    }

    .stat-card .value {
        margin-top: 8px;
        font-size: 1.8rem;
        line-height: 1.1;
        font-weight: 800;
        color: var(--accent);
    }

    .stat-card .sub {
        margin-top: 6px;
        font-size: 12px;
        color: #8a95a6;
    }

    .progress-card {
        margin-bottom: 24px;
    }

    .progress-track {
        height: 12px;
        border-radius: 999px;
        background: #edf1f6;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        border-radius: inherit;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 24px;
    }

    .action-card .form-control {
        height: 48px;
        border-radius: 12px;
        border-color: #d9e0ea;
        box-shadow: none;
    }

    .action-card .btn {
        height: 48px;
        border-radius: 12px;
        font-weight: 700;
    }

    .repurchase-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 12px;
        border-radius: 999px;
        background: #edf6ff;
        color: #2368d1;
        font-size: 12px;
        font-weight: 700;
    }

    .history-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 18px;
    }

    .history-list {
        display: grid;
    }

    .transaction-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        padding: 18px 0;
        border-bottom: 1px solid #edf1f5;
    }

    .transaction-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .transaction-item:first-child {
        padding-top: 0;
    }

    .transaction-main {
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 0;
    }

    .transaction-icon {
        width: 46px;
        height: 46px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 18px;
        flex-shrink: 0;
    }

    .transaction-icon.credit {
        background: linear-gradient(135deg, #2daf58 0%, #179b44 100%);
    }

    .transaction-icon.debit {
        background: linear-gradient(135deg, #ff995c 0%, #ff6b35 100%);
    }

    .transaction-title {
        font-size: 15px;
        font-weight: 700;
        color: #1d2d43;
    }

    .transaction-subtitle,
    .transaction-date {
        font-size: 12px;
        color: #8792a3;
    }

    .transaction-side {
        text-align: right;
        flex-shrink: 0;
    }

    .amount-credit,
    .amount-debit {
        font-size: 1.05rem;
        font-weight: 800;
    }

    .amount-credit {
        color: #24a148;
    }

    .amount-debit {
        color: #f26d33;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-top: 6px;
        padding: 5px 12px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .status-badge.status-credited,
    .status-badge.status-approved {
        background: #e7f7eb;
        color: #1f8e42;
    }

    .status-badge.status-pending {
        background: #fff3db;
        color: #b97507;
    }

    .status-badge.status-rejected {
        background: #ffe8e5;
        color: #d64545;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        margin-top: 24px;
    }

    .info-card {
        text-align: center;
    }

    .info-icon {
        width: 58px;
        height: 58px;
        border-radius: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 14px;
        background: rgba(40, 167, 69, 0.10);
    }

    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .actions-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 991px) {
        .dash-sidebar {
            display: none;
        }

        .dash-main {
            padding: 16px 12px 40px;
        }

        .wallet-hero,
        .stats-grid,
        .info-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px) {
        .hero-stats {
            grid-template-columns: 1fr;
        }

        .transaction-item,
        .history-header,
        .breakdown-row {
            flex-direction: column;
            align-items: flex-start;
        }

        .transaction-side {
            text-align: left;
        }
    }
</style>
@endpush

@section('content')
@php
    $isInactive = auth()->check() && auth()->user()->status == 'inactive';
    $dailyPct = $dailyCap > 0 ? min(100, round(($todayEarned / $dailyCap) * 100, 1)) : 0;
    $totalPct = $totalCap > 0 ? min(100, round(($totalEarned / $totalCap) * 100, 1)) : 0;
    $barColor = $dailyPct >= 90 ? '#e74c3c' : ($dailyPct >= 70 ? '#f39c12' : '#28a745');
    $currency = fn ($amount) => '&#8377;' . number_format((float) $amount, 2);
@endphp

<div class="dash-layout">
    <aside class="dash-sidebar">
        <div class="sidebar-user">
            <div
                style="
                    background: {{ $isInactive ? '#f8d7da' : '#e9f7ef' }};
                    border: 2px solid {{ $isInactive ? '#dc3545' : '#28a745' }};
                    border-radius: 50%;
                    width: 40px;
                    height: 40px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    flex-shrink: 0;">
                <i class="fas fa-user {{ $isInactive ? 'text-danger' : 'text-success' }}" style="font-size:18px;"></i>
            </div>
            <div>
                <div class="u-name">@auth{{ Auth::user()->name }}@else Member @endauth</div>
                <div class="u-role" style="color: {{ $isInactive ? '#dc3545' : '#28a745' }};">
                    <i class="fas fa-circle" style="font-size:7px;margin-right:3px;"></i>
                    @auth{{ ucfirst(Auth::user()->status) }}@else Inactive @endauth
                </div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-label">Main Menu</div>
            <a href="{{ route('member.dashboard') }}"
                class="{{ request()->routeIs('member.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt nav-icon"></i> Dashboard
            </a>
            <a href="{{ route('member.wallet') }}"
                class="{{ request()->routeIs('member.wallet') ? 'active' : '' }}{{ $isInactive ? ' disabled' : '' }}">
                <i class="fas fa-wallet nav-icon"></i> Wallet
            </a>

            <div class="nav-label">My Team</div>
            <a href="{{ route('member.team') }}"
                class="{{ request()->routeIs('member.team') ? 'active' : '' }}{{ $isInactive ? ' disabled' : '' }}">
                <i class="fas fa-sitemap nav-icon"></i> Genealogy Tree
            </a>
            <a href="{{ route('member.credentials') }}"
                class="{{ request()->routeIs('member.credentials') ? 'active' : '' }}{{ $isInactive ? ' disabled' : '' }}">
                <i class="fas fa-award nav-icon"></i> My Achievements
            </a>

            <div class="nav-label">More</div>
            <a href="{{ route('pricing') }}" class="{{ request()->routeIs('pricing') ? 'active' : '' }}">
                <i class="fas fa-tags nav-icon"></i> Pricing
            </a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">
                <i class="fas fa-headset nav-icon"></i> Support
            </a>
            <a href="#" data-bs-toggle="modal" data-bs-target="#inviteModal"
                class="{{ $isInactive ? 'disabled' : '' }}">
                <i class="fas fa-share-alt nav-icon"></i> Invite &amp; Earn
            </a>
            <a href="{{ route('member.dashboard') }}#referral-commission"
                class="{{ $isInactive ? 'disabled' : '' }}">
                <i class="fas fa-hand-holding-usd nav-icon"></i> Referral Commission
            </a>

            <div class="nav-label">My Shopping</div>
            <a href="{{ route('member.dashboard') }}#wishlist" class="{{ $isInactive ? 'disabled' : '' }}">
                <i class="fas fa-heart nav-icon" style="color:#e74c3c;"></i> My Favorites
                @if (isset($wishlistItems) && $wishlistItems->count())
                    <span class="ml-auto"
                        style="background:#e74c3c;color:white;font-size:10px;font-weight:700;padding:2px 7px;border-radius:10px;">{{ $wishlistItems->count() }}</span>
                @endif
            </a>
            <a href="{{ route('member.dashboard') }}#cart" class="{{ $isInactive ? 'disabled' : '' }}">
                <i class="fas fa-shopping-bag nav-icon" style="color:#28a745;"></i> My Cart
                @if (isset($cartItems) && $cartItems->count())
                    <span class="ml-auto"
                        style="background:#28a745;color:white;font-size:10px;font-weight:700;padding:2px 7px;border-radius:10px;">{{ $cartItems->count() }}</span>
                @endif
            </a>
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

    <div class="dash-main">
        <div class="wallet-shell">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="wallet-hero">
                <div class="wallet-balance-panel">
                    <div class="hero-kicker">
                        <i class="fas fa-wallet"></i>
                        Wallet Overview
                    </div>
                    <div class="hero-balance">{!! $currency($walletBalance) !!}</div>
                    <div class="hero-note">
                        Available wallet balance. Last activity:
                        {{ \Illuminate\Support\Carbon::parse($lastTransactionAt)->format('d M Y, h:i A') }}
                    </div>

                    <div class="hero-stats">
                        <div class="hero-stat">
                            <div class="hero-stat-label">Total Earned</div>
                            <div class="hero-stat-value">{!! $currency($totalEarned) !!}</div>
                        </div>
                        <div class="hero-stat">
                            <div class="hero-stat-label">Repurchase Wallet</div>
                            <div class="hero-stat-value">{!! $currency($repurchaseWallet) !!}</div>
                        </div>
                        <div class="hero-stat">
                            <div class="hero-stat-label">Today Earned</div>
                            <div class="hero-stat-value">{!! $currency($todayEarned) !!}</div>
                        </div>
                        <div class="hero-stat">
                            <div class="hero-stat-label">Pending Withdraw</div>
                            <div class="hero-stat-value">{!! $currency($pendingWithdrawalAmount) !!}</div>
                        </div>
                    </div>
                </div>

                <div class="wallet-side-grid">
                    <div class="wallet-card">
                        <div class="card-kicker">Wallet Breakdown</div>
                        <div class="wallet-breakdown">
                            <div class="breakdown-row">
                                <div class="breakdown-label">Main Wallet</div>
                                <div class="breakdown-value">{!! $currency($walletBalance) !!}</div>
                            </div>
                            <div class="breakdown-row">
                                <div class="breakdown-label">Repurchase Wallet</div>
                                <div class="breakdown-value">{!! $currency($repurchaseWallet) !!}</div>
                            </div>
                            <div class="breakdown-row">
                                <div class="breakdown-label">Approved Withdrawals</div>
                                <div class="breakdown-value">{!! $currency($approvedWithdrawalAmount) !!}</div>
                            </div>
                        </div>
                    </div>

                    <div class="wallet-card">
                        <div class="card-kicker">Current Plan</div>
                        <div class="mini-amount">{{ $plan?->name ?? 'No Plan' }}</div>
                        <div class="muted-note mt-2">
                            Plan amount: {!! $currency($plan?->price ?? 0) !!}
                        </div>
                        <div class="muted-note">
                            Repurchase wallet is shown dynamically as {{ $repurchasePercent }}% of total earned.
                        </div>
                    </div>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card" style="--accent:#28a745;">
                    <div class="card-kicker">Today Earned</div>
                    <div class="value">{!! $currency($todayEarned) !!}</div>
                    <div class="sub">
                        @if ($dailyCap > 0)
                            Daily cap: {!! $currency($dailyCap) !!}
                        @else
                            No daily cap available
                        @endif
                    </div>
                </div>

                <div class="stat-card" style="--accent:#e74c3c;">
                    <div class="card-kicker">Today Lost</div>
                    <div class="value">{!! $currency($todayLost) !!}</div>
                    <div class="sub">Cap overflow moved to company</div>
                </div>

                <div class="stat-card" style="--accent:#3498db;">
                    <div class="card-kicker">Total Earned</div>
                    <div class="value">{!! $currency($totalEarned) !!}</div>
                    <div class="sub">
                        @if ($totalCap > 0)
                            Lifetime cap: {!! $currency($totalCap) !!}
                        @else
                            Lifetime earnings summary
                        @endif
                    </div>
                </div>

                <div class="stat-card" style="--accent:#6f42c1;">
                    <div class="card-kicker">Repurchase Wallet</div>
                    <div class="value">{!! $currency($repurchaseWallet) !!}</div>
                    <div class="sub">{{ $repurchasePercent }}% deduction wallet for future shopping</div>
                </div>

                <div class="stat-card" style="--accent:#ff8a00;">
                    <div class="card-kicker">Transactions</div>
                    <div class="value">{{ $creditedTransactionsCount }}</div>
                    <div class="sub">Credited income entries received</div>
                </div>
            </div>

            @if ($dailyCap > 0 || $totalCap > 0)
                <div class="wallet-card progress-card">
                    <div class="history-header">
                        <div>
                            <h5><i class="fas fa-chart-line mr-2" style="color: {{ $barColor }};"></i>Wallet Limits</h5>
                            <div class="muted-note">Track today usage and total earning progress dynamically.</div>
                        </div>
                        @if ($dailyCap > 0)
                            <div class="repurchase-badge">
                                <i class="fas fa-bolt"></i>
                                {{ $dailyPct }}% daily cap used
                            </div>
                        @endif
                    </div>

                    @if ($dailyCap > 0)
                        <div class="mb-2 d-flex justify-content-between">
                            <span class="breakdown-label">Daily cap usage</span>
                            <span class="muted-note">{!! $currency(max(0, $dailyCap - $todayEarned)) !!} remaining</span>
                        </div>
                        <div class="progress-track mb-3">
                            <div class="progress-bar-fill" style="width: {{ $dailyPct }}%; background: {{ $barColor }};"></div>
                        </div>
                    @endif

                    @if ($totalCap > 0)
                        <div class="mb-2 d-flex justify-content-between">
                            <span class="breakdown-label">Total cap usage</span>
                            <span class="muted-note">{{ $totalPct }}% of lifetime cap</span>
                        </div>
                        <div class="progress-track">
                            <div class="progress-bar-fill" style="width: {{ $totalPct }}%; background: #3498db;"></div>
                        </div>
                    @endif
                </div>
            @endif

            <div class="actions-grid">
                <div class="wallet-card action-card" style="border-top:4px solid #0d6efd;">
                    <div class="card-kicker">Add Funds</div>
                    <h5><i class="fas fa-plus-circle text-primary mr-2"></i>Main Wallet Top Up</h5>
                    <p class="muted-note mt-2 mb-3">Pay with Razorpay and credit the amount directly to your main wallet.</p>
                    <div class="form-group">
                        <input type="number" class="form-control" id="walletTopupAmount" placeholder="Enter amount" min="100" step="0.01">
                        <small class="muted-note">Minimum top up: {!! $currency(100) !!}</small>
                    </div>
                    <button class="btn btn-primary btn-block" type="button" id="walletTopupButton">
                        <i class="fas fa-plus mr-2"></i>Add Funds
                    </button>
                </div>

                <div class="wallet-card action-card" style="border-top:4px solid #6f42c1;">
                    <div class="card-kicker">Repurchase Wallet</div>
                    <h5><i class="fas fa-sync-alt mr-2" style="color:#6f42c1;"></i>Use For Repurchase</h5>
                    <p class="muted-note mt-2 mb-3">Repurchase wallet can be used for future product purchase or plan upgrade.</p>
                    <div class="mini-amount">{!! $currency($repurchaseWallet) !!}</div>
                    <div class="repurchase-badge mt-3">
                        <i class="fas fa-tags"></i>
                        Based on {{ $repurchasePercent }}% repurchase deduction
                    </div>
                    <a href="{{ route('products') }}" class="btn btn-block mt-3"
                        style="background:#6f42c1;color:#fff;">
                        <i class="fas fa-shopping-bag mr-2"></i>Shop With Repurchase Wallet
                    </a>
                </div>

                <div class="wallet-card action-card" style="border-top:4px solid #ff6b35;">
                    <div class="card-kicker">Withdraw</div>
                    <h5><i class="fas fa-arrow-up text-warning mr-2"></i>Withdraw Funds</h5>
                    <p class="muted-note mt-2 mb-2">Withdraw from your main wallet to the bank account saved in your profile.</p>
                    @php $bankDetail = auth()->user()->bankDetail; @endphp
                    @if ($bankDetail)
                        <div class="muted-note mb-3">
                            {{ $bankDetail->bank_name }} | {{ $bankDetail->account_number }}<br>
                            IFSC: {{ strtoupper($bankDetail->ifsc) }} | Available: {!! $currency($availableWithdrawalBalance) !!}
                        </div>
                        <form method="POST" action="{{ route('member.wallet.withdraw') }}">
                            @csrf
                            <div class="form-group">
                                <input type="number" name="amount" class="form-control" placeholder="Enter amount"
                                    min="{{ $minWithdrawal }}" max="{{ $availableWithdrawalBalance }}" step="0.01"
                                    value="{{ old('amount') }}" @if ($isInactive) disabled @endif>
                                <small class="muted-note">Minimum withdrawal: {!! $currency($minWithdrawal) !!}</small>
                            </div>
                            <button type="submit" class="btn btn-block"
                                style="background:#ff6b35;color:#fff;"
                                @if ($isInactive || $availableWithdrawalBalance < $minWithdrawal) disabled @endif>
                                <i class="fas fa-arrow-up mr-2"></i>Request Withdrawal
                            </button>
                        </form>
                    @else
                        <div class="alert alert-warning py-2 small">
                            Save bank details in your profile before requesting a withdrawal.
                        </div>
                        <a href="{{ route('member.profile') }}" class="btn btn-block"
                            style="background:#ff6b35;color:#fff;">
                            <i class="fas fa-university mr-2"></i>Add Bank Details
                        </a>
                    @endif
                </div>
            </div>

            <div class="wallet-card">
                <div class="history-header">
                    <div>
                        <h5><i class="fas fa-history text-color mr-2"></i>Transaction History</h5>
                        <div class="muted-note">Dynamic list of credited income and withdrawal requests.</div>
                    </div>
                    <div class="repurchase-badge">
                        <i class="fas fa-list"></i>
                        {{ $recentTransactions->count() }} recent items
                    </div>
                </div>

                <div class="history-list">
                    @forelse ($recentTransactions as $txn)
                        <div class="transaction-item">
                            <div class="transaction-main">
                                <div class="transaction-icon {{ $txn['kind'] }}">
                                    <i class="fas {{ $txn['icon'] }}"></i>
                                </div>
                                <div>
                                    <div class="transaction-title">{{ $txn['title'] }}</div>
                                    <div class="transaction-subtitle">{{ $txn['subtitle'] }}</div>
                                    <div class="transaction-date">{{ $txn['date']->format('d M Y, h:i A') }}</div>
                                </div>
                            </div>

                            <div class="transaction-side">
                                <div class="{{ $txn['kind'] === 'credit' ? 'amount-credit' : 'amount-debit' }}">
                                    {{ $txn['kind'] === 'credit' ? '+' : '-' }} {!! $currency($txn['amount']) !!}
                                </div>
                                <span class="status-badge status-{{ $txn['status'] }}">
                                    {{ $txn['status_text'] }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-receipt fa-3x mb-3 opacity-50"></i>
                            <p class="mb-2">No wallet transactions found.</p>
                            <p class="small">Your credited earnings and withdrawal activity will appear here.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="info-grid">
                <div class="wallet-card info-card">
                    <div class="info-icon" style="color:#17a2b8;background:rgba(23,162,184,.12);">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h6>Processing Time</h6>
                    <p class="muted-note mb-0">Withdrawals are processed within 3 to 5 business days.</p>
                </div>

                <div class="wallet-card info-card">
                    <div class="info-icon" style="color:#28a745;background:rgba(40,167,69,.12);">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h6>Secure Transfers</h6>
                    <p class="muted-note mb-0">Wallet transactions are protected and visible in your recent activity.</p>
                </div>

                <div class="wallet-card info-card">
                    <div class="info-icon" style="color:#6f42c1;background:rgba(111,66,193,.12);">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h6>Need Help?</h6>
                    <p class="muted-note mb-0">Support is available anytime for wallet, repurchase, and withdrawal help.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.sidebar-nav a').forEach(function(link) {
        link.addEventListener('click', function() {
            if (this.classList.contains('disabled')) return;
            document.querySelectorAll('.sidebar-nav a').forEach(function(l) {
                l.classList.remove('active');
            });
            this.classList.add('active');
        });
    });

    (function() {
        var topupButton = document.getElementById('walletTopupButton');
        var topupAmountInput = document.getElementById('walletTopupAmount');

        if (!topupButton || !topupAmountInput || typeof Razorpay === 'undefined') {
            return;
        }

        topupButton.addEventListener('click', function() {
            var amount = parseFloat(topupAmountInput.value || '0');

            if (!amount || amount < 100) {
                alert('Minimum top up amount is Rs. 100');
                topupAmountInput.focus();
                return;
            }

            topupButton.disabled = true;
            topupButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing';

            $.post('{{ route('member.wallet.create.order') }}', {
                _token: $('meta[name="csrf-token"]').attr('content'),
                amount: amount
            }).done(function(orderData) {
                var options = {
                    key: "{{ config('services.razorpay.key') }}",
                    amount: orderData.amount,
                    currency: 'INR',
                    name: 'Kemtex Wellness',
                    description: 'Wallet Top Up',
                    order_id: orderData.order_id,
                    prefill: {
                        name: orderData.name || '',
                        email: orderData.email || '',
                        contact: orderData.contact || ''
                    },
                    handler: function(response) {
                        $.post('{{ route('member.wallet.verify.payment') }}', {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            razorpay_payment_id: response.razorpay_payment_id,
                            razorpay_order_id: response.razorpay_order_id,
                            razorpay_signature: response.razorpay_signature
                        }).done(function(res) {
                            if (res.success) {
                                window.location.reload();
                                return;
                            }

                            alert(res.message || 'Top up verification failed.');
                            resetTopupButton();
                        }).fail(function(xhr) {
                            alert((xhr.responseJSON && xhr.responseJSON.message) || 'Top up verification failed.');
                            resetTopupButton();
                        });
                    },
                    modal: {
                        ondismiss: function() {
                            resetTopupButton();
                        }
                    }
                };

                var rzp = new Razorpay(options);
                rzp.open();
            }).fail(function(xhr) {
                alert((xhr.responseJSON && (xhr.responseJSON.message || (xhr.responseJSON.errors && Object.values(xhr.responseJSON.errors)[0][0]))) || 'Unable to create wallet top up order.');
                resetTopupButton();
            });
        });

        function resetTopupButton() {
            topupButton.disabled = false;
            topupButton.innerHTML = '<i class="fas fa-plus mr-2"></i>Add Funds';
        }
    })();
</script>
@endpush
