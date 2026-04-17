@extends('backend.layouts.app')

@section('title', 'Plan History — ' . $user->name)

@section('content')
    <h1 class="mt-4">Plan History</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
        <li class="breadcrumb-item active">Plan History: {{ $user->name }}</li>
    </ol>

    {{-- User Info --}}
    <div class="card mb-4">
        <div class="card-body d-flex align-items-center gap-3">
            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center fw-bold"
                style="width:56px;height:56px;font-size:1.4rem;flex-shrink:0">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <div>
                <div class="fw-bold fs-5">{{ $user->name }}</div>
                <div class="text-muted small">{{ $user->email }}</div>
            </div>
            <div class="ms-auto d-flex gap-2">
                <a href="{{ route('admin.users.income', $user->id) }}" class="btn btn-sm btn-outline-info">
                    <i class="fas fa-coins me-1"></i> Income
                </a>
                <a href="{{ route('admin.users.tree', $user->id) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-sitemap me-1"></i> Tree
                </a>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button"
                class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="row g-4">
        {{-- Plan History Table --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div><i class="fas fa-history me-1"></i> Plan Purchase History ({{ $planHistory->total() }})</div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Plan</th>
                                    <th>Amount Paid</th>
                                    <th>Status</th>
                                    <th>Activated At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($planHistory as $up)
                                    <tr>
                                        <td>{{ $up->id }}</td>
                                        <td>
                                            <div class="fw-semibold">{{ $up->plan->name ?? '—' }}</div>
                                            <small class="text-muted">₹{{ number_format($up->plan->price ?? 0, 2) }}
                                                base</small>
                                        </td>
                                        <td class="fw-bold text-success">₹{{ number_format($up->amount_paid, 2) }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $up->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ ucfirst($up->status) }}
                                            </span>
                                        </td>
                                        <td><small>{{ $up->activated_at ? \Carbon\Carbon::parse($up->activated_at)->format('d M Y, h:i A') : '—' }}</small>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">No plan purchases found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($planHistory->hasPages())
                    <div class="card-footer">
                        <div class="pagination-wrapper">
                            <span class="text-muted small">{{ $planHistory->firstItem() }}–{{ $planHistory->lastItem() }}
                                of {{ $planHistory->total() }}</span>
                            {{ $planHistory->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Assign Plan --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary text-white"><i class="fas fa-layer-group me-1"></i> Assign Plan Manually
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.users.assign-plan', $user->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Select Plan <span class="text-danger">*</span></label>
                            <select name="plan_id" class="form-select" required>
                                <option value="">— Choose Plan —</option>
                                @foreach ($plans as $plan)
                                    <option value="{{ $plan->id }}">{{ $plan->name }}
                                        (₹{{ number_format($plan->price, 2) }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Amount Paid (₹)</label>
                            <input type="number" name="amount_paid" class="form-control" step="0.01" min="0"
                                placeholder="Optional override">
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="distribute_income" value="1"
                                id="distributeIncome" checked>
                            <label class="form-check-label" for="distributeIncome">Distribute MLM commissions</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100"
                            onclick="return confirm('Assign plan to {{ $user->name }}?')">
                            <i class="fas fa-check me-1"></i> Assign Plan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
