@extends('backend.layouts.app')

@section('title', 'Advanced Reports')

@section('content')
    <h1 class="mt-4">Advanced Reports</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Reports</li>
    </ol>

    {{-- Tabs --}}
    <ul class="nav nav-tabs mb-4" id="reportTabs">
        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#topEarners"><i
                    class="fas fa-trophy me-1"></i>Top Earners</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#inactiveMembers"><i
                    class="fas fa-user-slash me-1"></i>Inactive Members</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#revenueByPlan"><i
                    class="fas fa-layer-group me-1"></i>Revenue by Plan</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#levelDist"><i
                    class="fas fa-sitemap me-1"></i>Level Distribution</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#monthlyChart"><i
                    class="fas fa-chart-line me-1"></i>Monthly Trends</a></li>
    </ul>

    <div class="tab-content">

        {{-- Top Earners --}}
        <div class="tab-pane fade show active" id="topEarners">
            <div class="card">
                <div class="card-header"><i class="fas fa-trophy text-warning me-1"></i> Top 20 Earners</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Member</th>
                                    <th>Email</th>
                                    <th>Plan</th>
                                    <th>Total Earned</th>
                                    <th>Wallet Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($topEarners as $i => $user)
                                    <tr>
                                        <td>
                                            @if ($i < 3)
                                                <span class="badge bg-warning text-dark">{{ $i + 1 }}</span>
                                            @else
                                                {{ $i + 1 }}
                                            @endif
                                        </td>
                                        <td><a href="{{ route('admin.users.income', $user->id) }}">{{ $user->name }}</a>
                                        </td>
                                        <td><small>{{ $user->email }}</small></td>
                                        <td><span
                                                class="badge {{ $user->has_plan ? 'bg-success' : 'bg-secondary' }}">{{ $user->has_plan ? 'Active' : 'No Plan' }}</span>
                                        </td>
                                        <td class="fw-bold text-success">₹{{ number_format($user->total_earned, 2) }}</td>
                                        <td>₹{{ number_format($user->wallet_balance, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">No data available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Inactive Members --}}
        <div class="tab-pane fade" id="inactiveMembers">
            <div class="card">
                <div class="card-header"><i class="fas fa-user-slash text-secondary me-1"></i> Inactive Members (No Plan)
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Joined</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($inactiveMembers as $i => $user)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td><small>{{ $user->email }}</small></td>
                                        <td>
                                            <span
                                                class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                                {{ ucfirst($user->status ?? 'active') }}
                                            </span>
                                        </td>
                                        <td><small>{{ $user->created_at->format('d M Y') }}</small></td>
                                        <td>
                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                                class="btn btn-xs btn-outline-primary">
                                                <i class="fas fa-edit"></i> Manage
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">All members have plans.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Revenue by Plan --}}
        <div class="tab-pane fade" id="revenueByPlan">
            <div class="card">
                <div class="card-header"><i class="fas fa-layer-group me-1"></i> Revenue by Plan</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Plan</th>
                                    <th>Price</th>
                                    <th>Total Purchases</th>
                                    <th>Total Revenue</th>
                                    <th>Avg Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($revenueByPlan as $plan)
                                    <tr>
                                        <td class="fw-semibold">{{ $plan->name }}</td>
                                        <td>₹{{ number_format($plan->price, 2) }}</td>
                                        <td>{{ number_format($plan->purchase_count) }}</td>
                                        <td class="fw-bold text-success">₹{{ number_format($plan->total_revenue ?? 0, 2) }}
                                        </td>
                                        <td>₹{{ $plan->purchase_count > 0 ? number_format(($plan->total_revenue ?? 0) / $plan->purchase_count, 2) : '0.00' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">No plan data available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Level Distribution --}}
        <div class="tab-pane fade" id="levelDist">
            <div class="card">
                <div class="card-header"><i class="fas fa-sitemap me-1"></i> Commission by Level</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Level</th>
                                    <th>Total Credited Records</th>
                                    <th>Total Amount</th>
                                    <th>Share %</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $grandTotal = $levelDistribution->sum('total'); @endphp
                                @forelse ($levelDistribution as $row)
                                    <tr>
                                        <td><span class="badge bg-primary">Level {{ $row->level }}</span></td>
                                        <td>{{ number_format($row->count) }}</td>
                                        <td class="fw-bold">₹{{ number_format($row->total, 2) }}</td>
                                        <td>
                                            @php $pct = $grandTotal > 0 ? ($row->total / $grandTotal) * 100 : 0; @endphp
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="progress flex-grow-1" style="height:8px">
                                                    <div class="progress-bar bg-primary"
                                                        style="width: {{ $pct }}%"></div>
                                                </div>
                                                <small>{{ number_format($pct, 1) }}%</small>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">No commission data.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Monthly Trends --}}
        <div class="tab-pane fade" id="monthlyChart">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">Monthly Commissions (Last 12 Months)</div>
                        <div class="card-body"><canvas id="commissionChart" height="200"></canvas></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">Member Growth (Last 12 Months)</div>
                        <div class="card-body"><canvas id="growthChart" height="200"></canvas></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
        <script>
            // Commission Chart
            new Chart(document.getElementById('commissionChart'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($monthlyCommissions->pluck('month')) !!},
                    datasets: [{
                        label: 'Commission Credited (₹)',
                        data: {!! json_encode($monthlyCommissions->pluck('total')) !!},
                        backgroundColor: 'rgba(79, 70, 229, 0.7)',
                        borderRadius: 4,
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

            // Growth Chart
            new Chart(document.getElementById('growthChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($memberGrowth->pluck('month')) !!},
                    datasets: [{
                        label: 'New Members',
                        data: {!! json_encode($memberGrowth->pluck('count')) !!},
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        fill: true,
                        tension: 0.3,
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
        </script>
    @endpush
@endsection
