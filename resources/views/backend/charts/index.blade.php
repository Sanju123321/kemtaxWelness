@extends('backend.layouts.app')

@section('title', 'Charts')

@section('content')
    <h1 class="mt-4">Charts</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Charts</li>
    </ol>

    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-chart-area me-1"></i> Member Growth (Area Chart)</div>
                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-chart-bar me-1"></i> Revenue Distribution (Bar Chart)</div>
                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-chart-pie me-1"></i> Package Distribution (Pie Chart)</div>
                <div class="card-body" style="position:relative;height:300px;">
                    <canvas id="myPieChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-chart-line me-1"></i> Commission Trend (Line Chart)</div>
                <div class="card-body"><canvas id="myLineChart" width="100%" height="40"></canvas></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Area Chart
        new Chart(document.getElementById('myAreaChart'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'New Members',
                    data: [65, 59, 80, 81, 56, 95, 110, 125, 140, 155, 170, 190],
                    fill: true,
                    backgroundColor: 'rgba(78,115,223,.1)',
                    borderColor: 'rgba(78,115,223,1)',
                    tension: 0.3
                }]
            },
            options: {
                responsive: true
            }
        });

        // Bar Chart
        new Chart(document.getElementById('myBarChart'), {
            type: 'bar',
            data: {
                labels: ['Level Income', 'Royalty Income', 'Operations'],
                datasets: [{
                    label: 'Revenue %',
                    data: [55, 20, 25],
                    backgroundColor: ['rgba(78,115,223,.8)', 'rgba(255,193,7,.8)', 'rgba(40,167,69,.8)']
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });

        // Pie Chart
        new Chart(document.getElementById('myPieChart'), {
            type: 'pie',
            data: {
                labels: ['₹1000 Plan', '₹2500 Plan', '₹5000 Plan', '₹10000 Plan', '₹20000 Plan'],
                datasets: [{
                    data: [35, 25, 20, 12, 8],
                    backgroundColor: ['#4e73df', '#ffc107', '#28a745', '#adb5bd', '#fd7e14']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Line Chart
        new Chart(document.getElementById('myLineChart'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Level Commissions',
                    data: [120000, 180000, 240000, 300000, 420000, 520000],
                    borderColor: 'rgba(78,115,223,1)',
                    tension: 0.3,
                    fill: false
                }, {
                    label: 'Royalty Bonuses',
                    data: [45000, 65000, 85000, 110000, 150000, 190000],
                    borderColor: 'rgba(40,167,69,1)',
                    tension: 0.3,
                    fill: false
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
@endpush
