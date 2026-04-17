@extends('backend.layouts.app')

@section('title', 'Payments')

@section('content')
    <h1 class="mt-4">Payments</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Payments</li>
    </ol>

    <!-- Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-4 col-sm-6">
            <div class="card bg-success text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50">Total Revenue</div>
                        <div class="h4 mb-0 fw-bold">₹{{ number_format($totalRevenue, 2) }}</div>
                    </div>
                    <i class="fas fa-rupee-sign fa-2x text-white-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card bg-primary text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50">Total Transactions</div>
                        <div class="h4 mb-0 fw-bold">{{ $payments->total() }}</div>
                    </div>
                    <i class="fas fa-receipt fa-2x text-white-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card bg-info text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50">Today's Payments</div>
                        <div class="h4 mb-0 fw-bold">
                            {{ \App\Models\Payment::whereDate('created_at', today())->count() }}
                        </div>
                    </div>
                    <i class="fas fa-calendar-day fa-2x text-white-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div><i class="fas fa-receipt me-1"></i> All Payments</div>
            <a href="{{ route('admin.payments.export') }}" class="btn btn-sm btn-success">
                <i class="fas fa-file-csv me-1"></i> Export CSV
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Member</th>
                            <th>Payment ID</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td>{{ $payment->id }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $payment->user->name ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $payment->email ?? ($payment->user->email ?? '') }}</small>
                                </td>
                                <td><code class="small">{{ $payment->payment_id }}</code></td>
                                <td><strong>₹{{ number_format($payment->amount, 2) }}</strong></td>
                                <td>{{ ucfirst($payment->method ?? 'N/A') }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $payment->status === 'captured' ? 'success' : ($payment->status === 'failed' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td>{{ $payment->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No payments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination-wrapper">
                <div>Showing {{ $payments->firstItem() }}–{{ $payments->lastItem() }} of {{ $payments->total() }} records
                </div>
                {{ $payments->links() }}
            </div>
        </div>
    </div>
@endsection
