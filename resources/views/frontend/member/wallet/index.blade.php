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
    </style>
@endpush

@section('content')
    <div class="container py-4" style="max-width: 1000px; padding-bottom: 60px;">

        {{-- Wallet Header --}}
        <div class="wallet-header">
            <div class="balance-label">Total Wallet Balance</div>
            <div class="balance-amount">₹0.00</div>
            <p class="text-white-50 small">Last updated: {{ now()->format('d M Y, H:i') }}</p>
        </div>

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
                        <input type="number" class="form-control" placeholder="Enter amount (₹)" min="500" disabled>
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

            <div class="text-center py-5 text-muted">
                <i class="fas fa-receipt fa-3x mb-3 opacity-50"></i>
                <p class="mb-2">No transactions yet.</p>
                <p class="small">Your earnings and withdrawals will appear here once you start referring members.</p>
                <a href="{{ route('member.dashboard') }}" class="btn btn-main btn-round-full btn-sm mt-2">Go to
                    Dashboard</a>
            </div>
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
    </div>
@endsection
