@extends('frontend.layouts.member')

@section('title', 'My Credentials & Achievements')

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
        background: #fff;
        min-height: calc(100vh - 80px);
        box-shadow: 2px 0 12px rgba(0, 0, 0, .06);
        position: sticky;
        top: 0;
        display: flex;
        flex-direction: column;
    }

    .sidebar-user { display: flex; align-items: center; gap: 12px; padding: 20px 18px 16px; border-bottom: 1px solid #f0f0f0; }
    .sidebar-user .u-name { font-size: 13px; font-weight: 700; color: #333; line-height: 1.3; }
    .sidebar-user .u-role { font-size: 11px; font-weight: 600; color: #28a745; }
    .sidebar-nav { padding: 10px 0; flex: 1; }
    .sidebar-nav .nav-label { padding: 10px 18px 4px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #aaa; }
    .sidebar-nav a { display: flex; align-items: center; gap: 10px; padding: 11px 18px; font-size: 14px; font-weight: 500; color: #555; text-decoration: none; border-left: 3px solid transparent; transition: all .15s; }
    .sidebar-nav a:hover { background: #f4f9f6; color: #28a745; border-left-color: #28a745; }
    .sidebar-nav a.active { background: #eaf7ef; color: #28a745; font-weight: 700; border-left-color: #28a745; }
    .sidebar-footer { padding: 14px 18px; border-top: 1px solid #f0f0f0; }
    .dash-main { flex: 1; min-width: 0; padding: 24px 20px 60px; }

    .cert-share-row {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
        margin-top: 10px;
    }

    .cert-share-btn {
        border: 0;
        border-radius: 999px;
        padding: 8px 14px;
        font-size: 13px;
        font-weight: 700;
        color: #fff;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        cursor: pointer;
    }

    .cert-share-wa { background: #25d366; }
    .cert-share-fb { background: #1877f2; }
    .cert-share-x { background: #111827; }
    .cert-share-copy { background: #6b7280; }
    .cert-share-download { background: #28a745; }
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
    @media (max-width: 991px) {
        .dash-layout { display: block; }
        .dash-sidebar { display: none; }
        .dash-main { padding: 14px 12px 40px; }
    }
</style>
@endpush

@section('content')

<div class="dash-layout">
    @php $isInactive = auth()->check() && auth()->user()->status == 'inactive'; @endphp
    <aside class="dash-sidebar">
        <div class="sidebar-user">
            <div style="background:{{ $isInactive ? '#f8d7da' : '#e9f7ef' }};border:2px solid {{ $isInactive ? '#dc3545' : '#28a745' }};border-radius:50%;width:40px;height:40px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fas fa-user {{ $isInactive ? 'text-danger' : 'text-success' }}" style="font-size:18px;"></i>
            </div>
            <div>
                <div class="u-name">{{ Auth::user()->name ?? 'Member' }}</div>
                <div class="u-role"><i class="fas fa-circle" style="font-size:7px;margin-right:3px;"></i>{{ ucfirst(Auth::user()->status ?? 'inactive') }}</div>
            </div>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-label">Main Menu</div>
            <a href="{{ route('member.dashboard') }}"><i class="fas fa-tachometer-alt nav-icon"></i> Dashboard</a>
            <a href="{{ route('member.wallet') }}" class="{{ $isInactive ? 'disabled' : '' }}"><i class="fas fa-wallet nav-icon"></i> Wallet</a>
            <div class="nav-label">My Team</div>
            <a href="{{ route('member.team') }}"><i class="fas fa-sitemap nav-icon"></i> Genealogy Tree</a>
            <a href="{{ route('member.credentials') }}" class="active"><i class="fas fa-award nav-icon"></i> My Achievements</a>
            <div class="nav-label">Account</div>
            <a href="{{ route('member.kyc.index') }}"><i class="fas fa-id-card nav-icon"></i> KYC Documents</a>
            <a href="{{ route('member.profile') }}"><i class="fas fa-user-edit nav-icon"></i> My Profile</a>
            <div class="nav-label">More</div>
            <a href="{{ route('pricing') }}"><i class="fas fa-tags nav-icon"></i> Pricing &amp; Plans</a>
            <a href="{{ route('contact') }}"><i class="fas fa-headset nav-icon"></i> Support</a>
            <a href="{{ route('member.commissions.history') }}"><i class="fas fa-hand-holding-usd nav-icon"></i> Recent Commissions</a>
        </nav>
        <div class="sidebar-footer">
            <a href="{{ route('logout') }}" style="display:flex;align-items:center;gap:10px;font-size:14px;color:#dc3545;font-weight:600;text-decoration:none;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </aside>

    <div class="dash-main">
<div class="container py-4" style="max-width: 1200px; padding-bottom: 60px;">

    {{-- Header --}}
    <!-- <div class="credentials-header">
            <h1 style="font-size: 36px; font-weight: 800; margin-bottom: 10px;">🏆 Credentials &amp; Achievements</h1>
            <p style="font-size: 16px; opacity: 0.95; margin: 0;">Track your milestones and showcase your network marketing
                achievements</p>
        </div> -->

    {{-- Member Certificate: only #certificate-capture-root is exported to PNG (no share buttons) --}}
    <div class="certificate-card mb-3" id="certificate-capture-root">
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
                        <div style="font-size: 22px; font-weight: 800; color: #28a745;">{{ $directCount ?? 0 }}</div>
                        <div style="font-size: 11px; color: #999; text-transform: uppercase; font-weight: 700;">Direct
                            Referrals</div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div style="background: #f0f9f4; border: 2px solid #28a745; border-radius: 10px; padding: 15px;">
                        <div style="font-size: 22px; font-weight: 800; color: #28a745;">{{ $teamCount ?? 0 }}</div>
                        <div style="font-size: 11px; color: #999; text-transform: uppercase; font-weight: 700;">Team
                            Size</div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div style="background: #f0f9f4; border: 2px solid #28a745; border-radius: 10px; padding: 15px;">
                        <div style="font-size: 22px; font-weight: 800; color: #28a745;">₹{{ auth()->user()->total_earned ?? '0.00' }}</div>
                        <div style="font-size: 11px; color: #999; text-transform: uppercase; font-weight: 700;">Total
                            Earned</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cert-share-row certificate-actions mb-5">
        <button type="button" class="cert-share-btn cert-share-download" id="downloadCertificateBtn"><i class="fas fa-download"></i>Download</button>
        <button type="button" class="cert-share-btn cert-share-wa" id="shareCertificateWa"><i class="fab fa-whatsapp"></i>WhatsApp</button>
        <button type="button" class="cert-share-btn cert-share-fb" id="shareCertificateFb"><i class="fab fa-facebook-f"></i>Facebook</button>
        <button type="button" class="cert-share-btn cert-share-x" id="shareCertificateX"><i class="fab fa-x-twitter"></i>X</button>
        <button type="button" class="cert-share-btn cert-share-copy" id="copyCertificateLink"><i class="fas fa-link"></i>Copy Link</button>
    </div>

    {{-- Rank Progression --}}
    <!-- <div class="bg-white rounded p-4 shadow-sm mb-4">
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
        </div> -->

    {{-- Income Milestones --}}
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="bg-white rounded p-4 shadow-sm h-100">
                <h5 class="mb-4"><i class="fas fa-flag text-color mr-2"></i>Income Milestones</h5>
                @php
                $totalEarned = auth()->user()->total_earned;

                $milestones = [
                [
                'target' => '₹10,000 earned',
                'icon' => 'fa-rupee-sign',
                'color' => '#28a745',
                'achieved' => $totalEarned >= 10000,
                ],
                [
                'target' => '₹50,000 earned',
                'icon' => 'fa-chart-line',
                'color' => '#17a2b8',
                'achieved' => $totalEarned >= 50000,
                ],
                [
                'target' => '₹1 Lakh earned',
                'icon' => 'fa-fire',
                'color' => '#ff6b35',
                'achieved' => $totalEarned >= 100000,
                ],
                [
                'target' => '₹5 Lakh earned',
                'icon' => 'fa-gem',
                'color' => '#6f42c1',
                'achieved' => $totalEarned >= 500000,
                ],
                [
                'target' => '₹10 Lakh earned',
                'icon' => 'fa-crown',
                'color' => '#ffc107',
                'achieved' => $totalEarned >= 1000000,
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
                'achieved' => $directCount >= 1,
                ],
                [
                'target' => '10 Team Members',
                'icon' => 'fa-users',
                'color' => '#17a2b8',
                'achieved' => $teamCount >= 10,
                ],
                [
                'target' => '50 Team Members',
                'icon' => 'fa-network-wired',
                'color' => '#ffc107',
                'achieved' => $teamCount >= 50,
                ],
                [
                'target' => '100 Team Members',
                'icon' => 'fa-globe',
                'color' => '#6f42c1',
                'achieved' => $teamCount >= 100,
                ],
                [
                'target' => '500 Team Members',
                'icon' => 'fa-crown',
                'color' => '#ff6b35',
                'achieved' => $teamCount >= 500,
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
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script>
        (function() {
            const captureEl = document.getElementById('certificate-capture-root');
            if (!captureEl) return;

            const pageUrl = @json(route('member.credentials'));

            function downloadCanvas(canvas) {
                const link = document.createElement('a');
                link.download = 'kemtexwellness-achievement-certificate.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            }

            function canvasToBlob(canvas) {
                return new Promise(function(resolve) {
                    canvas.toBlob(resolve, 'image/png', 1.0);
                });
            }

            async function captureCertificate() {
                return await html2canvas(captureEl, {
                    backgroundColor: '#ffffff',
                    scale: 2,
                    useCORS: true,
                    logging: false
                });
            }

            async function shareCertificateImage(canvas, appLabel) {
                var blob = await canvasToBlob(canvas);
                if (!blob) {
                    downloadCanvas(canvas);
                    return;
                }
                var file = new File([blob], 'kemtexwellness-certificate.png', { type: 'image/png' });
                var text = 'My KemtexWellness achievement certificate';
                try {
                    if (navigator.share && navigator.canShare && navigator.canShare({ files: [file] })) {
                        await navigator.share({ files: [file], title: 'KemtexWellness', text: text });
                        return;
                    }
                } catch (e) {
                    if (e.name === 'AbortError') return;
                }
                try {
                    if (navigator.clipboard && window.ClipboardItem) {
                        await navigator.clipboard.write([
                            new ClipboardItem({ 'image/png': blob })
                        ]);
                        alert('Certificate image copied. Open ' + appLabel + ' and paste it into the chat or post.');
                        return;
                    }
                } catch (e2) {}
                downloadCanvas(canvas);
                alert('Certificate saved to your device. Attach this image when sharing on ' + appLabel + '.');
            }

            document.getElementById('downloadCertificateBtn')?.addEventListener('click', async function() {
                var canvas = await captureCertificate();
                downloadCanvas(canvas);
            });

            document.getElementById('shareCertificateWa')?.addEventListener('click', async function() {
                var canvas = await captureCertificate();
                await shareCertificateImage(canvas, 'WhatsApp');
            });

            document.getElementById('shareCertificateFb')?.addEventListener('click', async function() {
                var canvas = await captureCertificate();
                await shareCertificateImage(canvas, 'Facebook');
            });

            document.getElementById('shareCertificateX')?.addEventListener('click', async function() {
                var canvas = await captureCertificate();
                await shareCertificateImage(canvas, 'X');
            });

            document.getElementById('copyCertificateLink')?.addEventListener('click', function() {
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(pageUrl).then(function() {
                        alert('Link copied.');
                    }).catch(function() {
                        prompt('Copy this link:', pageUrl);
                    });
                } else {
                    prompt('Copy this link:', pageUrl);
                }
            });
        })();
    </script>
@endpush