@extends('frontend.layouts.member')

@section('title', 'KYC Documents')

@push('styles')
    <style>
        /* ── Layout ── */
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

        /* ── KYC Page Styles ── */
        .kyc-status-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px 14px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .07);
            border-top: 4px solid #adb5bd;
            text-align: center;
            height: 100%;
            transition: box-shadow .15s;
        }

        .kyc-status-card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, .12);
        }

        .kyc-status-card.verified {
            border-top-color: #28a745;
        }

        .kyc-status-card.pending {
            border-top-color: #ffc107;
        }

        .kyc-status-card.rejected {
            border-top-color: #dc3545;
        }

        .kyc-icon {
            font-size: 26px;
            margin-bottom: 8px;
        }

        .kyc-doc-label {
            font-size: 13px;
            font-weight: 700;
            color: #333;
            margin-bottom: 6px;
        }

        .kyc-status-badge {
            display: inline-block;
            padding: 3px 11px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .03em;
        }

        .status-verified {
            background: #d4edda;
            color: #155724;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-rejected {
            background: #f8d7da;
            color: #721c24;
        }

        .status-not-submitted {
            background: #f0f0f0;
            color: #888;
        }

        .kyc-section-card {
            background: #fff;
            border-radius: 10px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .07);
            margin-bottom: 24px;
        }

        .kyc-section-title {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #28a745;
            border-bottom: 2px solid #eaf7ef;
            padding-bottom: 10px;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .kyc-section-title.grey {
            color: #555;
            border-bottom-color: #f0f0f0;
        }

        .upload-hint {
            font-size: 11px;
            color: #999;
            margin-top: 3px;
        }

        .reject-note {
            font-size: 11px;
            color: #721c24;
            background: #f8d7da;
            padding: 5px 9px;
            border-radius: 4px;
            margin-top: 6px;
            line-height: 1.4;
        }

        .withdraw-btn {
            background: none;
            border: none;
            color: #dc3545;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            padding: 0;
            margin-top: 6px;
        }

        .withdraw-btn:hover {
            text-decoration: underline;
        }
    </style>
@endpush

@section('content')
    @php
        $isInactive = auth()->check() && auth()->user()->status == 'inactive';

        // Latest doc per type (keyed by doc_type)
        $docMap = [];
        foreach ($docs as $doc) {
            if (!isset($docMap[$doc->doc_type])) {
                $docMap[$doc->doc_type] = $doc;
            }
        }

        $docTypes = [
            'aadhaar' => 'Aadhaar',
            'pan' => 'PAN Card',
            'selfie' => 'Selfie',
            'other' => 'Other',
        ];

        $docIcons = [
            'aadhaar' => 'fa-id-card',
            'pan' => 'fa-credit-card',
            'selfie' => 'fa-camera',
            'other' => 'fa-file-alt',
        ];

        // Types eligible for (re-)upload: not submitted OR rejected
        $uploadable = [];
        foreach ($docTypes as $key => $label) {
            $existing = $docMap[$key] ?? null;
            if (!$existing || $existing->status === 'rejected') {
                $uploadable[$key] = $label;
            }
        }
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

        <div class="nav-label">Account</div>
        <a href="{{ route('member.kyc.index') }}" class="{{ request()->routeIs('member.kyc*') ? 'active' : '' }}">
            <i class="fas fa-id-card nav-icon"></i> KYC Documents
        </a>
        <a href="{{ route('member.profile') }}"
            class="{{ request()->routeIs('member.profile') ? 'active' : '' }}">
            <i class="fas fa-user-edit nav-icon"></i> My Profile
        </a>

        <div class="nav-label">More</div>
        <a href="{{ route('pricing') }}" class="{{ request()->routeIs('pricing') ? 'active' : '' }}">
            <i class="fas fa-tags nav-icon"></i> Pricing
        </a>
        <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">
            <i class="fas fa-headset nav-icon"></i> Support
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

    {{-- Page Header --}}
    <div
        style="background:linear-gradient(135deg,#28a745 0%,#1e7e34 100%);padding:20px 24px;color:white;margin-bottom:24px;border-radius:10px;">
        <h5 class="mb-1 font-weight-bold"><i class="fas fa-id-card mr-2"></i>KYC Verification</h5>
        <small style="opacity:.8;">Submit your identity documents for account verification. All documents are stored
            securely and kept private.</small>
    </div>

    {{-- Session Alerts --}}
    @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show">
            <i class="fas fa-exclamation-triangle mr-2"></i>{{ session('warning') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            @foreach ($errors->all() as $error)
                <div><i class="fas fa-exclamation-circle mr-1"></i>{{ $error }}</div>
            @endforeach
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    {{-- Status Cards ── one per document type ── --}}
    <div class="row mb-4">
        @foreach ($docTypes as $key => $label)
            @php
                $doc = $docMap[$key] ?? null;
                $status = $doc ? $doc->status : 'not-submitted';
                $iconColor = match ($status) {
                    'verified' => '#28a745',
                    'pending' => '#e6a817',
                    'rejected' => '#dc3545',
                    default => '#adb5bd',
                };
            @endphp
            <div class="col-md-3 col-6 mb-3">
                <div class="kyc-status-card {{ $status }}">
                    <div class="kyc-icon" style="color:{{ $iconColor }};">
                        <i class="fas {{ $docIcons[$key] }}"></i>
                    </div>
                    <div class="kyc-doc-label">{{ $label }}</div>

                    @if ($status === 'verified')
                        <span class="kyc-status-badge status-verified">
                            <i class="fas fa-check-circle mr-1"></i>Verified
                        </span>
                        @if ($doc->verified_at)
                            <div style="font-size:11px;color:#888;margin-top:4px;">
                                {{ $doc->verified_at->format('d M Y') }}
                            </div>
                        @endif
                    @elseif ($status === 'pending')
                        <span class="kyc-status-badge status-pending">
                            <i class="fas fa-clock mr-1"></i>Under Review
                        </span>
                        <div style="font-size:11px;color:#888;margin-top:4px;">
                            {{ $doc->created_at->diffForHumans() }}
                        </div>
                        <form action="{{ route('member.kyc.destroy', $doc->id) }}" method="POST"
                            onsubmit="return confirm('Withdraw this KYC submission?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="withdraw-btn">
                                <i class="fas fa-trash-alt mr-1"></i>Withdraw
                            </button>
                        </form>
                    @elseif ($status === 'rejected')
                        <span class="kyc-status-badge status-rejected">
                            <i class="fas fa-times-circle mr-1"></i>Rejected
                        </span>
                        @if ($doc->admin_note)
                            <div class="reject-note">{{ $doc->admin_note }}</div>
                        @endif
                        <div style="font-size:11px;color:#888;margin-top:5px;">Re-upload below</div>
                    @else
                        <span class="kyc-status-badge status-not-submitted">
                            <i class="fas fa-minus-circle mr-1"></i>Not Submitted
                        </span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    {{-- Upload Form --}}
    @if (count($uploadable) > 0)
        <div class="kyc-section-card">
            <div class="kyc-section-title">
                <i class="fas fa-cloud-upload-alt"></i> Upload Document
            </div>

            <form action="{{ route('member.kyc.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label style="font-size:13px;font-weight:600;display:block;margin-bottom:5px;">
                            Document Type <span class="text-danger">*</span>
                        </label>
                        <select name="doc_type" class="form-control" required>
                            <option value="">— Select Type —</option>
                            @foreach ($uploadable as $key => $label)
                                <option value="{{ $key }}" @selected(old('doc_type') == $key)>
                                    {{ $label }}
                                    @if (isset($docMap[$key]) && $docMap[$key]->status === 'rejected')
                                        (Re-upload)
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <div class="upload-hint">Only types that need submission are shown</div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label style="font-size:13px;font-weight:600;display:block;margin-bottom:5px;">
                            Document Number
                        </label>
                        <input type="text" name="doc_number" class="form-control"
                            placeholder="e.g. 1234 5678 9012" value="{{ old('doc_number') }}">
                        <div class="upload-hint">Aadhaar: 12 digits &nbsp;|&nbsp; PAN: 10 characters</div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label style="font-size:13px;font-weight:600;display:block;margin-bottom:5px;">
                            Upload File <span class="text-danger">*</span>
                        </label>
                        <input type="file" name="doc_file" class="form-control" accept=".jpg,.jpeg,.png,.pdf"
                            required>
                        <div class="upload-hint">JPG, PNG or PDF &nbsp;|&nbsp; Max 4 MB</div>
                    </div>
                </div>

                <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;">
                    <button type="submit" class="btn btn-success px-4"
                        style="font-weight:600;border-radius:6px;font-size:14px;">
                        <i class="fas fa-cloud-upload-alt mr-2"></i>Submit Document
                    </button>
                    <span style="font-size:12px;color:#888;">
                        <i class="fas fa-lock mr-1"></i>Your documents are encrypted and stored securely
                    </span>
                </div>
            </form>
        </div>
    @else
        <div class="kyc-section-card" style="text-align:center;padding:36px 24px;">
            <i class="fas fa-check-circle"
                style="font-size:42px;color:#28a745;display:block;margin-bottom:12px;"></i>
            <h6 style="color:#28a745;font-weight:700;font-size:15px;margin-bottom:6px;">All Documents Submitted
            </h6>
            <p style="font-size:13px;color:#666;margin:0;">
                You have submitted all required KYC documents. Our team will review and verify them within 24–48
                hours.
            </p>
        </div>
    @endif

    {{-- Submission History --}}
    @if ($docs->count() > 0)
        <div class="kyc-section-card">
            <div class="kyc-section-title grey">
                <i class="fas fa-history"></i> Submission History
            </div>
            <div class="table-responsive">
                <table class="table table-sm mb-0" style="font-size:13px;">
                    <thead>
                        <tr
                            style="font-size:11px;text-transform:uppercase;letter-spacing:.05em;color:#999;font-weight:700;">
                            <th class="border-top-0">#</th>
                            <th class="border-top-0">Document</th>
                            <th class="border-top-0">Number</th>
                            <th class="border-top-0">File</th>
                            <th class="border-top-0">Status</th>
                            <th class="border-top-0">Admin Note</th>
                            <th class="border-top-0">Submitted</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($docs as $i => $doc)
                            <tr>
                                <td class="text-muted">{{ $i + 1 }}</td>
                                <td>
                                    <span
                                        style="background:#e9f7ef;color:#28a745;padding:2px 8px;border-radius:4px;font-size:11px;font-weight:700;text-transform:uppercase;">
                                        {{ $doc->doc_type }}
                                    </span>
                                </td>
                                <td class="text-muted">{{ $doc->doc_number ?? '—' }}</td>
                                <td>
                                    @if ($doc->file_path)
                                        <a href="{{ Storage::url($doc->file_path) }}" target="_blank"
                                            style="font-size:12px;color:#28a745;">
                                            <i class="fas fa-eye mr-1"></i>View
                                        </a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($doc->status === 'verified')
                                        <span
                                            style="background:#d4edda;color:#155724;padding:2px 10px;border-radius:12px;font-size:11px;font-weight:700;">Verified</span>
                                    @elseif ($doc->status === 'pending')
                                        <span
                                            style="background:#fff3cd;color:#856404;padding:2px 10px;border-radius:12px;font-size:11px;font-weight:700;">Pending</span>
                                    @else
                                        <span
                                            style="background:#f8d7da;color:#721c24;padding:2px 10px;border-radius:12px;font-size:11px;font-weight:700;">Rejected</span>
                                    @endif
                                </td>
                                <td style="max-width:180px;font-size:12px;color:#666;">
                                    {{ $doc->admin_note ?? '—' }}
                                </td>
                                <td class="text-muted" style="white-space:nowrap;">
                                    {{ $doc->created_at->format('d M Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>
</div>
@endsection
