@extends('backend.layouts.app')

@section('title', 'Withdrawal Requests')

@section('content')
    <h1 class="mt-4">Withdrawal Requests</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Withdrawals</li>
    </ol>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white">
                <div class="card-body d-flex align-items-center justify-content-between py-3">
                    <div>
                        <div class="small">Pending</div>
                        <div class="fs-4 fw-bold">{{ $stats['pending'] }}</div>
                    </div>
                    <i class="fas fa-clock fa-2x opacity-50"></i>
                </div>
                <div class="card-footer text-white small">&#8377;{{ number_format($stats['total_pending'], 2) }} pending amount</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white">
                <div class="card-body d-flex align-items-center justify-content-between py-3">
                    <div>
                        <div class="small">Approved</div>
                        <div class="fs-4 fw-bold">{{ $stats['approved'] }}</div>
                    </div>
                    <i class="fas fa-check-circle fa-2x opacity-50"></i>
                </div>
                <div class="card-footer text-white small">&#8377;{{ number_format($stats['total_approved'], 2) }} paid out</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white">
                <div class="card-body d-flex align-items-center justify-content-between py-3">
                    <div>
                        <div class="small">Rejected</div>
                        <div class="fs-4 fw-bold">{{ $stats['rejected'] }}</div>
                    </div>
                    <i class="fas fa-times-circle fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white">
                <div class="card-body d-flex align-items-center justify-content-between py-3">
                    <div>
                        <div class="small">Total Paid Out</div>
                        <div class="fs-4 fw-bold">&#8377;{{ number_format($stats['total_approved'], 2) }}</div>
                    </div>
                    <i class="fas fa-money-bill-wave fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div><i class="fas fa-wallet me-1"></i> All Requests</div>
            <div class="d-flex gap-2 align-items-center">
                <form method="GET" class="d-flex gap-2">
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        @foreach (['pending', 'approved', 'rejected'] as $s)
                            <option value="{{ $s }}" @selected(request('status') == $s)>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </form>
                <a href="{{ route('admin.withdrawals.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i>New
                </a>
                <a href="{{ route('admin.withdrawals.export') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-file-csv me-1"></i>CSV
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Member</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Payment Details</th>
                            <th>Status</th>
                            <th>RazorpayX</th>
                            <th>Requested</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($withdrawals as $w)
                            <tr>
                                <td>{{ $w->id }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $w->user->name ?? '-' }}</div>
                                    <small class="text-muted">{{ $w->user->email ?? '' }}</small>
                                </td>
                                <td class="fw-bold text-success">&#8377;{{ number_format($w->amount, 2) }}</td>
                                <td><span class="badge bg-secondary">{{ strtoupper($w->payment_method) }}</span></td>
                                <td>
                                    @if ($w->payment_method === 'upi')
                                        <small>{{ $w->upi_id }}</small>
                                    @else
                                        <small>{{ $w->bank_name }} | {{ $w->account_number }}<br>IFSC: {{ $w->ifsc }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if ($w->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif ($w->status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($w->razorpay_payout_id)
                                        <div class="fw-semibold small">{{ strtoupper($w->payout_status ?? 'created') }}</div>
                                        <div class="text-muted small">{{ $w->razorpay_payout_id }}</div>
                                        @if ($w->utr)
                                            <div class="text-muted small">UTR: {{ $w->utr }}</div>
                                        @endif
                                    @else
                                        <span class="text-muted small">Not initiated</span>
                                    @endif
                                </td>
                                <td><small>{{ $w->created_at->format('d M Y, h:i A') }}</small></td>
                                <td>
                                    @if ($w->status === 'pending' && !$w->razorpay_payout_id)
                                        <button class="btn btn-xs btn-success" data-bs-toggle="modal"
                                            data-bs-target="#approveModal{{ $w->id }}">
                                            <i class="fas fa-check"></i> Pay via RazorpayX
                                        </button>
                                        <button class="btn btn-xs btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#rejectModal{{ $w->id }}">
                                            <i class="fas fa-times"></i> Reject
                                        </button>
                                    @else
                                        <small class="text-muted d-block">{{ $w->admin_remark ?? '-' }}</small>
                                    @endif

                                    @if ($w->razorpay_payout_id && in_array($w->payout_status, ['queued', 'processing', 'initiated']))
                                        <form method="POST" action="{{ route('admin.withdrawals.sync', $w->id) }}" class="mt-1">
                                            @csrf
                                            <button type="submit" class="btn btn-xs btn-primary">
                                                <i class="fas fa-sync"></i> Sync
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>

                            @if ($w->status === 'pending' && !$w->razorpay_payout_id)
                                <div class="modal fade" id="approveModal{{ $w->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('admin.withdrawals.approve', $w->id) }}">
                                                @csrf
                                                <div class="modal-header bg-success text-white">
                                                    <h5 class="modal-title">Start Payout #{{ $w->id }}</h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Initiate RazorpayX test payout of <strong>&#8377;{{ number_format($w->amount, 2) }}</strong> for <strong>{{ $w->user->name }}</strong>?</p>
                                                    <p class="text-muted small mb-3">
                                                        This will create a payout to the saved bank account and deduct the amount from the member's main wallet when the payout is initiated.
                                                    </p>
                                                    <div class="mb-3">
                                                        <label class="form-label">Remark (optional)</label>
                                                        <input type="text" name="admin_remark" class="form-control"
                                                            placeholder="e.g. Test payout via RazorpayX">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-success">Start Payout</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="rejectModal{{ $w->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('admin.withdrawals.reject', $w->id) }}">
                                                @csrf
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title">Reject Withdrawal #{{ $w->id }}</h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Reject withdrawal of <strong>&#8377;{{ number_format($w->amount, 2) }}</strong> for <strong>{{ $w->user->name }}</strong>?</p>
                                                    <div class="mb-3">
                                                        <label class="form-label">Reason <span class="text-danger">*</span></label>
                                                        <textarea name="admin_remark" class="form-control" rows="3" required placeholder="Provide a reason..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">Confirm Reject</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">No withdrawal requests found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($withdrawals->hasPages())
            <div class="card-footer">
                <div class="pagination-wrapper">
                    <span class="text-muted small">Showing {{ $withdrawals->firstItem() }}-{{ $withdrawals->lastItem() }} of {{ $withdrawals->total() }}</span>
                    {{ $withdrawals->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
