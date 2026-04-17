@extends('backend.layouts.app')

@section('title', 'Commissions & Incomes')

@section('content')
    <h1 class="mt-4">Commissions & Incomes</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Commissions</li>
    </ol>

    <!-- Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-4 col-sm-6">
            <div class="card bg-success text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50">Total Credited</div>
                        <div class="h4 mb-0 fw-bold">₹{{ number_format($totalCredited, 2) }}</div>
                    </div>
                    <i class="fas fa-check-circle fa-2x text-white-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card bg-danger text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50">Total Lost (Cap Exceeded)</div>
                        <div class="h4 mb-0 fw-bold">₹{{ number_format($totalLost, 2) }}</div>
                    </div>
                    <i class="fas fa-times-circle fa-2x text-white-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card bg-primary text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50">Total Records</div>
                        <div class="h4 mb-0 fw-bold">{{ $incomes->total() }}</div>
                    </div>
                    <i class="fas fa-list fa-2x text-white-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div><i class="fas fa-coins me-1"></i> All Commission Records</div>
            <a href="{{ route('admin.incomes.export') }}" class="btn btn-sm btn-success">
                <i class="fas fa-file-csv me-1"></i> Export CSV
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Earner</th>
                            <th>From Member</th>
                            <th>Level</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Remark</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($incomes as $income)
                            <tr>
                                <td>{{ $income->id }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $income->user->name ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $income->user->email ?? '' }}</small>
                                </td>
                                <td>{{ $income->fromUser->name ?? 'N/A' }}</td>
                                <td><span class="badge bg-secondary">L{{ $income->level }}</span></td>
                                <td>
                                    <span class="badge bg-{{ $income->type === 'direct' ? 'primary' : 'info' }}">
                                        {{ $income->type === 'direct' ? 'Direct' : 'Level ' . $income->level }}
                                    </span>
                                </td>
                                <td><strong>₹{{ number_format($income->amount, 2) }}</strong></td>
                                <td>
                                    <span class="badge bg-{{ $income->status === 'credited' ? 'success' : 'danger' }}">
                                        {{ ucfirst($income->status) }}
                                    </span>
                                </td>
                                <td><small class="text-muted">{{ $income->remark ?? '—' }}</small></td>
                                <td>{{ $income->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">No commission records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination-wrapper">
                <div>Showing {{ $incomes->firstItem() }}–{{ $incomes->lastItem() }} of {{ $incomes->total() }} records
                </div>
                {{ $incomes->links() }}
            </div>
        </div>
    </div>
@endsection
