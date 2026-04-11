@extends('frontend.layouts.member')

@section('title', 'My Wallet')

@push('styles')
    <style>
        .wallet-header {
            background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
            padding: 40px 0;
            color: white;
            margin-bottom: 40px;
            border-radius: 12px;
            text-align: center;
        }

        .balance-amount {
            font-size: 48px;
            font-weight: 800;
            color: #28a745;
            margin: 10px 0;
        }

        .balance-label {
            color: #666;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .wallet-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border-top: 4px solid;
            margin-bottom: 20px;
        }

        .transaction-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .transaction-item:last-child {
            border-bottom: none;
        }

        .transaction-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
        }

        .transaction-icon.credit {
            background: #28a745;
        }

        .transaction-icon.debit {
            background: #ff6b35;
        }

        .amount-credit {
            color: #28a745;
            font-weight: 700;
            font-size: 16px;
        }

        .amount-debit {
            color: #ff6b35;
            font-weight: 700;
            font-size: 16px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        /* Dashboard layout */
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

        @media (max-width: 768px) {
            .dash-sidebar {
                display: none;
            }

            .dash-main {
                padding: 16px 12px 40px;
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
                    style="
                    background: {{ $isInactive ? '#f8d7da' : '#e9f7ef' }};
                    border: 2px solid {{ $isInactive ? '#dc3545' : '#28a745' }};
                    border-radius: 50%;
                    width: 40px; height: 40px;
                    display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="fas fa-user {{ $isInactive ? 'text-danger' : 'text-success' }}" style="font-size:18px;"></i>
                </div>
                <div>
                    <div class="u-name">@auth{{ Auth::user()->name }}
                    @else
                    Member @endauth
                </div>
                <div class="u-role" style="color: {{ $isInactive ? '#dc3545' : '#28a745' }};">
                    <i class="fas fa-circle" style="font-size:7px;margin-right:3px;"></i>
                    @auth{{ ucfirst(Auth::user()->status) }}
                @else
                Inactive @endauth
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-label">Main Menu</div>
        <a href="{{ route('member.dashboard') }}">
            <i class="fas fa-tachometer-alt nav-icon"></i> Dashboard
        </a>
        <a href="{{ route('member.wallet') }}" class="active">
            <i class="fas fa-wallet nav-icon"></i> Wallet
        </a>
        <a href="{{ route('member.credentials') }}" class="{{ $isInactive ? 'disabled' : '' }}">
            <i class="fas fa-award nav-icon"></i> Credentials
        </a>
        <div class="nav-label">More</div>
        <a href="{{ route('pricing') }}">
            <i class="fas fa-tags nav-icon"></i> Pricing
        </a>
        <a href="{{ route('contact') }}">
            <i class="fas fa-headset nav-icon"></i> Support
        </a>
        <div class="nav-label">My Team</div>
        <a href="{{ route('member.team') }}" class="{{ $isInactive ? 'disabled' : '' }}">
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
    <div style="max-width: 900px;">

        {{-- Wallet Header --}}
        <div class="wallet-header">
            <div class="balance-label">Total Wallet Balance</div>
            <div class="balance-amount">₹{{ number_format($walletBalance, 2) }}</div>
            <p class="text-white-50 small">Last updated: {{ now()->format('d M Y, H:i') }}</p>
        </div>

        {{-- Stats Row --}}
        <div class="row mb-4">
            <div class="col-sm-6 col-md-3 mb-3">
                <div class="wallet-card" style="border-top-color:#28a745;padding:18px 20px;">
                    <div class="text-muted"
                        style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;">Today
                        Earned
                    </div>
                    <div style="font-size:1.4rem;font-weight:800;color:#28a745;">
                        ₹{{ number_format($todayEarned, 2) }}</div>
                    @if ($dailyCap > 0)
                        <div style="font-size:11px;color:#888;">of ₹{{ number_format($dailyCap) }} daily cap</div>
                    @endif
                </div>
            </div>
            <div class="col-sm-6 col-md-3 mb-3">
                <div class="wallet-card" style="border-top-color:#e74c3c;padding:18px 20px;">
                    <div class="text-muted"
                        style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;">Today
                        Lost
                    </div>
                    <div style="font-size:1.4rem;font-weight:800;color:#e74c3c;">
                        ₹{{ number_format($todayLost, 2) }}</div>
                    <div style="font-size:11px;color:#888;">cap overflow → company</div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 mb-3">
                <div class="wallet-card" style="border-top-color:#3498db;padding:18px 20px;">
                    <div class="text-muted"
                        style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;">Total
                        Earned
                    </div>
                    <div style="font-size:1.4rem;font-weight:800;color:#3498db;">
                        ₹{{ number_format($totalEarned, 2) }}</div>
                    @if ($totalCap > 0)
                        <div style="font-size:11px;color:#888;">of ₹{{ number_format($totalCap) }} total cap</div>
                    @endif
                </div>
            </div>
            <div class="col-sm-6 col-md-3 mb-3">
                <div class="wallet-card" style="border-top-color:#9b59b6;padding:18px 20px;">
                    <div class="text-muted"
                        style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;">My
                        Plan</div>
                    <div style="font-size:1.4rem;font-weight:800;color:#9b59b6;">{{ $plan?->name ?? 'No Plan' }}
                    </div>
                    <div style="font-size:11px;color:#888;">₹{{ number_format($plan?->price ?? 0) }}</div>
                </div>
            </div>
        </div>

        {{-- Daily Cap Progress --}}
        @if ($dailyCap > 0)
            @php
                $dailyPct = min(100, $dailyCap > 0 ? round(($todayEarned / $dailyCap) * 100, 1) : 0);
                $totalPct = min(100, $totalCap > 0 ? round(($totalEarned / $totalCap) * 100, 1) : 0);
                $barColor = $dailyPct >= 90 ? '#e74c3c' : ($dailyPct >= 70 ? '#f39c12' : '#28a745');
            @endphp
            <div class="wallet-card mb-4" style="border-top-color:{{ $barColor }};">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0"><i class="fas fa-chart-bar mr-2"
                            style="color:{{ $barColor }};"></i>Daily Cap
                        Usage</h6>
                    @if ($dailyPct >= 70)
                        <span
                            style="background:{{ $barColor }};color:#fff;font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">
                            ⚠️ {{ $dailyPct }}% Used — Upgrade Plan!
                        </span>
                    @else
                        <span style="font-size:12px;color:#888;">{{ $dailyPct }}% used today</span>
                    @endif
                </div>
                <div style="background:#f0f0f0;border-radius:20px;height:14px;overflow:hidden;margin-bottom:6px;">
                    <div
                        style="width:{{ $dailyPct }}%;height:100%;border-radius:20px;background:{{ $barColor }};transition:width .4s;">
                    </div>
                </div>
                <div class="d-flex justify-content-between" style="font-size:12px;color:#888;">
                    <span>₹{{ number_format($todayEarned, 2) }} earned today</span>
                    <span>₹{{ number_format(max(0, $dailyCap - $todayEarned), 2) }} remaining</span>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3 mb-1">
                    <h6 class="mb-0" style="font-size:13px;"><i
                            class="fas fa-layer-group mr-2 text-primary"></i>Total Cap
                        Usage</h6>
                    <span style="font-size:12px;color:#888;">{{ $totalPct }}% of lifetime cap</span>
                </div>
                <div style="background:#f0f0f0;border-radius:20px;height:10px;overflow:hidden;">
                    <div style="width:{{ $totalPct }}%;height:100%;border-radius:20px;background:#3498db;">
                    </div>
                </div>
            </div>
        @endif

        {{-- Action Cards --}}
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="wallet-card" style="border-top-color: #0066cc;">
                    <h5><i class="fas fa-plus-circle text-primary mr-2"></i>Add Funds</h5>
                    <p class="text-muted small mb-3">Top up your wallet with earnings from commissions</p>
                    <div class="form-group">
                        <input type="number" class="form-control" placeholder="Enter amount (₹)" min="1">
                        <small class="text-muted">Minimum ₹100</small>
                    </div>
                    <button class="btn btn-block"
                        style="background: #0066cc; color: white; border-radius: 8px; font-weight: 700;">
                        <i class="fas fa-plus mr-2"></i>Add Funds
                    </button>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="wallet-card" style="border-top-color: #ff6b35;">
                    <h5><i class="fas fa-arrow-up text-warning mr-2"></i>Withdraw</h5>
                    <p class="text-muted small mb-3">Withdraw earnings to your bank account</p>
                    <div class="form-group">
                        <input type="number" class="form-control" placeholder="Enter amount (₹)" min="500"
                            disabled>
                        <small class="text-muted">Minimum withdrawal: ₹500</small>
                    </div>
                    <button class="btn btn-block"
                        style="background: #ff6b35; color: white; border-radius: 8px; font-weight: 700;" disabled>
                        <i class="fas fa-arrow-up mr-2"></i>Withdraw Funds
                    </button>
                </div>
            </div>
        </div>

        {{-- Transaction History --}}
        <div class="section-card bg-white rounded p-4 shadow-sm">
            <h5 class="mb-4 pb-3" style="border-bottom: 2px solid #f0f0f0;">
                <i class="fas fa-history text-color mr-2"></i>Transaction History
            </h5>

            @forelse($recentTransactions as $txn)
                <div class="transaction-item">
                    <div class="d-flex align-items-center" style="gap:14px;">
                        <div class="transaction-icon credit">
                            <i class="fas {{ $txn->type === 'direct' ? 'fa-user-plus' : 'fa-layer-group' }}"></i>
                        </div>
                        <div>
                            <div style="font-size:14px;font-weight:600;color:#333;">
                                {{ $txn->type === 'direct' ? 'Direct Referral' : 'Level ' . $txn->level . ' Commission' }}
                            </div>
                            <div style="font-size:12px;color:#888;">From: {{ $txn->fromUser?->name ?? 'N/A' }}
                            </div>
                            <div style="font-size:11px;color:#aaa;">{{ $txn->created_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="amount-credit">+ ₹{{ number_format($txn->amount, 2) }}</div>
                        <span class="status-badge status-completed">Credited</span>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-receipt fa-3x mb-3 opacity-50"></i>
                    <p class="mb-2">No transactions yet.</p>
                    <p class="small">Your earnings will appear here once commissions are credited.</p>
                    <a href="{{ route('member.dashboard') }}" class="btn btn-main btn-round-full btn-sm mt-2">Go
                        to
                        Dashboard</a>
                </div>
            @endforelse
        </div>

        {{-- Info Cards --}}
        <div class="row mt-4">
            @php
                $infos = [
                    [
                        'icon' => 'fa-clock',
                        'title' => 'Processing Time',
                        'text' => 'Withdrawals are processed within 3-5 business days.',
                        'color' => '#17a2b8',
                    ],
                    [
                        'icon' => 'fa-shield-alt',
                        'title' => 'Secure Transfers',
                        'text' => 'All transactions are encrypted and fully secure.',
                        'color' => '#28a745',
                    ],
                    [
                        'icon' => 'fa-headset',
                        'title' => 'Need Help?',
                        'text' => 'Contact support for wallet-related queries anytime.',
                        'color' => '#6f42c1',
                    ],
                ];
            @endphp
            @foreach ($infos as $info)
                <div class="col-md-4 mb-3">
                    <div class="bg-white rounded p-4 shadow-sm text-center">
                        <i class="fas {{ $info['icon'] }} fa-2x mb-3" style="color: {{ $info['color'] }};"></i>
                        <h6>{{ $info['title'] }}</h6>
                        <p class="text-muted small mb-0">{{ $info['text'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>{{-- /.max-width wrapper --}}
</div>{{-- /.dash-main --}}
</div>{{-- /.dash-layout --}}
@endsection
