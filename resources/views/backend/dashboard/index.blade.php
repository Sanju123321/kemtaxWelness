@extends('backend.layouts.master')

@section('title', 'Dashboard')
@section('meta_description', 'KemtexWellness Admin Dashboard')

@section('page_title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

    {{-- Stats Cards Row --}}
    <div class="row g-4 mb-4">

        {{-- Total Users --}}
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50 fw-semibold text-uppercase">Total Users</div>
                        <div class="fs-3 fw-bold">1,234</div>
                        <div class="small text-white-75 mt-1">
                            <i class="bi bi-arrow-up-circle me-1"></i>+12% this month
                        </div>
                    </div>
                    <i class="bi bi-people fs-1 opacity-50"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link text-decoration-none" href="{{ route('admin.users.index') }}">
                        View Details
                    </a>
                    <i class="bi bi-chevron-right text-white"></i>
                </div>
            </div>
        </div>

        {{-- Total Products --}}
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50 fw-semibold text-uppercase">Total Products</div>
                        <div class="fs-3 fw-bold">567</div>
                        <div class="small text-white-75 mt-1">
                            <i class="bi bi-arrow-up-circle me-1"></i>+8% this month
                        </div>
                    </div>
                    <i class="bi bi-box-seam fs-1 opacity-50"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link text-decoration-none"
                        href="{{ route('admin.products.index') }}">
                        View Details
                    </a>
                    <i class="bi bi-chevron-right text-white"></i>
                </div>
            </div>
        </div>

        {{-- Total Orders --}}
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50 fw-semibold text-uppercase">Total Orders</div>
                        <div class="fs-3 fw-bold">892</div>
                        <div class="small text-white-75 mt-1">
                            <i class="bi bi-arrow-down-circle me-1"></i>-3% this month
                        </div>
                    </div>
                    <i class="bi bi-cart3 fs-1 opacity-50"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link text-decoration-none" href="#">
                        View Details
                    </a>
                    <i class="bi bi-chevron-right text-white"></i>
                </div>
            </div>
        </div>

        {{-- Revenue --}}
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50 fw-semibold text-uppercase">Total Revenue</div>
                        <div class="fs-3 fw-bold">$48,295</div>
                        <div class="small text-white-75 mt-1">
                            <i class="bi bi-arrow-up-circle me-1"></i>+21% this month
                        </div>
                    </div>
                    <i class="bi bi-currency-dollar fs-1 opacity-50"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link text-decoration-none" href="#">
                        View Details
                    </a>
                    <i class="bi bi-chevron-right text-white"></i>
                </div>
            </div>
        </div>

    </div>{{-- /Stats Row --}}

    {{-- Charts & Activity Row --}}
    <div class="row g-4 mb-4">

        {{-- Revenue Chart --}}
        <div class="col-xl-8">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <span class="fw-semibold"><i class="bi bi-graph-up me-2 text-primary"></i>Revenue Overview</span>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                            data-bs-toggle="dropdown">
                            This Year
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Week</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>

        {{-- Quick Stats --}}
        <div class="col-xl-4">
            <div class="card shadow-sm h-100">
                <div class="card-header fw-semibold">
                    <i class="bi bi-pie-chart me-2 text-success"></i>Quick Stats
                </div>
                <div class="card-body">
                    <canvas id="quickStatsChart" width="100%" height="180"></canvas>
                    <div class="row text-center mt-3">
                        <div class="col-4">
                            <div class="fw-bold text-primary">45%</div>
                            <div class="small text-muted">New</div>
                        </div>
                        <div class="col-4">
                            <div class="fw-bold text-success">30%</div>
                            <div class="small text-muted">Active</div>
                        </div>
                        <div class="col-4">
                            <div class="fw-bold text-danger">25%</div>
                            <div class="small text-muted">Churned</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- /Charts Row --}}

    {{-- Recent Orders Table --}}
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <span class="fw-semibold"><i class="bi bi-table me-2 text-info"></i>Recent Orders</span>
                    <a href="#" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple" class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><span class="text-primary fw-semibold">#ORD-001</span></td>
                                <td>John Doe</td>
                                <td>Wellness Pack A</td>
                                <td>$120.00</td>
                                <td><span class="badge bg-success">Completed</span></td>
                                <td>{{ now()->format('d M Y') }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-primary"><i
                                            class="bi bi-eye"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-warning"><i
                                            class="bi bi-pencil"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><span class="text-primary fw-semibold">#ORD-002</span></td>
                                <td>Jane Smith</td>
                                <td>Detox Supplement</td>
                                <td>$85.00</td>
                                <td><span class="badge bg-warning text-dark">Pending</span></td>
                                <td>{{ now()->subDay()->format('d M Y') }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-primary"><i
                                            class="bi bi-eye"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-warning"><i
                                            class="bi bi-pencil"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><span class="text-primary fw-semibold">#ORD-003</span></td>
                                <td>Michael Brown</td>
                                <td>Herbal Tea Set</td>
                                <td>$45.50</td>
                                <td><span class="badge bg-danger">Cancelled</span></td>
                                <td>{{ now()->subDays(2)->format('d M Y') }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-primary"><i
                                            class="bi bi-eye"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-warning"><i
                                            class="bi bi-pencil"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td><span class="text-primary fw-semibold">#ORD-004</span></td>
                                <td>Emily Davis</td>
                                <td>Vitamin Bundle</td>
                                <td>$200.00</td>
                                <td><span class="badge bg-info">Processing</span></td>
                                <td>{{ now()->subDays(3)->format('d M Y') }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-primary"><i
                                            class="bi bi-eye"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-warning"><i
                                            class="bi bi-pencil"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>{{-- /Recent Orders --}}

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Revenue ($)',
                    data: [4200, 5800, 4900, 7200, 6100, 8400, 7700, 9300, 8100, 10200, 9400, 11500],
                    fill: true,
                    backgroundColor: 'rgba(13,110,253,0.1)',
                    borderColor: 'rgba(13,110,253,1)',
                    borderWidth: 2,
                    tension: 0.4,
                    pointBackgroundColor: 'rgba(13,110,253,1)',
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Quick Stats Doughnut
        const statsCtx = document.getElementById('quickStatsChart').getContext('2d');
        new Chart(statsCtx, {
            type: 'doughnut',
            data: {
                labels: ['New Users', 'Active Users', 'Churned'],
                datasets: [{
                    data: [45, 30, 25],
                    backgroundColor: ['#0d6efd', '#198754', '#dc3545'],
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Init DataTable
        window.addEventListener('DOMContentLoaded', () => {
            if (typeof $.fn.DataTable !== 'undefined') {
                $('#datatablesSimple').DataTable({
                    pageLength: 5
                });
            }
        });
    </script>
@endpush
