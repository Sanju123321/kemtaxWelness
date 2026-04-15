@extends('frontend.layouts.member')

@section('title', 'My Credentials & Achievements')

@push('styles')
    <style>
        .credentials-header {
            background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
            padding: 50px 30px;
            border-radius: 15px;
            margin-bottom: 40px;
            text-align: center;
            color: white;
        }

        .certificate-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 40px;
            border: 3px solid #28a745;
        }

        .certificate-header {
            background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .certificate-body {
            padding: 40px 30px;
        }

        .achievement-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            text-align: center;
            height: 100%;
            border-top: 4px solid;
        }

        .rank-badge {
            display: inline-block;
            padding: 6px 20px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .locked-badge {
            background: #f8d7da;
            color: #721c24;
        }

        .active-badge {
            background: #d4edda;
            color: #155724;
        }

        .milestone-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
            gap: 15px;
        }

        .milestone-item:last-child {
            border-bottom: none;
        }

        .milestone-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }
    </style>
@endpush

@section('content')

    <div class="container py-4" style="max-width: 1200px; padding-bottom: 60px;">

        {{-- Header --}}
        <!-- <div class="credentials-header">
            <h1 style="font-size: 36px; font-weight: 800; margin-bottom: 10px;">🏆 Credentials &amp; Achievements</h1>
            <p style="font-size: 16px; opacity: 0.95; margin: 0;">Track your milestones and showcase your network marketing
                achievements</p>
        </div> -->

        {{-- Member Certificate --}}
        <div class="certificate-card">
            <div class="certificate-header">
                <div
                    style="font-size: 14px; letter-spacing: 3px; text-transform: uppercase; opacity: 0.9; margin-bottom: 10px;">
                    Certificate of Membership</div>
                <h2 style="font-size: 32px; font-weight: 800; margin-bottom: 5px;">KemtexWellness Network</h2>
                <p style="font-size: 14px; opacity: 0.85; margin: 0;">This certifies that you are an official verified member
                </p>
            </div>
            <div class="certificate-body text-center">
                <div
                    style="font-size: 14px; color: #999; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 15px;">
                    Certificate issued to</div>
                <h2 style="font-size: 36px; font-weight: 800; color: #28a745; margin-bottom: 10px;">
                    @auth {{ Auth::user()->name }}
                    @else
                    [Member Name] @endauth
                </h2>
                <p class="text-muted mb-4">Member since {{ auth()->user()->created_at->format('F Y') ?? 'January 2026' }}
                </p>
                <div class="row justify-content-center">
                    <div class="col-md-3 mb-3">
                        <div style="background: #f0f9f4; border: 2px solid #28a745; border-radius: 10px; padding: 15px;">
                            <div style="font-size: 22px; font-weight: 800; color: #28a745;">0</div>
                            <div style="font-size: 11px; color: #999; text-transform: uppercase; font-weight: 700;">Direct
                                Referrals</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div style="background: #f0f9f4; border: 2px solid #28a745; border-radius: 10px; padding: 15px;">
                            <div style="font-size: 22px; font-weight: 800; color: #28a745;">0</div>
                            <div style="font-size: 11px; color: #999; text-transform: uppercase; font-weight: 700;">Team
                                Size</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div style="background: #f0f9f4; border: 2px solid #28a745; border-radius: 10px; padding: 15px;">
                            <div style="font-size: 22px; font-weight: 800; color: #28a745;">₹0</div>
                            <div style="font-size: 11px; color: #999; text-transform: uppercase; font-weight: 700;">Total
                                Earned</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Rank Progression --}}
        <div class="bg-white rounded p-4 shadow-sm mb-4">
            <h5 class="mb-4"><i class="fas fa-star text-color mr-2"></i>Rank Progression</h5>
            <div class="row">
                @php
                    $ranks = [
                        [
                            'name' => 'Starter',
                            'icon' => 'fa-seedling',
                            'color' => '#6c757d',
                            'req' => 'Join with ₹1,000',
                            'status' => 'active',
                        ],
                        [
                            'name' => 'Silver',
                            'icon' => 'fa-award',
                            'color' => '#adb5bd',
                            'req' => '5 Direct + ₹2,500 plan',
                            'status' => 'locked',
                        ],
                        [
                            'name' => 'Gold',
                            'icon' => 'fa-trophy',
                            'color' => '#ffc107',
                            'req' => '10 Direct + ₹5,000 plan',
                            'status' => 'locked',
                        ],
                        [
                            'name' => 'Platinum',
                            'icon' => 'fa-gem',
                            'color' => '#6f42c1',
                            'req' => '20 Direct + ₹10,000 plan',
                            'status' => 'locked',
                        ],
                        [
                            'name' => 'Diamond',
                            'icon' => 'fa-crown',
                            'color' => '#4e73df',
                            'req' => '50 Direct + ₹20,000 plan',
                            'status' => 'locked',
                        ],
                    ];
                @endphp
                @foreach ($ranks as $rank)
                    <div class="col-lg col-md-4 col-6 mb-3">
                        <div class="achievement-card"
                            style="border-top-color: {{ $rank['color'] }}; {{ $rank['status'] === 'locked' ? 'opacity: 0.5;' : '' }}">
                            <i class="fas {{ $rank['icon'] }} fa-2x mb-3" style="color: {{ $rank['color'] }};"></i>
                            <h6>{{ $rank['name'] }}</h6>
                            <p class="text-muted small mb-2">{{ $rank['req'] }}</p>
                            <span class="rank-badge {{ $rank['status'] === 'active' ? 'active-badge' : 'locked-badge' }}">
                                {{ ucfirst($rank['status']) }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Income Milestones --}}
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="bg-white rounded p-4 shadow-sm h-100">
                    <h5 class="mb-4"><i class="fas fa-flag text-color mr-2"></i>Income Milestones</h5>
                    @php
                        $milestones = [
                            [
                                'target' => '₹10,000 earned',
                                'icon' => 'fa-rupee-sign',
                                'color' => '#28a745',
                                'achieved' => false,
                            ],
                            [
                                'target' => '₹50,000 earned',
                                'icon' => 'fa-chart-line',
                                'color' => '#17a2b8',
                                'achieved' => false,
                            ],
                            [
                                'target' => '₹1 Lakh earned',
                                'icon' => 'fa-fire',
                                'color' => '#ff6b35',
                                'achieved' => false,
                            ],
                            [
                                'target' => '₹5 Lakh earned',
                                'icon' => 'fa-gem',
                                'color' => '#6f42c1',
                                'achieved' => false,
                            ],
                            [
                                'target' => '₹10 Lakh earned',
                                'icon' => 'fa-crown',
                                'color' => '#ffc107',
                                'achieved' => false,
                            ],
                        ];
                    @endphp
                    @foreach ($milestones as $m)
                        <div class="milestone-item">
                            <div class="milestone-icon" style="background: {{ $m['achieved'] ? '#d4edda' : '#f8f9fa' }};">
                                <i class="fas {{ $m['icon'] }}"
                                    style="color: {{ $m['achieved'] ? '#28a745' : '#adb5bd' }};"></i>
                            </div>
                            <div>
                                <div class="font-weight-600">{{ $m['target'] }}</div>
                                <small class="text-muted">{{ $m['achieved'] ? 'Achieved ✅' : 'Not yet achieved' }}</small>
                            </div>
                            @if ($m['achieved'])
                                <i class="fas fa-check-circle text-success ml-auto"></i>
                            @else
                                <i class="fas fa-lock text-muted ml-auto small"></i>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="bg-white rounded p-4 shadow-sm h-100">
                    <h5 class="mb-4"><i class="fas fa-users text-color mr-2"></i>Team Milestones</h5>
                    @php
                        $teamMilestones = [
                            [
                                'target' => 'First Referral',
                                'icon' => 'fa-user-plus',
                                'color' => '#28a745',
                                'achieved' => false,
                            ],
                            [
                                'target' => '10 Team Members',
                                'icon' => 'fa-users',
                                'color' => '#17a2b8',
                                'achieved' => false,
                            ],
                            [
                                'target' => '50 Team Members',
                                'icon' => 'fa-network-wired',
                                'color' => '#ffc107',
                                'achieved' => false,
                            ],
                            [
                                'target' => '100 Team Members',
                                'icon' => 'fa-globe',
                                'color' => '#6f42c1',
                                'achieved' => false,
                            ],
                            [
                                'target' => '500 Team Members',
                                'icon' => 'fa-crown',
                                'color' => '#ff6b35',
                                'achieved' => false,
                            ],
                        ];
                    @endphp
                    @foreach ($teamMilestones as $m)
                        <div class="milestone-item">
                            <div class="milestone-icon" style="background: {{ $m['achieved'] ? '#d4edda' : '#f8f9fa' }};">
                                <i class="fas {{ $m['icon'] }}"
                                    style="color: {{ $m['achieved'] ? '#28a745' : '#adb5bd' }};"></i>
                            </div>
                            <div>
                                <div class="font-weight-600">{{ $m['target'] }}</div>
                                <small
                                    class="text-muted">{{ $m['achieved'] ? 'Achieved ✅' : 'Keep growing your team!' }}</small>
                            </div>
                            @if ($m['achieved'])
                                <i class="fas fa-check-circle text-success ml-auto"></i>
                            @else
                                <i class="fas fa-lock text-muted ml-auto small"></i>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
@endsection
