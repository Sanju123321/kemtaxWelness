@extends('backend.layouts.app')

@section('title', 'Royalty Report')

@section('content')
    <h1 class="mt-4">Royalty Report</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Finance / Royalty</li>
    </ol>

    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="small text-white-50">15-19 Directs</div>
                    <div class="h4 mb-0 fw-bold">{{ $totals['10'] }} users (10%)</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="small text-white-50">20-29 Directs</div>
                    <div class="h4 mb-0 fw-bold">{{ $totals['15'] }} users (15%)</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="small text-white-50">30-49 Directs</div>
                    <div class="h4 mb-0 fw-bold">{{ $totals['18'] }} users (18%)</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card bg-warning text-dark h-100">
                <div class="card-body">
                    <div class="small text-dark-50">50 Directs</div>
                    <div class="h4 mb-0 fw-bold">{{ $totals['20'] }} users (20%)</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div><i class="fas fa-crown me-1"></i> Royalty Eligible Users</div>
            <a href="{{ route('admin.royalty.export', request()->query()) }}" class="btn btn-sm btn-success">
                <i class="fas fa-file-csv me-1"></i> Export CSV
            </a>
        </div>
        <div class="card-body border-bottom">
            <form method="GET" action="{{ route('admin.royalty.index') }}" class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search name/user/email/phone"
                        value="{{ $filters['search'] ?? '' }}">
                </div>
                <div class="col-md-2">
                    <select name="royalty" class="form-select">
                        <option value="">All royalty slabs</option>
                        <option value="10" @selected(($filters['royalty'] ?? '') === '10')>10% (15-19)</option>
                        <option value="15" @selected(($filters['royalty'] ?? '') === '15')>15% (20-29)</option>
                        <option value="18" @selected(($filters['royalty'] ?? '') === '18')>18% (30-49)</option>
                        <option value="20" @selected(($filters['royalty'] ?? '') === '20')>20% (50)</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" min="15" max="50" name="direct_min" class="form-control"
                        placeholder="Min directs" value="{{ $filters['direct_min'] ?? 15 }}">
                </div>
                <div class="col-md-2">
                    <input type="number" min="15" max="50" name="direct_max" class="form-control"
                        placeholder="Max directs" value="{{ $filters['direct_max'] ?? 50 }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Any status</option>
                        <option value="active" @selected(($filters['status'] ?? '') === 'active')>Active</option>
                        <option value="inactive" @selected(($filters['status'] ?? '') === 'inactive')>Inactive</option>
                    </select>
                </div>
                <div class="col-md-1 d-grid">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Directs</th>
                            <th>Royalty %</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rows as $row)
                            <tr>
                                <td>{{ $row->user_id }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->email }}</td>
                                <td>{{ $row->phone ?: '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $row->status === 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst((string) $row->status) }}
                                    </span>
                                </td>
                                <td><strong>{{ (int) $row->direct_referrals }}</strong></td>
                                <td>
                                    <span class="badge bg-warning text-dark">{{ (int) $row->royalty_percentage }}%</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No royalty-eligible users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $rows->links() }}
            </div>
        </div>
    </div>
@endsection
