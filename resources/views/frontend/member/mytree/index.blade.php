@extends('frontend.layouts.member')

@section('title', 'My Team - Genealogy Tree')

@push('styles')
    <style>
        /* ── Org-chart Genealogy Tree ───────────────────────── */
        .geo-tree-wrap {
            overflow-x: auto;
            overflow-y: visible;
            padding: 30px 20px 60px;
            min-height: 300px;
            text-align: center;
            width: 100%;
            box-sizing: border-box;
        }

        /* ── Search bar ─────────────────────────────────────── */
        .tree-search-wrap {
            display: flex;
            justify-content: center;
            padding: 14px 16px 0;
        }

        .tree-search-inner {
            position: relative;
            width: 100%;
            max-width: 420px;
        }

        .tree-search-inner input {
            width: 100%;
            padding: 9px 40px 9px 38px;
            border: 1.5px solid #c8e6c9;
            border-radius: 30px;
            font-size: 13px;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            background: #f8fff9;
        }

        .tree-search-inner input:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 3px rgba(40, 167, 69, .15);
            background: #fff;
        }

        .tree-search-inner .srch-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #28a745;
            font-size: 13px;
            pointer-events: none;
        }

        .tree-search-inner .srch-clear {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            font-size: 13px;
            cursor: pointer;
            display: none;
        }

        .tree-search-inner .srch-count {
            position: absolute;
            right: 34px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 11px;
            color: #28a745;
            font-weight: 700;
            white-space: nowrap;
        }

        /* highlighted search match */
        .geo-highlight .geo-avatar {
            box-shadow: 0 0 0 4px #ffeb3b, 0 0 16px rgba(255, 193, 7, .6) !important;
        }

        .geo-highlight .geo-name {
            color: #e65100 !important;
        }

        /* ── Node hover tooltip ─────────────────────────────── */
        .geo-node {
            position: relative;
        }

        .geo-tooltip {
            display: none;
            position: absolute;
            bottom: calc(100% + 12px);
            left: 50%;
            transform: translateX(-50%);
            background: #fff;
            border: 1px solid #d4edda;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .18);
            padding: 10px 14px;
            min-width: 180px;
            max-width: 220px;
            z-index: 999;
            text-align: left;
            pointer-events: none;
        }

        /* arrow */
        .geo-tooltip::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border: 7px solid transparent;
            border-top-color: #fff;
        }

        .geo-tooltip::before {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border: 8px solid transparent;
            border-top-color: #d4edda;
            margin-top: 1px;
        }

        .geo-node:hover .geo-tooltip {
            display: block;
        }

        .geo-tooltip .tt-name {
            font-size: 12px;
            font-weight: 700;
            color: #1e7e34;
            border-bottom: 1px solid #e8f5e9;
            padding-bottom: 5px;
            margin-bottom: 6px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .geo-tooltip .tt-row {
            display: flex;
            justify-content: space-between;
            gap: 8px;
            font-size: 11px;
            margin-bottom: 3px;
        }

        .geo-tooltip .tt-label {
            color: #888;
            white-space: nowrap;
        }

        .geo-tooltip .tt-val {
            font-weight: 700;
            color: #333;
            text-align: right;
        }

        .tt-badge {
            display: inline-block;
            padding: 1px 8px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
        }

        .tt-active {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .tt-inactive {
            background: #fce4ec;
            color: #c62828;
        }

        .tt-plan {
            background: #e3f2fd;
            color: #1565c0;
        }

        /* keep badge-* for any leftover references */
        .badge-active {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .badge-inactive {
            background: #fce4ec;
            color: #c62828;
        }

        .badge-plan {
            background: #e3f2fd;
            color: #1565c0;
        }

        .geo-tree ul {
            list-style: none;
            margin: 0;
            padding-top: 20px;
            position: relative;
            display: flex;
            justify-content: center;
            flex-wrap: nowrap;
        }

        .geo-tree li {
            text-align: center;
            list-style-type: none;
            position: relative;
            padding: 20px 20px 0 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Horizontal connector lines */
        .geo-tree li::before,
        .geo-tree li::after {
            content: '';
            position: absolute;
            top: 0;
            right: 50%;
            border-top: 2px solid #b8d4ba;
            width: 50%;
            height: 20px;
        }

        .geo-tree li::after {
            right: auto;
            left: 50%;
            border-left: 2px solid #b8d4ba;
        }

        /* Only child: no horizontal lines */
        .geo-tree li:only-child::after,
        .geo-tree li:only-child::before {
            display: none;
        }

        .geo-tree li:first-child::before,
        .geo-tree li:last-child::after {
            border: 0 none;
        }

        .geo-tree li:last-child::before {
            border-right: 2px solid #b8d4ba;
            border-radius: 0 5px 0 0;
        }

        .geo-tree li:first-child::after {
            border-radius: 5px 0 0 0;
        }

        /* Node block */
        .geo-node {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        /* Avatar circle */
        .geo-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid #28a745;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: #fff;
            transition: transform .2s, box-shadow .2s;
            box-shadow: 0 4px 14px rgba(0, 0, 0, .18);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .geo-node:hover .geo-avatar {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(40, 167, 69, .35);
        }

        /* Root node larger */
        .geo-tree>ul>li>.geo-node .geo-avatar {
            width: 92px;
            height: 92px;
            font-size: 34px;
            border-width: 4px;
        }

        /* Depth colour variants */
        .depth-0 .geo-avatar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #28a745;
        }

        .depth-1 .geo-avatar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #28a745;
        }

        .depth-2 .geo-avatar {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            border-color: #28a745;
        }

        .depth-3 .geo-avatar {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border-color: #28a745;
        }

        .depth-4 .geo-avatar {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border-color: #28a745;
        }

        .depth-deep .geo-avatar {
            background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);
            border-color: #28a745;
        }

        /* Name label */
        .geo-name {
            margin-top: 10px;
            font-size: 13px;
            font-weight: 600;
            color: #333;
            max-width: 110px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-align: center;
        }

        /* Level badge */
        .geo-level {
            display: inline-block;
            margin-top: 4px;
            padding: 1px 9px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .04em;
            background: #eaf7ef;
            color: #28a745;
            border: 1px solid #b6dfca;
            white-space: nowrap;
        }

        .depth-0 .geo-level {
            background: #e8f5e9;
            color: #2e7d32;
            border-color: #a5d6a7;
        }

        .depth-1 .geo-level {
            background: #e3f2fd;
            color: #1565c0;
            border-color: #90caf9;
        }

        .depth-2 .geo-level {
            background: #f3e5f5;
            color: #6a1b9a;
            border-color: #ce93d8;
        }

        .depth-3 .geo-level {
            background: #fce4ec;
            color: #ad1457;
            border-color: #f48fb1;
        }

        .depth-4 .geo-level {
            background: #e0f7fa;
            color: #00695c;
            border-color: #80cbc4;
        }

        .depth-deep .geo-level {
            background: #f3e5f5;
            color: #4a148c;
            border-color: #ce93d8;
        }

        /* Expand/collapse toggle dot at bottom of avatar */
        .geo-toggle {
            position: absolute;
            bottom: -26px;
            left: 50%;
            transform: translateX(-50%);
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #28a745;
            color: #fff;
            font-size: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            border: 2px solid #fff;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .2);
            transition: background .2s;
        }

        .geo-toggle:hover {
            background: #155724;
        }

        /* ── Loading / Error states ─── */
        #tree-loading,
        #tree-error {
            display: none;
        }

        #tree-loading {
            text-align: center;
            padding: 60px 0;
            color: #28a745;
        }

        #tree-error {
            text-align: center;
            padding: 40px 0;
            color: #dc3545;
        }

        .tree-controls .btn {
            font-size: 13px;
        }

        /* ── Sidebar layout ─────────────────────────────── */
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
    </style>
@endpush

@section('content')
    @php $isInactive = auth()->check() && auth()->user()->status == 'inactive'; @endphp
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
            <a href="{{ route('member.dashboard') }}"
                class="{{ request()->routeIs('member.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt nav-icon"></i> Dashboard
            </a>
            <a href="{{ route('member.wallet') }}"
                class="{{ request()->routeIs('member.wallet') ? 'active' : '' }}{{ $isInactive ? ' disabled' : '' }}">
                <i class="fas fa-wallet nav-icon"></i> Wallet
            </a>
            <div class="nav-label">My Team</div>
            <a href="{{ route('member.team') }}" id="sidebarTreeLink" class="{{ $isInactive ? 'disabled' : '' }}">
                <i class="fas fa-sitemap nav-icon"></i> Genealogy Tree
            </a>
            <a href="{{ route('member.credentials') }}"
                class="{{ request()->routeIs('member.credentials') ? 'active' : '' }}{{ $isInactive ? ' disabled' : '' }}">
                <i class="fas fa-award nav-icon"></i> My Achievements
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
            <a href="{{ route('member.dashboard') }}#referral-commission" id="sidebarCommissionLink"
                onclick="showSection('referralCommissionSection'); return false;"
                class="{{ $isInactive ? 'disabled' : '' }}">
                <i class="fas fa-hand-holding-usd nav-icon"></i> Referral Commission
            </a>
            <div class="nav-label">My Shopping</div>
            <a href="{{ route('member.dashboard') }}#wishlist" onclick="scrollToSection('wishlist'); return false;"
                class="{{ $isInactive ? 'disabled' : '' }}">
                <i class="fas fa-heart nav-icon" style="color:#e74c3c;"></i> My Favorites
                @if (isset($wishlistItems) && $wishlistItems->count())
                <span class="ml-auto"
                    style="background:#e74c3c;color:white;font-size:10px;font-weight:700;padding:2px 7px;border-radius:10px;">{{ $wishlistItems->count() }}</span>
                @endif
            </a>
            <a href="{{ route('member.dashboard') }}#cart" onclick="scrollToSection('cart'); return false;"
                class="{{ $isInactive ? 'disabled' : '' }}">
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

{{-- Main Content --}}
<div class="dash-main">

    {{-- Page header --}}
    <div
        style="background:linear-gradient(135deg,#28a745 0%,#1e7e34 100%);padding:20px 24px;color:white;margin-bottom:24px;border-radius:10px;display:flex;align-items:center;justify-content:space-between;">
        <div>
            <h5 class="mb-0 font-weight-bold"><i class="fas fa-sitemap mr-2"></i>My Genealogy Tree</h5>
            <small class="opacity-75">Your full downline network</small>
        </div>
        <a href="{{ route('member.dashboard') }}" class="btn btn-light btn-sm">
            <i class="fas fa-arrow-left mr-1"></i>Dashboard
        </a>
    </div>

    <div>

        {{-- Stats row --}}
        <div class="row mb-4" id="tree-stats" style="display:none!important;">
            <div class="col-6 col-md-3 mb-3">
                <div class="card border-0 shadow-sm text-center py-3">
                    <div class="h4 text-success mb-0 font-weight-bold" id="stat-direct">0</div>
                    <small class="text-muted">Direct Members</small>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card border-0 shadow-sm text-center py-3">
                    <div class="h4 text-primary mb-0 font-weight-bold" id="stat-total">0</div>
                    <small class="text-muted">Total Team</small>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card border-0 shadow-sm text-center py-3">
                    <div class="h4 text-warning mb-0 font-weight-bold" id="stat-levels">0</div>
                    <small class="text-muted">Levels Deep</small>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="card border-0 shadow-sm text-center py-3">
                    <div class="h4 text-info mb-0 font-weight-bold" id="stat-active">0</div>
                    <small class="text-muted">Active Members</small>
                </div>
            </div>
        </div>

        {{-- Tree Card --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-bottom py-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="mb-0 font-weight-bold text-dark"><i
                            class="fas fa-network-wired text-success mr-2"></i>Network Tree</h6>
                    <div class="tree-controls d-flex gap-2">
                        <button class="btn btn-outline-success btn-sm mr-1" id="btn-expand-all">
                            <i class="fas fa-expand-arrows-alt mr-1"></i>Expand All
                        </button>
                        <button class="btn btn-outline-secondary btn-sm mr-1" id="btn-collapse-all">
                            <i class="fas fa-compress-arrows-alt mr-1"></i>Collapse All
                        </button>
                        <button class="btn btn-outline-primary btn-sm" id="btn-reload">
                            <i class="fas fa-sync-alt mr-1"></i>Refresh
                        </button>
                    </div>
                </div>
                {{-- Search bar --}}
                <div class="tree-search-wrap">
                    <div class="tree-search-inner">
                        <i class="fas fa-search srch-icon"></i>
                        <input type="text" id="tree-search" placeholder="Search member by name…"
                            autocomplete="off">
                        <span class="srch-count" id="srch-count" style="display:none;"></span>
                        <i class="fas fa-times srch-clear" id="srch-clear"></i>
                    </div>
                </div>
            </div>
            <div class="card-body p-3" style="min-height:320px;">

                {{-- Loading --}}
                <div id="tree-loading">
                    <div class="spinner-border text-success" role="status"><span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Loading your team network…</p>
                </div>

                {{-- Error --}}
                <div id="tree-error">
                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                    <p id="tree-error-msg">Failed to load tree. Please try again.</p>
                    <button class="btn btn-sm btn-outline-danger" id="btn-retry">Retry</button>
                </div>

                {{-- Tree container --}}
                <div id="tree-container">
                    <div class="geo-tree-wrap">
                        <div class="geo-tree" id="tree-root"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Legend --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body py-2 px-4 d-flex flex-wrap" style="gap:12px;">
                <strong class="text-muted" style="font-size:13px;line-height:2;">LEGEND:</strong>
                <span style="font-size:12px;"><span
                        style="display:inline-block;width:14px;height:14px;border-radius:50%;background:linear-gradient(135deg,#f39c12,#e67e22);border:2px solid #28a745;vertical-align:middle;margin-right:4px;"></span>You</span>
                <span style="font-size:12px;"><span
                        style="display:inline-block;width:14px;height:14px;border-radius:50%;background:linear-gradient(135deg,#3498db,#2980b9);border:2px solid #3498db;vertical-align:middle;margin-right:4px;"></span>Level
                    1</span>
                <span style="font-size:12px;"><span
                        style="display:inline-block;width:14px;height:14px;border-radius:50%;background:linear-gradient(135deg,#9b59b6,#8e44ad);border:2px solid #9b59b6;vertical-align:middle;margin-right:4px;"></span>Level
                    2</span>
                <span style="font-size:12px;"><span
                        style="display:inline-block;width:14px;height:14px;border-radius:50%;background:linear-gradient(135deg,#e74c3c,#c0392b);border:2px solid #e74c3c;vertical-align:middle;margin-right:4px;"></span>Level
                    3</span>
                <span style="font-size:12px;"><span
                        style="display:inline-block;width:14px;height:14px;border-radius:50%;background:linear-gradient(135deg,#1abc9c,#16a085);border:2px solid #1abc9c;vertical-align:middle;margin-right:4px;"></span>Level
                    4</span>
                <span style="font-size:12px;"><span
                        style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#28a745;vertical-align:middle;margin-right:4px;"></span>Active</span>
                <span style="font-size:12px;"><span
                        style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#dc3545;vertical-align:middle;margin-right:4px;"></span>Inactive</span>
            </div>
        </div>

    </div>{{-- /.inner-wrapper --}}
</div>{{-- /.dash-main --}}
</div>{{-- /.dash-layout --}}

@endsection

@push('scripts')
<script>
    let storageUrl = "{{ asset('storage') }}";
</script>
<script>
    (function() {
        'use strict';

        const TREE_URL = "{{ route('member.team.tree') }}";
        let treeData = null;
        let totalCount = 0,
            directCount = 0,
            maxDepth = 0,
            activeCount = 0;
        let nodeRegistry = {}; // id -> node data (for search & modal)

        /* ---- Fetch tree ---- */
        function loadTree() {
            showLoading();
            fetch(TREE_URL, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(r => {
                    if (!r.ok) throw new Error('Server error ' + r.status);
                    return r.json();
                })
                .then(data => {
                    treeData = data;
                    hideLoading();
                    resetCounters();
                    const root = document.getElementById('tree-root');
                    root.innerHTML = '';
                    const ul = document.createElement('ul');
                    ul.appendChild(buildNode(data, 0));
                    root.appendChild(ul);
                    updateStats();
                })
                .catch(err => showError(err.message));
        }

        function resetCounters() {
            totalCount = 0;
            directCount = 0;
            maxDepth = 0;
            activeCount = 0;
            nodeRegistry = {};
        }

        /* ---- Build org-chart DOM node (li + ul) ---- */
        function buildNode(node, depth) {
            totalCount++;
            if (depth > maxDepth) maxDepth = depth;
            if (depth === 1) directCount++;
            if (node.status === 'active') activeCount++;

            const depthClass = depth <= 4 ? 'depth-' + depth : 'depth-deep';
            const hasChildren = node.children && node.children.length > 0;

            const li = document.createElement('li');
            li.dataset.id = node.id;

            // Store in registry for search & modal
            nodeRegistry[node.id] = {
                node: node,
                depth: depth,
                liEl: li
            };

            // Node wrapper
            const geoNode = document.createElement('div');
            geoNode.className = 'geo-node ' + depthClass;
            geoNode.dataset.id = node.id;
            geoNode.style.cursor = 'pointer';
            geoNode.title = 'Click to view plan info';

            // Avatar
            const avatar = document.createElement('div');
            avatar.className = 'geo-avatar';
            // avatar.innerHTML = '<i class="fas fa-user"></i>';
            avatar.innerHTML = node.profile_photo ? '<img src="' + storageUrl + '/' + node.profile_photo + '" style="width:100%;height:100%;border-radius:50%;">' : '<i class="fas fa-user"></i>';

            // Name
            const nameEl = document.createElement('div');
            nameEl.className = 'geo-name';
            nameEl.textContent = node.name || 'Unknown';
            nameEl.title = node.name || 'Unknown';

            // Level badge
            const levelEl = document.createElement('span');
            levelEl.className = 'geo-level';
            levelEl.textContent = depth === 0 ? 'You' : 'Level ' + depth;

            // Hover tooltip
            const tooltip = document.createElement('div');
            tooltip.className = 'geo-tooltip';
            const statusCls = node.status === 'active' ? 'tt-active' : 'tt-inactive';
            const statusTxt = node.status === 'active' ? 'Active' : 'Inactive';
            const planTxt = (node.plan_name && node.plan_name !== 'No Plan') ? node.plan_name : 'No Plan';
            const planCls = (node.plan_name && node.plan_name !== 'No Plan') ? 'tt-plan' : '';
            tooltip.innerHTML =
                '<div class="tt-name"><i class="fas fa-user mr-1"></i>' + (node.name || 'Unknown') + '</div>' +
                
//                 '<div class="tt-name d-flex align-items-center">' +
//     (node.profile_photo 
//         ? '<img src="' + storageUrl + '/' + node.profile_photo + '" class="tt-avatar">' 
//         : '<i class="fas fa-user mr-1"></i>') +
//     '<span>' + (node.name || 'Unknown') + '</span>' +
// '</div>'
                '<div class="tt-row"><span class="tt-label">Status</span><span class="tt-val"><span class="tt-badge ' +
                statusCls + '">' + statusTxt + '</span></span></div>' +
                '<div class="tt-row"><span class="tt-label">Plan</span><span class="tt-val"><span class="tt-badge ' +
                planCls + '">' + planTxt + '</span></span></div>' +
                (node.plan_price > 0 ?
                    '<div class="tt-row"><span class="tt-label">Price</span><span class="tt-val">\u20b9' + Number(
                        node.plan_price).toLocaleString('en-IN') + '</span></div>' : '') +
                (node.daily_cap > 0 ?
                    '<div class="tt-row"><span class="tt-label">Daily Cap</span><span class="tt-val">\u20b9' +
                    Number(node.daily_cap).toLocaleString('en-IN') + '</span></div>' : '') +
                (node.total_cap > 0 ?
                    '<div class="tt-row"><span class="tt-label">Total Cap</span><span class="tt-val">\u20b9' +
                    Number(node.total_cap).toLocaleString('en-IN') + '</span></div>' : '');

            geoNode.appendChild(avatar);
            geoNode.appendChild(nameEl);
            geoNode.appendChild(levelEl);
            geoNode.appendChild(tooltip);
            geoNode.style.cursor = 'default';

            li.appendChild(geoNode);

            if (hasChildren) {
                // Expand/collapse toggle
                const toggle = document.createElement('div');
                toggle.className = 'geo-toggle';
                toggle.title = 'Toggle children';
                toggle.innerHTML = '<i class="fas fa-minus"></i>';
                geoNode.appendChild(toggle);

                // Children ul
                const childUl = document.createElement('ul');
                node.children.forEach(function(child) {
                    childUl.appendChild(buildNode(child, depth + 1));
                });
                li.appendChild(childUl);

                toggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const visible = childUl.style.display !== 'none';
                    childUl.style.display = visible ? 'none' : '';
                    toggle.innerHTML = visible ? '<i class="fas fa-plus"></i>' :
                        '<i class="fas fa-minus"></i>';
                });
            }

            return li;
        }

        /* ---- Search ---- */
        function searchMembers(query) {
            // Remove all previous highlights
            document.querySelectorAll('#tree-root .geo-highlight').forEach(function(el) {
                el.classList.remove('geo-highlight');
            });

            if (!query) {
                document.getElementById('srch-count').style.display = 'none';
                return;
            }

            const q = query.toLowerCase();
            let matches = [];

            Object.values(nodeRegistry).forEach(function(entry) {
                if ((entry.node.name || '').toLowerCase().includes(q)) {
                    matches.push(entry);
                }
            });

            const countEl = document.getElementById('srch-count');
            if (matches.length === 0) {
                countEl.textContent = 'No match';
                countEl.style.color = '#dc3545';
                countEl.style.display = 'inline';
                return;
            }

            countEl.textContent = matches.length + ' found';
            countEl.style.color = '#28a745';
            countEl.style.display = 'inline';

            matches.forEach(function(entry) {
                // Highlight the geo-node inside the li
                const geoNode = entry.liEl.querySelector(':scope > .geo-node');
                if (geoNode) geoNode.classList.add('geo-highlight');

                // Expand all ancestors (parent ULs) so this node is visible
                let parent = entry.liEl.parentElement;
                while (parent && parent.id !== 'tree-root') {
                    if (parent.tagName === 'UL') {
                        parent.style.display = '';
                        // Update toggle icon of the li that contains this UL
                        const ownerLi = parent.parentElement;
                        if (ownerLi && ownerLi.tagName === 'LI') {
                            const toggle = ownerLi.querySelector(':scope > .geo-node > .geo-toggle');
                            if (toggle) toggle.innerHTML = '<i class="fas fa-minus"></i>';
                        }
                    }
                    parent = parent.parentElement;
                }
            });

            // Scroll first match into view
            const firstGeo = matches[0].liEl.querySelector(':scope > .geo-node');
            if (firstGeo) firstGeo.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }

        document.getElementById('tree-search').addEventListener('input', function() {
            const val = this.value.trim();
            document.getElementById('srch-clear').style.display = val ? 'inline' : 'none';
            searchMembers(val);
        });

        document.getElementById('srch-clear').addEventListener('click', function() {
            document.getElementById('tree-search').value = '';
            this.style.display = 'none';
            document.getElementById('srch-count').style.display = 'none';
            document.querySelectorAll('#tree-root .geo-highlight').forEach(function(el) {
                el.classList.remove('geo-highlight');
            });
        });

        /* ---- Expand / Collapse All ----*/
        function setAllChildren(show) {
            // skip the root ul (first level), toggle all nested uls
            document.querySelectorAll('#tree-root ul ul').forEach(function(ul) {
                ul.style.display = show ? '' : 'none';
            });
            document.querySelectorAll('#tree-root .geo-toggle').forEach(function(btn) {
                btn.innerHTML = show ? '<i class="fas fa-minus"></i>' : '<i class="fas fa-plus"></i>';
            });
        }

        /* ---- Stats ---- */
        function updateStats() {
            document.getElementById('stat-direct').textContent = directCount;
            document.getElementById('stat-total').textContent = totalCount - 1;
            document.getElementById('stat-levels').textContent = maxDepth;
            document.getElementById('stat-active').textContent = activeCount;
            document.getElementById('tree-stats').style.setProperty('display', 'flex', 'important');
        }

        /* ---- UI helpers ---- */
        function showLoading() {
            document.getElementById('tree-loading').style.display = 'block';
            document.getElementById('tree-error').style.display = 'none';
            document.getElementById('tree-container').style.display = 'none';
        }

        function hideLoading() {
            document.getElementById('tree-loading').style.display = 'none';
            document.getElementById('tree-container').style.display = 'block';
        }

        function showError(msg) {
            document.getElementById('tree-loading').style.display = 'none';
            document.getElementById('tree-container').style.display = 'none';
            document.getElementById('tree-error').style.display = 'block';
            document.getElementById('tree-error-msg').textContent = msg || 'Could not load tree.';
        }

        /* ---- Event bindings ---- */
        document.getElementById('btn-expand-all').addEventListener('click', function() {
            setAllChildren(true);
        });
        document.getElementById('btn-collapse-all').addEventListener('click', function() {
            setAllChildren(false);
        });
        document.getElementById('btn-reload').addEventListener('click', loadTree);
        document.getElementById('btn-retry').addEventListener('click', loadTree);

        /* ---- Boot ---- */
        loadTree();
    })();
</script>
@endpush
