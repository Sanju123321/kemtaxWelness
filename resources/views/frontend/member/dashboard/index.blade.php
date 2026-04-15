@extends('frontend.layouts.member')

@section('title', 'My Dashboard')

@push('styles')
<style>
    .sidebar-nav a.disabled,
    .sidebar-nav a.disabled:hover {
        pointer-events: none;
        color: #bbb !important;
        background: #f8f9fa !important;
        border-left-color: #eee !important;
        opacity: 0.7;
    }

    .dashboard-header {
        background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
        padding: 20px 0;
        color: white;
        margin-bottom: 30px;
    }

    .text-red {
        color: #dc3545;
        /* Bootstrap red */
    }

    .text-green {
        color: #28a745;
        /* Bootstrap green */
    }

    .text-grey {
        color: #6c757d;
    }

    .stat-card {
        background: white;
        padding: 22px 24px;
        border-left: 4px solid #28a745;
        border-radius: 6px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        height: 100%;
    }

    .stat-card h6 {
        color: #888;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-bottom: 10px;
    }

    .stat-card .amount {
        font-size: 1.7rem;
        font-weight: 800;
        color: #28a745;
    }

    .stat-card .stat-icon {
        font-size: 1.5rem;
        color: #6c757d;
    }

    .team-table {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .section-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
        overflow: hidden;
    }

    .section-card-header {
        background: #f8f9fa;
        padding: 15px 20px;
        border-bottom: 1px solid #e9ecef;
        font-weight: 700;
        color: #333;
    }

    .section-card-body {
        padding: 20px;
    }

    .badge-plan {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        background: #d4edda;
        color: #155724;
    }

    .badge-level {
        display: inline-block;
        background: #cce5ff;
        color: #004085;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 700;
    }

    /* Genealogy Tree Styles */
    .genealogy-tree {
        display: flex;
        justify-content: center;
        padding: 30px 10px;
        overflow-x: auto;
    }

    .genealogy-tree ul {
        position: relative;
        padding: 20px 0;
        display: flex;
        justify-content: center;
    }

    .genealogy-tree li {
        list-style: none;
        text-align: center;
        position: relative;
        padding: 20px 15px 0;
    }

    .genealogy-tree li::before,
    .genealogy-tree li::after {
        content: '';
        position: absolute;
        top: 0;
        right: 50%;
        border-top: 2px solid #ccc;
        width: 50%;
        height: 20px;
    }

    .genealogy-tree li::after {
        right: auto;
        left: 50%;
        border-left: 2px solid #ccc;
    }

    .genealogy-tree li:only-child::after,
    .genealogy-tree li:only-child::before {
        display: none;
    }

    .genealogy-tree li:first-child::before,
    .genealogy-tree li:last-child::after {
        border: 0 none;
    }

    .genealogy-tree li:last-child::before {
        border-right: 2px solid #ccc;
        border-radius: 0 5px 0 0;
    }

    .genealogy-tree li:first-child::after {
        border-radius: 5px 0 0 0;
    }

    .genealogy-tree ul ul::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        border-left: 2px solid #ccc;
        width: 0;
        height: 20px;
    }

    .genealogy-tree .member-view-box {
        display: inline-block;
        position: relative;
        cursor: pointer;
    }

    .genealogy-tree .member-image {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        border: 4px solid #28a745;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
        position: relative;
    }

    .genealogy-tree .member-image:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
    }

    .genealogy-tree .member-image img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .genealogy-tree .member-image i {
        font-size: 2rem;
        color: white;
    }

    .genealogy-tree li.level-1 .member-image {
        border-color: #28a745;
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
    }

    .genealogy-tree li.level-2 .member-image {
        border-color: #ffc107;
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    }

    .genealogy-tree li.level-3 .member-image {
        border-color: #17a2b8;
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
    }

    .genealogy-tree .member-name {
        font-size: 13px;
        font-weight: 600;
        color: #333;
        margin-top: 8px;
    }

    .genealogy-tree .expand-icon {
        position: absolute;
        bottom: -5px;
        right: 5px;
        background: #28a745;
        color: white;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        border: 2px solid white;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .genealogy-tree .expand-icon:hover {
        background: #1e7e34;
        transform: rotate(90deg);
    }

    .genealogy-tree ul.hidden {
        display: none;
    }

    .genealogy-tree .no-children .expand-icon {
        display: none;
    }

    /* Commission Table */
    .commission-table th {
        font-size: 12px;
        font-weight: 700;
        color: #555;
        text-transform: uppercase;
        letter-spacing: .06em;
        background: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
        padding: 10px 14px;
    }

    .commission-table td {
        padding: 11px 14px;
        font-size: 13px;
        vertical-align: middle;
        border-top: 1px solid #f0f0f0;
    }

    .commission-table tr:first-child td {
        border-top: none;
    }

    .badge-completed {
        background: #d4edda;
        color: #155724;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
    }

    .badge-pending {
        background: #fff3cd;
        color: #856404;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
    }

    /* Invite Modal */
    .invite-code-box {
        display: flex;
        gap: 8px;
    }

    .invite-code-box input {
        flex: 1;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 8px 12px;
        font-size: 14px;
        background: #f8f9fa;
        color: #333;
    }

    .share-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        width: 100%;
        padding: 10px 16px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: opacity .2s;
        color: white;
        text-decoration: none;
    }

    .share-btn:hover {
        opacity: .85;
        color: white;
    }

    .share-btn.whatsapp {
        background: #25D366;
    }

    .share-btn.gmail {
        background: #EA4335;
    }

    .share-btn.facebook {
        background: #1877F2;
    }

    .share-btn.twitter {
        background: #1DA1F2;
    }

    .share-btn.telegram {
        background: #0088CC;
    }

    .share-btn.copy-link {
        background: #6c757d;
    }

    .copied-toast {
        display: none;
        font-size: 12px;
        color: #28a745;
        font-weight: 600;
        margin-top: 4px;
    }

    /* ── Dashboard Layout ── */
    .dash-layout {
        display: flex;
        align-items: flex-start;
        background: #f4f6f9;
        min-height: calc(100vh - 80px);
    }

    /* Sidebar */
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

    .sidebar-user .s-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #e9f7ef;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #28a745;
        flex-shrink: 0;
    }

    .sidebar-user .u-name {
        font-size: 13px;
        font-weight: 700;
        color: #333;
        line-height: 1.3;
    }

    .sidebar-user .u-role {
        font-size: 11px;
        color: #28a745;
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

    .sidebar-nav a i.nav-icon {
        width: 18px;
        text-align: center;
        font-size: 14px;
    }

    .sidebar-footer {
        padding: 14px 18px;
        border-top: 1px solid #f0f0f0;
    }

    /* Main content */
    .dash-main {
        flex: 1;
        min-width: 0;
        padding: 28px 24px 60px;
    }

    @media (max-width: 768px) {
        .dash-sidebar {
            display: none;
        }

        .dash-main {
            padding: 16px 12px 40px;
        }
    }

    /* ── Genealogy Tree Modal ── */
    .modal-xl {
        max-width: 96vw;
    }

    .tree-legend-dot {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 600;
        color: #fff;
        padding: 3px 10px;
        border-radius: 20px;
    }

    /* CSS-connector tree */
    .gt-tree,
    .gt-tree ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .gt-tree {
        display: flex;
        justify-content: center;
        padding-top: 10px;
    }

    .gt-tree ul {
        position: relative;
        display: flex;
        justify-content: center;
        padding-top: 24px;
    }

    .gt-tree ul::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 2px;
        height: 24px;
        background: #cdd6e0;
    }

    .gt-tree li {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 0 12px;
    }

    /* Horizontal connector above siblings */
    .gt-tree ul>li::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: #cdd6e0;
    }

    .gt-tree ul>li:first-child::before {
        left: 50%;
    }

    .gt-tree ul>li:last-child::before {
        right: 50%;
    }

    .gt-tree ul>li:only-child::before {
        display: none;
    }

    /* Vertical drop from horizontal line to node */
    .gt-tree ul>li::after {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 2px;
        height: 24px;
        background: #cdd6e0;
    }

    /* Node card */
    .gt-node-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        cursor: pointer;
        user-select: none;
        position: relative;
        margin-top: 24px;
    }

    .gt-avatar {
        width: 68px;
        height: 68px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.6rem;
        border: 4px solid white;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.18);
        transition: transform 0.25s, box-shadow 0.25s;
        position: relative;
    }

    .gt-node-card:hover .gt-avatar {
        transform: scale(1.08);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
    }

    /* depth-based colours */
    .gt-depth-0 {
        background: linear-gradient(135deg, #28a745, #1e7e34);
    }

    .gt-depth-1 {
        background: linear-gradient(135deg, #f39c12, #e67e22);
    }

    .gt-depth-2 {
        background: linear-gradient(135deg, #3498db, #2980b9);
    }

    .gt-depth-3 {
        background: linear-gradient(135deg, #9b59b6, #8e44ad);
    }

    .gt-depth-4 {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
    }

    .gt-toggle-btn {
        position: absolute;
        bottom: -8px;
        right: -4px;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid #28a745;
        color: #28a745;
        font-size: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        transition: background 0.2s, color 0.2s, transform 0.25s;
        line-height: 1;
    }

    .gt-node-card.gt-expanded .gt-toggle-btn {
        background: #28a745;
        color: white;
        transform: rotate(45deg);
    }

    .gt-name {
        font-size: 12px;
        font-weight: 600;
        color: #333;
        margin-top: 8px;
        max-width: 90px;
        text-align: center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .gt-level-badge {
        font-size: 10px;
        font-weight: 700;
        color: #888;
        margin-top: 2px;
    }

    /* Collapsed children */
    .gt-children.gt-hidden {
        display: none;
    }

    /* Responsive adjustments */
    @media (max-width: 576px) {
        .gt-avatar {
            width: 52px;
            height: 52px;
            font-size: 1.2rem;
        }

        .gt-name {
            font-size: 11px;
            max-width: 70px;
        }

        .gt-tree li {
            padding: 0 6px;
        }

        .modal-xl {
            max-width: 100vw;
            margin: 0;
        }

        .modal-dialog {
            margin: 0;
        }

        .modal-content {
            border-radius: 0 !important;
            min-height: 100vh;
        }
    }
</style>
@endpush

@section('content')

{{-- Dashboard Header --}}
<div class="dashboard-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1"><i class="fas fa-tachometer-alt mr-2"></i>My Dashboard</h4>
                <p class="mb-0 small opacity-75">
                    Welcome back,
                    @auth
                    {{ Auth::user()->name }}
                    @else
                    Member
                    @endauth!
                    Here's your network overview.
                </p>
            </div>

            <div class="d-flex align-items-center" style="gap:10px;">

                <span class="badge-plan"
                    style="
                    @auth
{{ Auth::user()->status == 'active' ? 'background:#28a745;color:white;' : 'background:red;color:white;' }}
                    @else
                        background:gray;color:white; @endauth
                    ">

                    @auth
                    {{ ucfirst(Auth::user()->status) }}
                    @else
                    Inactive
                    @endauth Member
                </span>

                <button class="btn btn-sm"
                    style="background:white;color:#28a745;font-weight:700;border-radius:20px;border:2px solid white;"
                    data-toggle="modal" data-target="#inviteModal">
                    <i class="fas fa-share-alt mr-1"></i> Invite &amp; Earn
                </button>

            </div>
        </div>
    </div>
</div>

<div class="dash-layout">

    {{-- Sidebar --}}
    <aside class="dash-sidebar">
        <div class="sidebar-user">

            @php
            $isInactive = auth()->check() && auth()->user()->status == 'inactive';
            @endphp

            {{-- AVATAR --}}
            <div class="s-avatar"
                style="
        background: {{ $isInactive ? '#f8d7da' : '#e9f7ef' }};
        border:2px solid {{ $isInactive ? '#dc3545' : '#28a745' }};
        border-radius:50%;
        width:40px;height:40px;
        display:flex;align-items:center;justify-content:center;
        overflow:hidden;
    ">

                @if(Auth::user()->profile_photo)
                <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                    style="width:100%; height:100%; object-fit:cover;">
                @else
                <i class="fas fa-user {{ $isInactive ? 'text-danger' : 'text-success' }}"
                    style="font-size:18px;">
                </i>
                @endif

            </div>
            <div>
                {{-- NAME --}}
                <div class="u-name">
                    @auth {{ Auth::user()->name }}
                    @else
                    Member
                    @endauth
                </div>

                {{-- STATUS --}}
                <div class="u-role" style="color: {{ $isInactive ? '#dc3545' : '#28a745' }};">

                    <i class="fas fa-circle"
                        style="font-size:7px;margin-right:3px;
                       color: {{ $isInactive ? '#dc3545' : '#28a745' }};">
                    </i>

                    @auth
                    {{ ucfirst(Auth::user()->status) }}
                    @else
                    Inactive
                    @endauth
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
            <a href="{{ route('member.credentials') }}"
                class="{{ request()->routeIs('member.credentials') ? 'active' : '' }}{{ $isInactive ? ' disabled' : '' }}">
                <i class="fas fa-award nav-icon"></i> Credentials
            </a>
            <div class="nav-label">More</div>

            <a href="{{ route('pricing') }}">
                <i class="fas fa-tags nav-icon"></i> Pricing
            </a>

            <a href="{{ route('contact') }}">
                <i class="fas fa-headset nav-icon"></i> Support
            </a>
            <a href="#" data-bs-toggle="modal" data-bs-target="#inviteModal"
                class="{{ $isInactive ? 'disabled' : '' }}">
                <i class="fas fa-share-alt nav-icon"></i> Invite &amp; Earn
            </a>
            <a href="#" id="sidebarCommissionLink"
                onclick="showSection('referralCommissionSection'); return false;"
                class="{{ $isInactive ? 'disabled' : '' }}">
                <i class="fas fa-hand-holding-usd nav-icon"></i> Referral Commission
            </a>
            <div class="nav-label">My Shopping</div>
            <a href="#wishlist" onclick="scrollToSection('wishlist'); return false;"
                class="{{ $isInactive ? 'disabled' : '' }}">
                <i class="fas fa-heart nav-icon" style="color:#e74c3c;"></i> My Favorites
                @if (isset($wishlistItems) && $wishlistItems->count())
                <span class="ml-auto"
                    style="background:#e74c3c;color:white;font-size:10px;font-weight:700;padding:2px 7px;border-radius:10px;">{{ $wishlistItems->count() }}</span>
                @endif
            </a>
            <a href="#cart" onclick="scrollToSection('cart'); return false;"
                class="{{ $isInactive ? 'disabled' : '' }}">
                <i class="fas fa-shopping-bag nav-icon" style="color:#28a745;"></i> My Cart
                @if (isset($cartItems) && $cartItems->count())
                <span class="ml-auto"
                    style="background:#28a745;color:white;font-size:10px;font-weight:700;padding:2px 7px;border-radius:10px;">{{ $cartItems->count() }}</span>
                @endif
            </a>
            <div class="nav-label">My Team</div>
            <a href="{{ route('member.team') }}" id="sidebarTreeLink" class="{{ $isInactive ? 'disabled' : '' }}">
                <i class="fas fa-sitemap nav-icon"></i> Genealogy Tree
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

    {{-- Main Content --}}
    <div class="dash-main">

        {{-- Stat Cards --}}
        <div class="row mb-4">
            @php
            $stats = [
            [
            'label' => 'Total Earnings',
            'value' => '₹' . number_format($dashStats['total_earnings'], 2),
            'icon' => 'fa-rupee-sign',
            'color' => '#28a745',
            ],
            [
            'label' => 'Direct Referrals',
            'value' => $dashStats['direct_referrals'],
            'icon' => 'fa-users',
            'color' => '#17a2b8',
            ],
            [
            'label' => 'Team Size',
            'value' => $dashStats['team_size'],
            'icon' => 'fa-network-wired',
            'color' => '#ffc107',
            ],
            [
            'label' => 'Wallet Balance',
            'value' => '₹' . number_format($dashStats['wallet_balance'], 2),
            'icon' => 'fa-wallet',
            'color' => '#6610f2',
            ],
            ];
            @endphp
            @foreach ($stats as $stat)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card d-flex align-items-center gap-3"
                    style="border-left-color: {{ $stat['color'] }}">
                    <div class="stat-icon" style="color: {{ $stat['color'] }};"><i
                            class="fas {{ $stat['icon'] }}"></i>
                    </div>
                    <div>
                        <h6>{{ $stat['label'] }}</h6>
                        <div class="amount" style="color: {{ $stat['color'] }};">{{ $stat['value'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row">
            {{-- Recent Activity --}}
            <div class="col-lg-8 mb-4">

                {{-- Referral Commission Table (hidden by default) --}}
                <div class="section-card" id="referralCommissionSection" style="display:none;">
                    <div class="section-card-header d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-hand-holding-usd mr-2 text-color"></i>Referral Commission</span>
                        <button onclick="showSection(null)" class="btn btn-sm"
                            style="font-size:12px;color:#6c757d;background:none;border:1px solid #dee2e6;border-radius:6px;padding:3px 10px;">
                            <i class="fas fa-times mr-1"></i>Close
                        </button>
                    </div>
                    <div class="section-card-body p-0">
                        {{-- Search & entries row --}}
                        <div class="d-flex justify-content-between align-items-center px-3 pt-3 pb-2"
                            style="flex-wrap:wrap;gap:10px;">
                            <div style="font-size:13px;color:#555;">
                                Show
                                <select id="refEntriesSelect" onchange="renderRefTable()"
                                    style="border:1px solid #dee2e6;border-radius:4px;padding:2px 6px;font-size:13px;">
                                    <option value="5">5</option>
                                    <option value="10" selected>10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                                entries per page
                            </div>
                            <div style="font-size:13px;color:#555;display:flex;align-items:center;gap:6px;">
                                Search:
                                <input type="text" id="refSearchInput" oninput="renderRefTable()" placeholder=""
                                    style="border:1px solid #dee2e6;border-radius:4px;padding:4px 8px;font-size:13px;width:160px;">
                            </div>
                        </div>
                        <div style="overflow-x:auto;">
                            <table class="table mb-0 commission-table" id="refCommissionTable">
                                <thead>
                                    <tr>
                                        <th>SR</th>
                                        <th>DOJ</th>
                                        <th>User Name<br><span
                                                style="font-weight:400;text-transform:none;font-size:11px;">(User
                                                ID)</span></th>
                                        <th>Referral</th>
                                        <th>Level</th>
                                        <th>Date of Commission</th>
                                        <th>Referral Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="refTableBody"></tbody>
                            </table>
                        </div>
                        {{-- Pagination --}}
                        <div class="d-flex justify-content-between align-items-center px-3 py-2"
                            style="flex-wrap:wrap;gap:8px;">
                            <div id="refTableInfo" style="font-size:12px;color:#777;"></div>
                            <div id="refPagination" style="display:flex;gap:4px;"></div>
                        </div>
                    </div>
                </div>

                <div class="section-card" id="recentCommissionsSection">
                    <div class="section-card-header d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-history mr-2 text-color"></i>Recent Commissions</span>
                        <a href="#" class="btn btn-sm btn-main btn-round-full"
                            style="font-size:11px;padding:4px 14px;">View All</a>
                    </div>
                    <div class="section-card-body p-0">
                        <table class="table mb-0 commission-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>From Member</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="commissionTableBody">
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">
                                        <i class="fas fa-spinner fa-spin mr-1"></i> Loading…
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    {{-- Pagination --}}
                    <div class="d-flex justify-content-between align-items-center px-3 py-2"
                        style="flex-wrap:wrap;gap:8px;">
                        <div id="commissionInfo" style="font-size:12px;color:#777;"></div>
                        <div id="commissionPagination" style="display:flex;gap:4px;"></div>
                    </div>
                </div>{{-- /.recentCommissionsSection --}}

                {{-- Team Tree --}}
                <!-- <div class="section-card">
                        <div class="section-card-header">
                            <i class="fas fa-sitemap mr-2 text-color"></i>My Team Genealogy
                        </div>
                        <div class="section-card-body">
                           
                        </div>
                    </div> -->
            </div>

            {{-- Side Panel --}}
            <div class="col-lg-4 mb-4">
                {{-- Profile Quick View --}}
                <div class="section-card mb-4">
                    <div class="section-card-header">
                        <i class="fas fa-user mr-2 text-color"></i>My Profile
                    </div>

                    <div class="section-card-body text-center">

                        {{-- AVATAR --}}
                        <div class="mb-3">
                            <div
                                style="width:80px;height:80px;border-radius:50%;
        background:
        @auth
            {{ Auth::user()->status == 'inactive' ? '#f8d7da' : '#e9f7ef' }}
        @else
            #f8d7da
        @endauth;
        display:flex;align-items:center;justify-content:center;
        margin:0 auto;
        overflow:hidden;
        border:3px solid
        @auth
            {{ Auth::user()->status == 'inactive' ? '#dc3545' : '#28a745' }}
        @else
            #dc3545
        @endauth;">

                                @auth
                                @if(Auth::user()->profile_photo)
                                <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                                    style="width:100%; height:100%; object-fit:cover;">
                                @else
                                <i class="fas fa-user fa-2x
                    {{ Auth::user()->status == 'inactive' ? 'text-danger' : 'text-success' }}">
                                </i>
                                @endif
                                @else
                                <i class="fas fa-user fa-2x text-danger"></i>
                                @endauth

                            </div>
                        </div>

                        {{-- NAME --}}
                        <h6 class="mb-1">
                            @auth {{ Auth::user()->name }}
                            @else
                            Member
                            @endauth
                        </h6>

                        {{-- EMAIL --}}
                        <p class="text-muted small mb-2">
                            @auth {{ Auth::user()->email }}
                            @else
                            member@example.com
                            @endauth
                        </p>

                        {{-- STATUS BADGE --}}
                        <span class="badge-plan mb-3 d-inline-block"
                            style="background-color:
                @auth
{{ Auth::user()->status == 'inactive' ? '#dc3545' : '#28a745' }}
                @else
                    #dc3545 @endauth;
                color:#fff;">

                            @auth
                            {{ ucfirst(Auth::user()->status) }}
                            @else
                            Inactive
                            @endauth
                        </span>

                        {{-- BUTTON (UNCHANGED) --}}
                        <div>
                            <a href="{{ route('member.profile') }}" class="btn btn-main btn-round-full btn-sm">
                                Edit Profile
                            </a>
                        </div>

                    </div>
                </div>

                {{-- Quick Links --}}
                <div class="section-card">
                    <div class="section-card-header"><i class="fas fa-link mr-2 text-color"></i>Quick Links</div>
                    <div class="section-card-body p-0">
                        <a href="{{ route('member.wallet') }}"
                            class="d-flex align-items-center p-3 border-bottom text-dark text-decoration-none{{ $isInactive ? ' disabled' : '' }}"
                            style="gap:12px;">
                            <i class="fas fa-wallet text-color"></i><span>My Wallet</span>
                            <i class="fas fa-chevron-right ml-auto text-muted small"></i>
                        </a>
                        <a href="{{ route('member.credentials') }}"
                            class="d-flex align-items-center p-3 border-bottom text-dark text-decoration-none{{ $isInactive ? ' disabled' : '' }}"
                            style="gap:12px;">
                            <i class="fas fa-award text-color"></i><span>My Credentials</span>
                            <i class="fas fa-chevron-right ml-auto text-muted small"></i>
                        </a>
                        @if (!$isInactive)
                        <a href="{{ route('pricing') }}"
                            class="d-flex align-items-center p-3 border-bottom text-dark text-decoration-none"
                            style="gap:12px;">
                            <i class="fas fa-tags text-color"></i><span>Upgrade Plan</span>
                            <i class="fas fa-chevron-right ml-auto text-muted small"></i>
                        </a>
                        @endif
                        <a href="{{ route('contact') }}"
                            class="d-flex align-items-center p-3 text-dark text-decoration-none" style="gap:12px;">
                            <i class="fas fa-headset text-color"></i><span>Get Support</span>
                            <i class="fas fa-chevron-right ml-auto text-muted small"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════ --}}
        {{-- MY FAVORITES (Wishlist) --}}
        {{-- ═══════════════════════════════════════════════ --}}
        <div class="section-card" id="wishlist">
            <div class="section-card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-heart mr-2" style="color:#e74c3c;"></i>My Favorites
                    @if (isset($wishlistItems) && $wishlistItems->count())
                    <span class="ml-2"
                        style="background:#e74c3c;color:white;font-size:11px;font-weight:700;padding:2px 10px;border-radius:12px;">{{ $wishlistItems->count() }}</span>
                    @endif
                </span>
                <a href="{{ route('products') }}" class="btn btn-sm btn-main btn-round-full"
                    style="font-size:11px;padding:4px 14px;">
                    <i class="fas fa-shopping-bag mr-1"></i>Shop More
                </a>
            </div>
            <div class="section-card-body">
                @if (isset($wishlistItems) && $wishlistItems->count())
                <div class="row" id="wishlist-grid">
                    @foreach ($wishlistItems as $item)
                    @if ($item->product)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4 wish-item"
                        id="wish-item-{{ $item->product->id }}">
                        <div class="card h-100 border-0"
                            style="border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,.07);overflow:hidden;">
                            <div
                                style="position:relative;overflow:hidden;height:160px;background:#f8f9fa;">
                                <img src="{{ $item->product->image_url }}"
                                    alt="{{ $item->product->name }}"
                                    style="width:100%;height:100%;object-fit:cover;"
                                    onerror="this.src='{{ asset('frontend/images/placeholder.jpg') }}'">
                                @if ($item->product->discount_percent > 0)
                                <span
                                    style="position:absolute;top:8px;left:8px;background:#e74c3c;color:white;font-size:10px;font-weight:700;padding:2px 7px;border-radius:10px;">
                                    -{{ $item->product->discount_percent }}%
                                </span>
                                @endif
                            </div>
                            <div class="card-body p-3">
                                <p class="mb-1"
                                    style="font-size:10px;color:#28a745;font-weight:700;text-transform:uppercase;letter-spacing:.06em;">
                                    {{ $item->product->category }}
                                </p>
                                <h6 class="mb-1"
                                    style="font-size:13px;font-weight:700;line-height:1.3;color:#333;">
                                    {{ Str::limit($item->product->name, 40) }}
                                </h6>
                                <div class="d-flex align-items-center mb-3" style="gap:6px;">
                                    <span
                                        style="font-weight:800;color:#28a745;">₹{{ number_format($item->product->price, 2) }}</span>
                                    @if ($item->product->original_price)
                                    <span
                                        style="font-size:11px;color:#aaa;text-decoration:line-through;">₹{{ number_format($item->product->original_price, 2) }}</span>
                                    @endif
                                </div>
                                <div class="d-flex" style="gap:6px;">
                                    <button class="btn btn-sm btn-main flex-fill"
                                        style="font-size:11px;padding:5px 8px;border-radius:6px;"
                                        onclick="addToCartFromWishlist({{ $item->product->id }}, this)">
                                        <i class="fas fa-cart-plus mr-1"></i>Add to Cart
                                    </button>
                                    <button class="btn btn-sm"
                                        style="font-size:11px;padding:5px 8px;border-radius:6px;border:1px solid #e74c3c;color:#e74c3c;background:white;"
                                        onclick="removeFromWishlist({{ $item->product->id }}, this)"
                                        title="Remove from Wishlist">
                                        <i class="fas fa-heart-broken"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
                <p id="wishlist-empty" class="text-muted text-center py-3" style="display:none;">
                    <i class="far fa-heart fa-2x mb-2 d-block" style="color:#ddd;"></i>
                    Your wishlist is empty. <a href="{{ route('products') }}">Browse products</a>
                </p>
                @else
                <div class="text-center py-5">
                    <i class="far fa-heart fa-3x mb-3" style="color:#ddd;"></i>
                    <p class="text-muted mb-3">Your wishlist is empty.</p>
                    <a href="{{ route('products') }}" class="btn btn-main btn-round-full">
                        <i class="fas fa-shopping-bag mr-1"></i>Browse Products
                    </a>
                </div>
                @endif
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════ --}}
        {{-- MY CART --}}
        {{-- ═══════════════════════════════════════════════ --}}
        <div class="section-card" id="cart">
            <div class="section-card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-shopping-bag mr-2 text-color"></i>My Cart
                    @if (isset($cartItems) && $cartItems->count())
                    <span class="ml-2"
                        style="background:#28a745;color:white;font-size:11px;font-weight:700;padding:2px 10px;border-radius:12px;">{{ $cartItems->count() }}</span>
                    @endif
                </span>
                <a href="{{ route('products') }}" class="btn btn-sm btn-main btn-round-full"
                    style="font-size:11px;padding:4px 14px;">
                    <i class="fas fa-plus mr-1"></i>Add Products
                </a>
            </div>
            <div class="section-card-body p-0">
                @if (isset($cartItems) && $cartItems->count())
                <div style="overflow-x:auto;">
                    <table class="table mb-0 commission-table" id="cart-table">
                        <thead>
                            <tr>
                                <th style="width:60px;"></th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartItems as $cartItem)
                            @if ($cartItem->product)
                            <tr id="cart-row-{{ $cartItem->product->id }}">
                                <td>
                                    <img src="{{ $cartItem->product->image_url }}"
                                        alt="{{ $cartItem->product->name }}"
                                        style="width:48px;height:48px;object-fit:cover;border-radius:6px;"
                                        onerror="this.src='{{ asset('frontend/images/placeholder.jpg') }}'">
                                </td>
                                <td>
                                    <div
                                        style="font-size:13px;font-weight:600;color:#333;line-height:1.3;">
                                        {{ Str::limit($cartItem->product->name, 45) }}
                                    </div>
                                    <div
                                        style="font-size:11px;color:#28a745;font-weight:600;text-transform:uppercase;">
                                        {{ $cartItem->product->category }}
                                    </div>
                                </td>
                                <td style="font-weight:700;color:#333;">
                                    ₹{{ number_format($cartItem->product->price, 2) }}</td>
                                <td>
                                    <div class="qty-stepper d-flex align-items-center" style="gap:4px;">
                                        <button type="button" class="qty-btn qty-dec"
                                            data-product="{{ $cartItem->product->id }}"
                                            data-price="{{ $cartItem->product->price }}"
                                            onclick="stepQty(this, -1)"
                                            {{ $cartItem->quantity <= 1 ? 'disabled' : '' }}
                                            style="width:28px;height:28px;border:1px solid #dee2e6;background:white;border-radius:5px;font-size:14px;font-weight:700;cursor:pointer;color:#333;line-height:1;padding:0;">−</button>
                                        <input type="number" id="qty-{{ $cartItem->product->id }}"
                                            class="cart-qty-input" value="{{ $cartItem->quantity }}"
                                            min="1" max="{{ $cartItem->product->stock }}"
                                            data-product="{{ $cartItem->product->id }}"
                                            data-price="{{ $cartItem->product->price }}"
                                            data-stock="{{ $cartItem->product->stock }}"
                                            onchange="syncQty(this)"
                                            style="width:44px;height:28px;text-align:center;border:1px solid #dee2e6;border-radius:5px;font-size:13px;font-weight:700;color:#28a745;padding:0 4px;">
                                        <button type="button" class="qty-btn qty-inc"
                                            data-product="{{ $cartItem->product->id }}"
                                            data-price="{{ $cartItem->product->price }}"
                                            onclick="stepQty(this, 1)"
                                            {{ $cartItem->quantity >= $cartItem->product->stock ? 'disabled' : '' }}
                                            style="width:28px;height:28px;border:1px solid #dee2e6;background:white;border-radius:5px;font-size:14px;font-weight:700;cursor:pointer;color:#333;line-height:1;padding:0;">+</button>
                                    </div>
                                    <div
                                        style="font-size:10px;color:#aaa;margin-top:2px;text-align:center;">
                                        Max: {{ $cartItem->product->stock }}
                                    </div>
                                </td>
                                <td style="font-weight:800;color:#28a745;">
                                    ₹{{ number_format($cartItem->product->price * $cartItem->quantity, 2) }}
                                </td>
                                <td>
                                    <button class="btn btn-sm"
                                        style="color:#dc3545;border:1px solid #dc3545;background:white;border-radius:6px;font-size:11px;padding:4px 10px;"
                                        onclick="removeFromCart({{ $cartItem->product->id }}, this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between align-items-center p-3"
                    style="background:#f8f9fa;border-top:1px solid #e9ecef;">
                    <div style="font-size:14px;color:#555;">
                        <strong>{{ $cartItems->count() }}</strong> item(s)
                    </div>
                    <div style="font-size:16px;font-weight:800;color:#28a745;">
                        Total: ₹{{ number_format($cartTotal ?? 0, 2) }}
                    </div>
                </div>
                <p id="cart-empty" class="text-muted text-center py-3 m-0" style="display:none;">
                    <i class="fas fa-shopping-bag fa-2x mb-2 d-block" style="color:#ddd;"></i>
                    Your cart is empty. <a href="{{ route('products') }}">Shop now</a>
                </p>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-bag fa-3x mb-3" style="color:#ddd;"></i>
                    <p class="text-muted mb-3">Your cart is empty.</p>
                    <a href="{{ route('products') }}" class="btn btn-main btn-round-full">
                        <i class="fas fa-shopping-bag mr-1"></i>Start Shopping
                    </a>
                </div>
                @endif
            </div>
        </div>

    </div>{{-- /.dash-main --}}
</div>{{-- /.dash-layout --}}

{{-- Invite & Earn Modal --}}
<div class="modal fade" id="inviteModal" tabindex="-1" role="dialog" aria-labelledby="inviteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius:12px;border:none;">
            <div class="modal-header" style="border-bottom:1px solid #f0f0f0;">
                <h5 class="modal-title" id="inviteModalLabel" style="font-weight:700;"><i
                        class="fas fa-share-alt mr-2 text-color"></i>Invite &amp; Earn</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding:24px;">
                <p class="text-muted mb-4" style="font-size:14px;">Share your referral with friends using the
                    code/link below.</p>

                <div class="mb-3">
                    <label
                        style="font-size:12px;font-weight:700;color:#555;text-transform:uppercase;letter-spacing:.05em;"
                        class="mb-1">Referral Code</label>
                    <div class="invite-code-box">
                        <input type="text" id="referralCode" value="{{ auth()->user()->reference_code }}" readonly>
                        <button class="btn btn-main btn-sm px-3"
                            onclick="copyText('referralCode', 'codeToast')">Copy</button>
                    </div>
                    <div class="copied-toast" id="codeToast">Copied!</div>
                </div>

                <div class="mb-4">
                    <label
                        style="font-size:12px;font-weight:700;color:#555;text-transform:uppercase;letter-spacing:.05em;"
                        class="mb-1">Referral Link</label>
                    <div class="invite-code-box">
                        <input type="text" id="referralLink" value="{{ url('/register?ref=' . auth()->user()->reference_code) }}"
                            readonly>
                        <button class="btn btn-main btn-sm px-3"
                            onclick="copyText('referralLink', 'linkToast')">Copy</button>
                    </div>
                    <div class="copied-toast" id="linkToast">Copied!</div>
                </div>

                <p style="font-size:12px;font-weight:700;color:#555;text-transform:uppercase;letter-spacing:.05em;"
                    class="mb-2">Share Via</p>
                <div class="row" style="gap:0;">
                    <div class="col-6 mb-2">
                        <a id="shareWhatsapp" href="https://wa.me/?text={{ urlencode('Join me using my referral link: ' . url('/register?ref=' . auth()->user()->reference_code)) }}" target="_blank" class="share-btn whatsapp">
                            <i class="fab fa-whatsapp fa-lg"></i> WhatsApp
                        </a>
                    </div>
                    <div class="col-6 mb-2">
                        <a id="shareGmail" href="https://mail.google.com/mail/?view=cm&fs=1&su=Join Me&body={{ urlencode('Join me using my referral link: ' . url('/register?ref=' . auth()->user()->reference_code)) }}" target="_blank" class="share-btn gmail">
                            <i class="fas fa-envelope fa-lg"></i> Gmail
                        </a>
                    </div>
                    <div class="col-6 mb-2">
                        <a id="shareFacebook" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('/register?ref=' . auth()->user()->reference_code)) }}" target="_blank" class="share-btn facebook">
                            <i class="fab fa-facebook fa-lg"></i> Facebook
                        </a>
                    </div>
                    <div class="col-6 mb-2">
                        <a id="shareTwitter" href="https://twitter.com/intent/tweet?text=Join me using my referral link: {{ urlencode(url('/register?ref=' . auth()->user()->reference_code)) }}" target="_blank" class="share-btn twitter">
                            <i class="fab fa-twitter fa-lg"></i> Twitter / X
                        </a>
                    </div>
                    <div class="col-6 mb-2">
                        <a id="shareTelegram" href="https://t.me/share/url?url={{ urlencode(url('/register?ref=' . auth()->user()->reference_code)) }}&text=Join Me" target="_blank" class="share-btn telegram">
                            <i class="fab fa-telegram fa-lg"></i> Telegram
                        </a>
                    </div>
                    <div class="col-6 mb-2">
                        <button onclick="copyText('referralLink', 'linkToast')" class="share-btn copy-link">
                            <i class="fas fa-link fa-lg"></i> Copy Link
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ========== / Genealogy Tree Modal removed — now a standalone page ========== --}}

@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Dummy genealogy data
    // const genealogyData = {
    //     id: 1,
    //     name: 'Priya Iyer',
    //     level: 0,
    //     children: [{
    //             id: 2,
    //             name: 'Vikram Singh',
    //             level: 1,
    //             children: [{
    //                     id: 5,
    //                     name: 'Neha Gupta',
    //                     level: 2,
    //                     children: [{
    //                             id: 9,
    //                             name: 'Raj Kumar',
    //                             level: 3,
    //                             children: []
    //                         },
    //                         {
    //                             id: 10,
    //                             name: 'Priya Sharma',
    //                             level: 3,
    //                             children: []
    //                         }
    //                     ]
    //                 },
    //                 {
    //                     id: 6,
    //                     name: 'Siddharth Jain',
    //                     level: 2,
    //                     children: [{
    //                         id: 11,
    //                         name: 'Anjali Verma',
    //                         level: 3,
    //                         children: []
    //                     }]
    //                 }
    //             ]
    //         },
    //         {
    //             id: 3,
    //             name: 'Ananya Rao',
    //             level: 1,
    //             children: [{
    //                     id: 7,
    //                     name: 'Karan Mehta',
    //                     level: 2,
    //                     children: []
    //                 },
    //                 {
    //                     id: 8,
    //                     name: 'Sneha Nair',
    //                     level: 2,
    //                     children: []
    //                 }
    //             ]
    //         },
    //         {
    //             id: 4,
    //             name: 'Rohit Mehta',
    //             level: 1,
    //             children: [{
    //                 id: 12,
    //                 name: 'Divya Patel',
    //                 level: 2,
    //                 children: []
    //             }]
    //         }
    //     ]
    // };

    // // Function to create member node HTML
    // function createMemberNode(member) {
    //     const hasChildren = member.children && member.children.length > 0;
    //     const childrenClass = hasChildren ? '' : 'no-children';

    //     return `
    //         <div class="member-view-box ${childrenClass}" data-member-id="${member.id}">
    //             <div class="member-image">
    //                 <i class="fas fa-user"></i>
    //                 ${hasChildren ? '<div class="expand-icon"><i class="fas fa-plus"></i></div>' : ''}
    //             </div>
    //             <div class="member-name">${member.name}</div>
    //         </div>
    //     `;
    // }

    // // Function to build tree recursively
    // function buildTree(member, isInitialLoad = false) {
    //     const hasChildren = member.children && member.children.length > 0;
    //     const childrenHiddenClass = isInitialLoad ? '' : 'hidden';

    //     let html = `<li class="level-${member.level}">`;
    //     html += createMemberNode(member);

    //     if (hasChildren) {
    //         html += `<ul class="${childrenHiddenClass}">`;
    //         member.children.forEach(child => {
    //             html += buildTree(child, isInitialLoad);
    //         });
    //         html += '</ul>';
    //     }

    //     html += '</li>';
    //     return html;
    // }

    // // Initialize the tree
    // function initGenealogyTree() {
    //     const treeContainer = document.getElementById('genealogyTree');
    //     const treeHTML = `<ul>${buildTree(genealogyData, true)}</ul>`;
    //     treeContainer.innerHTML = treeHTML;

    //     // Add click event listeners to all expand icons
    //     attachExpandListeners();
    // }

    // // Attach expand/collapse listeners
    // function attachExpandListeners() {
    //     const expandIcons = document.querySelectorAll('.genealogy-tree .expand-icon');

    //     expandIcons.forEach(icon => {
    //         icon.addEventListener('click', function(e) {
    //             e.stopPropagation();

    //             const memberBox = this.closest('.member-view-box');
    //             const parentLi = memberBox.closest('li');
    //             const childrenUl = parentLi.querySelector(':scope > ul');

    //             if (childrenUl) {
    //                 const iconElement = this.querySelector('i');

    //                 if (childrenUl.classList.contains('hidden')) {
    //                     // Expand
    //                     childrenUl.classList.remove('hidden');
    //                     iconElement.classList.remove('fa-plus');
    //                     iconElement.classList.add('fa-minus');
    //                     this.style.background = '#dc3545';
    //                 } else {
    //                     // Collapse
    //                     childrenUl.classList.add('hidden');
    //                     iconElement.classList.remove('fa-minus');
    //                     iconElement.classList.add('fa-plus');
    //                     this.style.background = '#28a745';
    //                 }
    //             }
    //         });
    //     });

    //     // Add hover effect to member boxes
    //     const memberBoxes = document.querySelectorAll('.member-view-box');
    //     memberBoxes.forEach(box => {
    //         box.addEventListener('click', function(e) {
    //             if (!e.target.closest('.expand-icon')) {
    //                 // You can add member detail modal here
    //                 console.log('Member clicked:', this.dataset.memberId);
    //             }
    //         });
    //     });
    // }

    // Initialize on page load
    // document.addEventListener('DOMContentLoaded', function() {
    //     initGenealogyTree();
    //     buildShareLinks();
    //     renderRefTable();
    // });

    // ── Section toggle ──────────────────────────────────────────
    function scrollToSection(id) {
        const el = document.getElementById(id);
        if (el) {
            el.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }

    function showSection(sectionId) {
        const refSection = document.getElementById('referralCommissionSection');
        const mainSections = document.getElementById('recentCommissionsSection');
        const sidebarLink = document.getElementById('sidebarCommissionLink');

        if (sectionId === 'referralCommissionSection') {
            refSection.style.display = 'block';
            mainSections.style.display = 'none';
            sidebarLink.classList.add('active');
        } else {
            refSection.style.display = 'none';
            mainSections.style.display = '';
            sidebarLink.classList.remove('active');
        }
    }

    // ── Referral Commission dummy data ───────────────────────────
    const refCommissionData = [{
            sr: 1,
            doj: '2026-01-04 13:34:47',
            name: 'Vikram Singh',
            uid: '727903',
            referral: '295021',
            level: 1,
            doc: '2026-01-04 15:02:15',
            amount: 200.00
        },
        {
            sr: 2,
            doj: '2026-01-04 14:59:18',
            name: 'Ananya Rao',
            uid: '406425',
            referral: '295021',
            level: 1,
            doc: '',
            amount: 0.00
        },
        {
            sr: 3,
            doj: '2026-01-05 11:56:52',
            name: 'Rohit Mehta',
            uid: '100541',
            referral: '295021',
            level: 1,
            doc: '2026-01-08 09:35:17',
            amount: 57.03
        },
        {
            sr: 4,
            doj: '2026-01-08 10:50:04',
            name: 'Karan Mehta',
            uid: '443962',
            referral: '727903',
            level: 2,
            doc: '',
            amount: 0.00
        },
        {
            sr: 5,
            doj: '2026-01-11 04:40:20',
            name: 'Sneha Nair',
            uid: '648020',
            referral: '100541',
            level: 2,
            doc: '',
            amount: 0.00
        },
        {
            sr: 6,
            doj: '2026-01-13 08:38:22',
            name: 'Neha Gupta',
            uid: '747027',
            referral: '100541',
            level: 2,
            doc: '2026-01-16 13:36:35',
            amount: 50.00
        },
        {
            sr: 7,
            doj: '2026-01-15 08:46:03',
            name: 'Siddharth Jain',
            uid: '768350',
            referral: '100541',
            level: 2,
            doc: '',
            amount: 0.00
        },
        {
            sr: 8,
            doj: '2026-01-16 10:22:11',
            name: 'Anjali Verma',
            uid: '884459',
            referral: '747027',
            level: 3,
            doc: '',
            amount: 0.00
        },
        {
            sr: 9,
            doj: '2026-01-18 09:10:00',
            name: 'Raj Kumar',
            uid: '912300',
            referral: '747027',
            level: 3,
            doc: '2026-01-20 11:00:00',
            amount: 30.00
        },
        {
            sr: 10,
            doj: '2026-01-20 14:05:33',
            name: 'Priya Sharma',
            uid: '934512',
            referral: '768350',
            level: 3,
            doc: '',
            amount: 0.00
        },
        {
            sr: 11,
            doj: '2026-01-22 07:30:45',
            name: 'Divya Patel',
            uid: '956781',
            referral: '443962',
            level: 3,
            doc: '2026-01-25 08:20:10',
            amount: 25.00
        },
        {
            sr: 12,
            doj: '2026-01-24 16:44:20',
            name: 'Ravi Sharma',
            uid: '971234',
            referral: '648020',
            level: 3,
            doc: '',
            amount: 0.00
        },
    ];

    let refCurrentPage = 1;

    function renderRefTable() {
        const perPage = parseInt(document.getElementById('refEntriesSelect').value);
        const search = document.getElementById('refSearchInput').value.toLowerCase();
        const tbody = document.getElementById('refTableBody');
        const infoEl = document.getElementById('refTableInfo');
        const pagEl = document.getElementById('refPagination');

        const filtered = refCommissionData.filter(r =>
            r.name.toLowerCase().includes(search) ||
            r.uid.includes(search) ||
            r.referral.includes(search) ||
            String(r.level).includes(search) ||
            r.doj.includes(search)
        );

        const totalPages = Math.max(1, Math.ceil(filtered.length / perPage));
        if (refCurrentPage > totalPages) refCurrentPage = 1;

        const start = (refCurrentPage - 1) * perPage;
        const pageRows = filtered.slice(start, start + perPage);

        tbody.innerHTML = pageRows.map(r => `
                <tr>
                    <td>${r.sr}</td>
                    <td style="white-space:nowrap;">${r.doj}</td>
                    <td>${r.name}<br><span style="font-size:11px;color:#888;">${r.uid}</span></td>
                    <td>${r.referral}</td>
                    <td><span class="badge-level">${r.level}</span></td>
                    <td style="white-space:nowrap;">${r.doc || '<span class="text-muted">—</span>'}</td>
                    <td><strong style="color:${r.amount > 0 ? '#28a745' : '#999'};">₹ ${r.amount.toFixed(2)}</strong></td>
                </tr>
            `).join('') || '<tr><td colspan="7" class="text-center text-muted py-4">No records found.</td></tr>';

        const from = filtered.length ? start + 1 : 0;
        const to = Math.min(start + perPage, filtered.length);
        infoEl.textContent = `Showing ${from} to ${to} of ${filtered.length} entries`;

        // Pagination buttons
        let pages = '';
        pages +=
            `<button onclick="goRefPage(${refCurrentPage-1})" ${refCurrentPage===1?'disabled':''} style="padding:3px 9px;border:1px solid #dee2e6;border-radius:4px;background:white;font-size:12px;cursor:pointer;">‹</button>`;
        for (let i = 1; i <= totalPages; i++) {
            pages +=
                `<button onclick="goRefPage(${i})" style="padding:3px 9px;border:1px solid #dee2e6;border-radius:4px;background:${i===refCurrentPage?'#28a745':'white'};color:${i===refCurrentPage?'white':'#555'};font-size:12px;cursor:pointer;">${i}</button>`;
        }
        pages +=
            `<button onclick="goRefPage(${refCurrentPage+1})" ${refCurrentPage===totalPages?'disabled':''} style="padding:3px 9px;border:1px solid #dee2e6;border-radius:4px;background:white;font-size:12px;cursor:pointer;">›</button>`;
        pagEl.innerHTML = pages;
    }

    function goRefPage(page) {
        const perPage = parseInt(document.getElementById('refEntriesSelect').value);
        const search = document.getElementById('refSearchInput').value.toLowerCase();
        const filtered = refCommissionData.filter(r =>
            r.name.toLowerCase().includes(search) ||
            r.uid.includes(search) ||
            r.referral.includes(search) ||
            String(r.level).includes(search) ||
            r.doj.includes(search)
        );
        const totalPages = Math.max(1, Math.ceil(filtered.length / perPage));
        if (page < 1 || page > totalPages) return;
        refCurrentPage = page;
        renderRefTable();
    }

    // Copy referral code / link
    function copyText(inputId, toastId) {
        const el = document.getElementById(inputId);
        el.select();
        el.setSelectionRange(0, 99999);
        document.execCommand('copy');
        const toast = document.getElementById(toastId);
        toast.style.display = 'block';
        setTimeout(() => toast.style.display = 'none', 2000);
    }

    // Build share links dynamically
    function buildShareLinks() {
        const link = document.getElementById('referralLink');
        if (!link) return;
        const url = encodeURIComponent(link.value);
        const msg = encodeURIComponent('Join KemtextWellness and earn rewards! Use my referral link: ' + link.value);

        document.getElementById('shareWhatsapp').href = 'https://api.whatsapp.com/send?text=' + msg;
        document.getElementById('shareGmail').href = 'mailto:?subject=' + encodeURIComponent('Join KemtextWellness') +
            '&body=' + msg;
        document.getElementById('shareFacebook').href = 'https://www.facebook.com/sharer/sharer.php?u=' + url;
        document.getElementById('shareTwitter').href = 'https://twitter.com/intent/tweet?text=' + msg;
        document.getElementById('shareTelegram').href = 'https://t.me/share/url?url=' + url + '&text=' +
            encodeURIComponent('Join KemtextWellness and earn rewards!');
    }

    // ── CSRF helper ─────────────────────────────────────────────
    function getCsrf() {
        const m = document.querySelector('meta[name="csrf-token"]');
        return m ? m.getAttribute('content') : '';
    }

    // ── Toast notification ──────────────────────────────────────
    function showDashToast(msg, isSuccess) {
        let t = document.getElementById('dash-toast');
        if (!t) {
            t = document.createElement('div');
            t.id = 'dash-toast';
            t.style.cssText =
                'position:fixed;bottom:24px;right:24px;z-index:9999;padding:12px 20px;border-radius:8px;font-size:14px;font-weight:600;color:white;box-shadow:0 4px 16px rgba(0,0,0,.15);transition:opacity .3s;';
            document.body.appendChild(t);
        }
        t.textContent = msg;
        t.style.background = isSuccess ? '#28a745' : '#dc3545';
        t.style.opacity = '1';
        clearTimeout(t._timer);
        t._timer = setTimeout(() => {
            t.style.opacity = '0';
        }, 3000);
    }

    // ── Remove from Wishlist ─────────────────────────────────────
    function removeFromWishlist(productId, btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

        fetch('{{ route("wishlist.remove") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrf(),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    const item = document.getElementById('wish-item-' + productId);
                    if (item) item.remove();
                    showDashToast('Removed from wishlist.', true);
                    // Show empty state if grid is now empty
                    const grid = document.getElementById('wishlist-grid');
                    if (grid && grid.children.length === 0) {
                        grid.style.display = 'none';
                        const empty = document.getElementById('wishlist-empty');
                        if (empty) empty.style.display = 'block';
                    }
                } else {
                    showDashToast(data.message || 'Could not remove item.', false);
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-heart-broken"></i>';
                }
            })
            .catch(() => {
                showDashToast('An error occurred. Please try again.', false);
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-heart-broken"></i>';
            });
    }

    // ── Add to Cart from wishlist ────────────────────────────────
    function addToCartFromWishlist(productId, btn) {
        btn.disabled = true;
        const orig = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Adding…';

        fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrf(),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            })
            .then(r => r.json())
            .then(data => {
                btn.disabled = false;
                if (data.success) {
                    btn.innerHTML = '<i class="fas fa-check mr-1"></i>Added!';
                    showDashToast('Added to cart!', true);
                    // Update cart badge in header
                    document.querySelectorAll('.cart-badge, #cart-count, .member-badge').forEach(el => {
                        if (data.cart_count !== undefined) el.textContent = data.cart_count;
                    });
                    setTimeout(() => {
                        btn.innerHTML = orig;
                    }, 2000);
                } else {
                    btn.innerHTML = orig;
                    showDashToast(data.message || 'Could not add to cart.', false);
                }
            })
            .catch(() => {
                btn.disabled = false;
                btn.innerHTML = orig;
                showDashToast('An error occurred. Please try again.', false);
            });
    }

    // ── Qty Stepper helpers ──────────────────────────────────────
    function stepQty(btn, delta) {
        const productId = btn.dataset.product;
        const input = document.getElementById('qty-' + productId);
        if (!input) return;
        const newVal = parseInt(input.value) + delta;
        if (newVal < 1 || newVal > parseInt(input.dataset.stock)) return;
        input.value = newVal;
        updateCartQty(productId, newVal, parseFloat(input.dataset.price), parseInt(input.dataset.stock));
    }

    function syncQty(input) {
        const productId = input.dataset.product;
        let val = parseInt(input.value) || 1;
        const stock = parseInt(input.dataset.stock);
        if (val < 1) val = 1;
        if (val > stock) val = stock;
        input.value = val;
        updateCartQty(productId, val, parseFloat(input.dataset.price), stock);
    }

    function updateCartQty(productId, newQty, price, stock) {
        // Optimistic UI — update buttons and totals immediately
        const row = document.getElementById('cart-row-' + productId);
        if (row) {
            const lineTotal = row.querySelector('td:nth-child(5)');
            if (lineTotal) lineTotal.textContent = '₹' + (price * newQty).toFixed(2);

            const decBtn = row.querySelector('.qty-dec');
            const incBtn = row.querySelector('.qty-inc');
            if (decBtn) decBtn.disabled = newQty <= 1;
            if (incBtn) incBtn.disabled = newQty >= stock;
        }

        fetch('{{ route("cart.update") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrf(),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: newQty
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    // Sync confirmed qty (in case server clamped it)
                    const input = document.getElementById('qty-' + productId);
                    if (input && data.quantity !== undefined) {
                        const confirmed = data.quantity;
                        input.value = confirmed;
                        const lineTotal = document.querySelector('#cart-row-' + productId + ' td:nth-child(5)');
                        if (lineTotal && data.line_total !== undefined)
                            lineTotal.textContent = '₹' + parseFloat(data.line_total).toFixed(2);
                        const decBtn = input.closest('.qty-stepper').querySelector('.qty-dec');
                        const incBtn = input.closest('.qty-stepper').querySelector('.qty-inc');
                        if (decBtn) decBtn.disabled = confirmed <= 1;
                        if (incBtn) incBtn.disabled = confirmed >= parseInt(input.dataset.stock);
                    }
                    // Update footer total
                    if (data.cart_total !== undefined) {
                        const footer = document.querySelector(
                            '#cart .d-flex .text-right, #cart .d-flex div:last-child');
                        document.querySelectorAll('#cart .section-card-body > .d-flex div:last-child').forEach(
                            el => {
                                if (el.textContent.startsWith('Total:'))
                                    el.textContent = 'Total: ₹' + parseFloat(data.cart_total).toFixed(2);
                            });
                    }
                    // Update header badge
                    if (data.cart_count !== undefined) {
                        document.querySelectorAll('.cart-badge, #cart-count, .member-badge').forEach(el => {
                            el.textContent = data.cart_count;
                        });
                    }
                } else {
                    showDashToast(data.message || 'Could not update quantity.', false);
                    // Revert the input to the last confirmed server value
                    const input = document.getElementById('qty-' + productId);
                    if (input) {
                        // data.quantity may be returned on validation failure; otherwise keep old value
                    }
                }
            })
            .catch(() => {
                showDashToast('An error occurred. Please try again.', false);
            });
    }

    // ── Remove from Cart ─────────────────────────────────────────
    function removeFromCart(productId, btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

        fetch('{{ route("cart.remove") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrf(),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    const row = document.getElementById('cart-row-' + productId);
                    if (row) row.remove();
                    showDashToast('Removed from cart.', true);
                    // Update header badge
                    document.querySelectorAll('.cart-badge, #cart-count, .member-badge').forEach(el => {
                        if (data.cart_count !== undefined) el.textContent = data.cart_count;
                    });
                    // Show empty state if table has no rows left
                    const tbody = document.querySelector('#cart-table tbody');
                    if (tbody && tbody.children.length === 0) {
                        document.querySelector('#cart-table').closest('[style*="overflow"]').style.display = 'none';
                        const empty = document.getElementById('cart-empty');
                        if (empty) empty.style.display = 'block';
                    }
                } else {
                    showDashToast(data.message || 'Could not remove item.', false);
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-trash"></i>';
                }
            })
            .catch(() => {
                showDashToast('An error occurred. Please try again.', false);
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-trash"></i>';
            });
    }
</script>

{{-- Commission AJAX Pagination --}}
<script>
    (function() {
        const COMMISSION_URL = '{{ route("member.commissions.json") }}';
        let currentPage = 1;

        function statusBadge(status) {
            if (status.toLowerCase() === 'completed') {
                return '<span class="badge-completed">Completed</span>';
            }
            return '<span class="badge-pending">' + status + '</span>';
        }

        function renderRows(data) {
            const tbody = document.getElementById('commissionTableBody');
            if (!data.length) {
                tbody.innerHTML =
                    '<tr><td colspan="5" class="text-center text-muted py-3">No commissions yet</td></tr>';
                return;
            }
            tbody.innerHTML = data.map(function(row) {
                return '<tr>' +
                    '<td>' + row.date + '</td>' +
                    '<td>' + row.from + '</td>' +
                    '<td><span class="text-muted" style="font-size:12px;">' + row.type + '</span></td>' +
                    '<td><strong style="color:#28a745;">&#x20B9; ' + row.amount + '</strong></td>' +
                    '<td>' + statusBadge(row.status) + '</td>' +
                    '</tr>';
            }).join('');
        }

        function renderPagination(current, last, total, perPage) {
            const info = document.getElementById('commissionInfo');
            const nav = document.getElementById('commissionPagination');

            const from = total === 0 ? 0 : (current - 1) * perPage + 1;
            const to = Math.min(current * perPage, total);
            info.textContent = total ? 'Showing ' + from + '–' + to + ' of ' + total : '';

            if (last <= 1) {
                nav.innerHTML = '';
                return;
            }

            let pages = '';
            const btnStyle =
                'style="min-width:32px;height:32px;border-radius:6px;border:1px solid #dee2e6;background:#fff;cursor:pointer;font-size:13px;padding:0 8px;transition:0.2s;"';
            const activeStyle =
                'style="min-width:32px;height:32px;border-radius:6px;border:1px solid var(--color-primary,#28a745);background:var(--color-primary,#28a745);color:#fff;cursor:default;font-size:13px;padding:0 8px;font-weight:600;"';

            // Prev
            pages += '<button ' + btnStyle + (current === 1 ? ' disabled' : '') +
                ' onclick="commissionGoTo(' + (current - 1) + ')">' +
                '<i class="fas fa-chevron-left" style="font-size:11px;"></i></button>';

            // Page numbers with ellipsis
            let pagesToShow = [];
            pagesToShow.push(1);
            if (current > 3) pagesToShow.push('…');
            for (let p = Math.max(2, current - 1); p <= Math.min(last - 1, current + 1); p++) pagesToShow.push(p);
            if (current < last - 2) pagesToShow.push('…');
            if (last > 1) pagesToShow.push(last);

            pagesToShow.forEach(function(p) {
                if (p === '…') {
                    pages += '<span style="padding:0 4px;line-height:32px;color:#aaa;">…</span>';
                } else {
                    pages += '<button ' + (p === current ? activeStyle : btnStyle) +
                        (p === current ? '' : ' onclick="commissionGoTo(' + p + ')"') + '>' + p +
                        '</button>';
                }
            });

            // Next
            pages += '<button ' + btnStyle + (current === last ? ' disabled' : '') +
                ' onclick="commissionGoTo(' + (current + 1) + ')">' +
                '<i class="fas fa-chevron-right" style="font-size:11px;"></i></button>';

            nav.innerHTML = pages;
        }

        window.commissionGoTo = function(page) {
            if (page < 1) return;
            currentPage = page;
            loadCommissions(page);
        };

        function loadCommissions(page) {
            const tbody = document.getElementById('commissionTableBody');
            tbody.innerHTML =
                '<tr><td colspan="5" class="text-center text-muted py-3"><i class="fas fa-spinner fa-spin mr-1"></i> Loading…</td></tr>';
            document.getElementById('commissionPagination').innerHTML = '';
            document.getElementById('commissionInfo').textContent = '';

            fetch(COMMISSION_URL + '?page=' + page, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(function(r) {
                    return r.json();
                })
                .then(function(res) {
                    renderRows(res.data);
                    renderPagination(res.current_page, res.last_page, res.total, res.per_page);
                })
                .catch(function() {
                    tbody.innerHTML =
                        '<tr><td colspan="5" class="text-center text-danger py-3">Failed to load commissions.</td></tr>';
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadCommissions(1);
        });
    })();
</script>
@endpush