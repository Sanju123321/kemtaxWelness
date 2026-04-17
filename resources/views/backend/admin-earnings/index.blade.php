@extends('backend.layouts.app')

@section('title', 'Admin Earnings')

@section('content')
    <h1 class="mt-4">Admin Earnings</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Admin Earnings</li>
    </ol>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4 col-sm-6">
            <div class="card text-white h-100" style="background:linear-gradient(135deg,#4f46e5,#7c3aed);">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50">Grand Total Earned</div>
                        <div class="h4 mb-0 fw-bold">₹{{ number_format($grandTotal, 2) }}</div>
                    </div>
                    <i class="fas fa-crown fa-2x text-white-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card bg-danger text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50">Lost Income Captured</div>
                        <div class="h4 mb-0 fw-bold">₹{{ number_format($totalLostCapture, 2) }}</div>
                        <div class="small text-white-50">From cap-exceeded commissions</div>
                    </div>
                    <i class="fas fa-ban fa-2x text-white-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card bg-success text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50">Maintenance Fees (10%)</div>
                        <div class="h4 mb-0 fw-bold">₹{{ number_format($totalMaintenanceFee, 2) }}</div>
                        <div class="small text-white-50">10% of every credited commission</div>
                    </div>
                    <i class="fas fa-percentage fa-2x text-white-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div><i class="fas fa-crown me-1"></i> All Admin Earning Records</div>
            <a href="{{ route('admin.admin.earnings.export') }}" class="btn btn-sm btn-success">
                <i class="fas fa-file-csv me-1"></i> Export CSV
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>From Member</th>
                            <th>Beneficiary User</th>
                            <th>Remark</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($earnings as $earning)
                            <tr>
                                <td>{{ $earning->id }}</td>
                                <td>
                                    @if ($earning->type === 'maintenance_fee')
                                        <span class="badge bg-success">
                                            <i class="fas fa-percentage me-1"></i>Maintenance Fee
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="fas fa-ban me-1"></i>Lost Capture
                                        </span>
                                    @endif
                                </td>
                                <td class="fw-bold text-success">₹{{ number_format($earning->amount, 2) }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $earning->fromUser->name ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $earning->fromUser->email ?? '' }}</small>
                                </td>
                                <td>
                                    @if ($earning->beneficiaryUser)
                                        <a href="{{ route('admin.users.income', $earning->beneficiary_user_id) }}"
                                            class="text-decoration-none">
                                            {{ $earning->beneficiaryUser->name }}
                                        </a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td class="text-muted small">{{ $earning->remark ?? '—' }}</td>
                                <td class="text-nowrap">{{ $earning->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    No admin earnings yet. They will appear here as commissions are distributed.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($earnings->hasPages())
                <div class="pagination-wrapper">
                    <div>Showing {{ $earnings->firstItem() }}–{{ $earnings->lastItem() }} of {{ $earnings->total() }}
                        records</div>
                    {{ $earnings->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
