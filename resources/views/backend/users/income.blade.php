@extends('backend.layouts.app')

@section('title', 'Income — ' . $user->name)

@section('content')
    <h1 class="mt-4">Income: {{ $user->name }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
        <li class="breadcrumb-item active">Income</li>
    </ol>

    <!-- User Info Card -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body d-flex align-items-center gap-3">
            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                style="width:56px;height:56px;font-size:1.4rem;flex-shrink:0;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <div class="fw-bold fs-5">{{ $user->name }}</div>
                <div class="text-muted small">{{ $user->email }}
                    @if ($user->phone)
                        &nbsp;·&nbsp;{{ $user->phone }}
                    @endif
                </div>
                <div class="mt-1">
                    @if ($user->status === 'active')
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Blocked</span>
                    @endif
                    @if ($user->has_plan)
                        <span class="badge bg-primary ms-1">Has Plan</span>
                    @endif
                </div>
            </div>
            <div class="ms-auto">
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Users
                </a>
            </div>
        </div>
    </div>

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
                        <div class="small text-white-50">Lost (Cap Exceeded)</div>
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
        <div class="card-header">
            <i class="fas fa-coins me-1"></i> Commission History
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
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
                                <td>{{ $income->fromUser->name ?? 'N/A' }}</td>
                                <td><span class="badge bg-secondary">L{{ $income->level }}</span></td>
                                <td>{{ ucfirst($income->type ?? '—') }}</td>
                                <td class="fw-semibold">₹{{ number_format($income->amount, 2) }}</td>
                                <td>
                                    @if ($income->status === 'credited')
                                        <span class="badge bg-success">Credited</span>
                                    @elseif($income->status === 'lost')
                                        <span class="badge bg-danger">Lost</span>
                                    @else
                                        <span class="badge bg-warning text-dark">{{ ucfirst($income->status) }}</span>
                                    @endif
                                </td>
                                <td class="text-muted small">{{ $income->remark ?? '—' }}</td>
                                <td class="text-nowrap">{{ $income->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">No income records found for this
                                    user.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($incomes->hasPages())
                <div class="pagination-wrapper">
                    <div>Showing {{ $incomes->firstItem() }}–{{ $incomes->lastItem() }} of {{ $incomes->total() }}
                        records</div>
                    {{ $incomes->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
