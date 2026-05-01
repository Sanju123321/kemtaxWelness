@extends('backend.layouts.app')

@section('title', 'Plans')

@section('content')
    <h1 class="mt-4">MLM Plans</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Plans</li>
    </ol>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-4 col-sm-6">
            <div class="card bg-primary text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50">Total Plans</div>
                        <div class="h4 mb-0 fw-bold">{{ $plans->count() }}</div>
                    </div>
                    <i class="fas fa-layer-group fa-2x text-white-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card bg-success text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50">Active Plans</div>
                        <div class="h4 mb-0 fw-bold">{{ $plans->where('is_active', true)->count() }}</div>
                    </div>
                    <i class="fas fa-check-circle fa-2x text-white-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card bg-info text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50">Total Members on Plans</div>
                        <div class="h4 mb-0 fw-bold">{{ $plans->sum('users_count') }}</div>
                    </div>
                    <i class="fas fa-users fa-2x text-white-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div><i class="fas fa-layer-group me-1"></i> All Plans</div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.plans.export') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-file-csv me-1"></i> Export CSV
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatablesSimple" class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Price</th>
                            <th>Base Value</th>
                            <th>Daily Cap</th>
                            <th>Total Cap</th>
                            <th>Members</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($plans as $plan)
                            <tr>
                                <td>{{ $plan->id }}</td>
                                <td><strong>{{ $plan->name }}</strong></td>
                                <td><span class="badge bg-secondary">{{ $plan->code }}</span></td>
                                <td>₹{{ number_format($plan->price, 2) }}</td>
                                <td>₹{{ number_format($plan->base_value, 2) }}</td>
                                <td>₹{{ number_format($plan->daily_cap, 2) }}</td>
                                <td>₹{{ number_format($plan->total_cap, 2) }}</td>
                                <td><span class="badge bg-info">{{ $plan->users_count }}</span></td>
                                <td>
                                    <span class="badge bg-{{ $plan->is_active ? 'success' : 'secondary' }}">
                                        {{ $plan->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">No plans found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script>
        if (document.getElementById('datatablesSimple')) {
            new simpleDatatables.DataTable(document.getElementById('datatablesSimple'));
        }
    </script>
@endpush
