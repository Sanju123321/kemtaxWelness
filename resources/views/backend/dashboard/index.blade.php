@extends('backend.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="row g-3 mb-2">
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card bg-primary text-white mb-2">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50 mb-1">Total Users</div>
                        <div class="h3 mb-0 fw-bold">
                            {{ \App\Models\User::count() }}
                        </div>
                    </div>
                    <i class="fas fa-users fa-2x text-white-50"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('admin.users.index') }}">View Users</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card bg-warning text-white mb-2">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50 mb-1">Total Products</div>
                        <div class="h3 mb-0 fw-bold">{{ \App\Models\Product::count() }}</div>
                    </div>
                    <i class="fas fa-box fa-2x text-white-50"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('admin.products.index') }}">View Products</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card bg-success text-white mb-2">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50 mb-1">Active Members</div>
                        <div class="h3 mb-0 fw-bold">{{ \App\Models\User::where('status', 'active')->count() }}
                        </div>
                    </div>
                    <i class="fas fa-user-check fa-2x text-white-50"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('admin.users.index') }}">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card bg-danger text-white mb-2">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50 mb-1">Total Revenue</div>
                        <div class="h3 mb-0 fw-bold">
                            ₹{{ number_format(\App\Models\Payment::where('status', 'captured')->sum('amount'), 0) }}</div>
                    </div>
                    <i class="fas fa-rupee-sign fa-2x text-white-50"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('admin.payments.index') }}">View Payments</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Earnings Quick Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-4 col-sm-6">
            <div class="card text-white h-100" style="background:linear-gradient(135deg,#4f46e5,#7c3aed);">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50">Admin Total Earned</div>
                        <div class="h4 mb-0 fw-bold">₹{{ number_format(\App\Models\AdminEarning::sum('amount'), 0) }}</div>
                    </div>
                    <i class="fas fa-crown fa-2x text-white-50"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('admin.admin.earnings.index') }}">View
                        Earnings</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card bg-danger text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50">Lost Income Captured</div>
                        <div class="h4 mb-0 fw-bold">
                            ₹{{ number_format(\App\Models\AdminEarning::where('type', 'lost_capture')->sum('amount'), 0) }}
                        </div>
                    </div>
                    <i class="fas fa-ban fa-2x text-white-50"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('admin.admin.earnings.index') }}">View
                        Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card bg-success text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50">Maintenance Fees (10%)</div>
                        <div class="h4 mb-0 fw-bold">
                            ₹{{ number_format(\App\Models\AdminEarning::where('type', 'maintenance_fee')->sum('amount'), 0) }}
                        </div>
                    </div>
                    <i class="fas fa-percentage fa-2x text-white-50"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('admin.admin.earnings.index') }}">View
                        Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-3">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <span><i class="fas fa-chart-line me-1"></i> Member Growth ({{ date('Y') }})</span>
                    <small class="text-muted">New signups per month</small>
                </div>
                <div class="card-body">
                    <div style="position:relative;height:280px">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <span><i class="fas fa-chart-bar me-1"></i> Monthly Revenue ({{ date('Y') }})</span>
                    <small class="text-muted">Captured payments ₹</small>
                </div>
                <div class="card-body">
                    <div style="position:relative;height:280px">
                        <canvas id="myBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Users Table -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div><i class="fas fa-table me-1"></i> Recent Users</div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.users.export') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-file-csv me-1"></i> Export CSV
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatablesSimple" class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (\App\Models\User::where('email', '!=', 'admin@kemtex.com')->latest()->take(10)->get() as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->status === 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Blocked</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                                <td class="text-nowrap">
                                    <form method="POST" action="{{ route('admin.users.toggle.status', $user->id) }}"
                                        class="d-inline">
                                        @csrf
                                        @if ($user->status === 'active')
                                            <button type="submit" class="btn btn-sm btn-secondary" title="Block">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-sm btn-success" title="Unblock">
                                                <i class="fas fa-check-circle"></i>
                                            </button>
                                        @endif
                                    </form>
                                    <a href="{{ route('admin.users.income', $user->id) }}"
                                        class="btn btn-sm btn-info text-white" title="View Income">
                                        <i class="fas fa-coins"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script>
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // ── Member Growth Line Chart ──
        new Chart(document.getElementById('myAreaChart'), {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'New Members',
                    data: @json($memberGrowthData),
                    fill: true,
                    backgroundColor: 'rgba(79,70,229,.08)',
                    borderColor: 'rgba(79,70,229,1)',
                    pointBackgroundColor: 'rgba(79,70,229,1)',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.4,
                    borderWidth: 2.5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 16
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        },
                        grid: {
                            color: 'rgba(0,0,0,.05)'
                        }
                    }
                }
            }
        });

        // ── Monthly Revenue Bar Chart ──
        new Chart(document.getElementById('myBarChart'), {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Revenue (₹)',
                    data: @json($monthlyRevenueData),
                    backgroundColor: months.map((_, i) =>
                        `hsla(${210 + i * 8}, 80%, 55%, 0.75)`
                    ),
                    borderRadius: 6,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 16
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx => ' ₹' + ctx.parsed.y.toLocaleString('en-IN')
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: v => '₹' + (v >= 1000 ? (v / 1000).toFixed(0) + 'k' : v)
                        },
                        grid: {
                            color: 'rgba(0,0,0,.05)'
                        }
                    }
                }
            }
        });

        // ── Datatables ──
        const dt = document.getElementById('datatablesSimple');
        if (dt) new simpleDatatables.DataTable(dt);
    </script>
@endpush
