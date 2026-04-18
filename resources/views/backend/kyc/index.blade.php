@extends('backend.layouts.app')

@section('title', 'KYC Verification')

@push('styles')
    <style>
        .table td {
            vertical-align: middle;
        }
    </style>
@endpush

@section('content')
    <h1 class="mt-4">KYC Verification</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">KYC</li>
    </ol>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button"
                class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button"
                class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-warning">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Pending</div>
                        <div class="fs-3 fw-bold text-warning">{{ $stats['pending'] }}</div>
                    </div>
                    <i class="fas fa-hourglass-half fa-2x text-warning opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Verified</div>
                        <div class="fs-3 fw-bold text-success">{{ $stats['verified'] }}</div>
                    </div>
                    <i class="fas fa-user-check fa-2x text-success opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-danger">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Rejected</div>
                        <div class="fs-3 fw-bold text-danger">{{ $stats['rejected'] }}</div>
                    </div>
                    <i class="fas fa-user-times fa-2x text-danger opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div><i class="fas fa-id-card me-1"></i> KYC Documents</div>
            <div class="d-flex gap-2 align-items-center">
                <form method="GET" class="d-flex gap-2">
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        @foreach (['pending', 'verified', 'rejected'] as $s)
                            <option value="{{ $s }}" @selected(request('status') == $s)>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    <select name="doc_type" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Types</option>
                        @foreach (['aadhaar', 'pan', 'selfie', 'other'] as $t)
                            <option value="{{ $t }}" @selected(request('doc_type') == $t)>{{ ucfirst($t) }}</option>
                        @endforeach
                    </select>
                </form>
                <a href="{{ route('admin.kyc.create') }}" class="btn btn-sm btn-primary"><i
                        class="fas fa-plus me-1"></i>Add KYC</a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Member</th>
                            <th>Doc Type</th>
                            <th>Doc Number</th>
                            <th>Status</th>
                            <th>Admin Note</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($documents as $doc)
                            <tr>
                                <td>{{ $doc->id }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $doc->user->name ?? '—' }}</div>
                                    <small class="text-muted">{{ $doc->user->email ?? '' }}</small>
                                </td>
                                <td><span class="badge bg-info text-dark text-uppercase">{{ $doc->doc_type }}</span></td>
                                <td>{{ $doc->doc_number ?? '—' }}</td>
                                <td>
                                    @if ($doc->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif ($doc->status === 'verified')
                                        <span class="badge bg-success">Verified</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                                <td><small>{{ $doc->admin_note ?? '—' }}</small></td>
                                <td><small>{{ $doc->created_at->format('d M Y') }}</small></td>
                                <td class="text-nowrap">
                                    {{-- View file --}}
                                    @if ($doc->file_path)
                                        <a href="{{ Storage::url($doc->file_path) }}" target="_blank"
                                            class="btn btn-sm btn-outline-info" title="View Document">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endif

                                    {{-- Verify (only when not already verified) --}}
                                    @if ($doc->status !== 'verified')
                                        <form method="POST" action="{{ route('admin.kyc.status', $doc->id) }}"
                                            class="d-inline">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="verified">
                                            <button type="submit" class="btn btn-sm btn-success" title="Verify">
                                                <i class="fas fa-check me-1"></i>Verify
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Reject (only when not already rejected) --}}
                                    @if ($doc->status !== 'rejected')
                                        <button type="button" class="btn btn-sm btn-danger" title="Reject"
                                            data-bs-toggle="modal" data-bs-target="#rejectKyc{{ $doc->id }}">
                                            <i class="fas fa-times me-1"></i>Reject
                                        </button>
                                    @endif

                                    {{-- Set Pending (only when verified or rejected) --}}
                                    @if ($doc->status !== 'pending')
                                        <form method="POST" action="{{ route('admin.kyc.status', $doc->id) }}"
                                            class="d-inline">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="pending">
                                            <button type="submit" class="btn btn-sm btn-warning text-dark"
                                                title="Set Pending">
                                                <i class="fas fa-clock me-1"></i>Pending
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Delete --}}
                                    <form method="POST" action="{{ route('admin.kyc.destroy', $doc->id) }}"
                                        class="d-inline" onsubmit="return confirm('Delete this KYC record?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            {{-- Reject Modal (always available) --}}
                            <div class="modal fade" id="rejectKyc{{ $doc->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ route('admin.kyc.status', $doc->id) }}">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title">Reject KYC</h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Reason <span
                                                            class="text-danger">*</span></label>
                                                    <textarea name="admin_note" class="form-control" rows="3" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Reject</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- (legacy approve/reject modals placeholder removed) --}}
                            @if (false)
                                {{-- Approve --}}
                                <div class="modal fade" id="approveKyc{{ $doc->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('admin.kyc.approve', $doc->id) }}">
                                                @csrf
                                                <div class="modal-header bg-success text-white">
                                                    <h5 class="modal-title">Verify KYC</h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Verify <strong>{{ strtoupper($doc->doc_type) }}</strong> for
                                                        <strong>{{ $doc->user->name }}</strong>?
                                                    </p>
                                                    <input type="text" name="admin_note" class="form-control"
                                                        placeholder="Note (optional)">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-success">Verify</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">No KYC documents found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($documents->hasPages())
            <div class="card-footer">
                <div class="pagination-wrapper">
                    <span class="text-muted small">Showing {{ $documents->firstItem() }}–{{ $documents->lastItem() }} of
                        {{ $documents->total() }}</span>
                    {{ $documents->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
