@extends('backend.layouts.app')

@section('title', 'Tables')

@section('content')
    <h1 class="mt-4">Tables</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Tables</li>
    </ol>

    {{-- Simple Table --}}
    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-table me-1"></i> Basic Table Example</div>
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Member Name</th>
                        <th>Package</th>
                        <th>Join Date</th>
                        <th>Level</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $rows = [
                            ['Rajesh Kumar', '₹10,000 Plan', '12 Jan 2024', 5, 'Active'],
                            ['Priya Sharma', '₹5,000 Plan', '3 Feb 2024', 3, 'Active'],
                            ['Amit Verma', '₹2,500 Plan', '20 Feb 2024', 2, 'Active'],
                            ['Sunita Patel', '₹20,000 Plan', '5 Mar 2024', 8, 'Active'],
                            ['Deepak Singh', '₹1,000 Plan', '15 Mar 2024', 1, 'Inactive'],
                            ['Meena Gupta', '₹5,000 Plan', '2 Apr 2024', 4, 'Active'],
                            ['Vicky Tiwari', '₹10,000 Plan', '18 Apr 2024', 6, 'Active'],
                            ['Kavita Joshi', '₹2,500 Plan', '1 May 2024', 2, 'Pending'],
                            ['Ramesh Yadav', '₹1,000 Plan', '20 May 2024', 1, 'Active'],
                            ['Neha Dubey', '₹20,000 Plan', '10 Jun 2024', 9, 'Active'],
                        ];
                    @endphp
                    @foreach ($rows as $i => $row)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $row[0] }}</td>
                            <td>{{ $row[1] }}</td>
                            <td>{{ $row[2] }}</td>
                            <td>{{ $row[3] }}</td>
                            <td>
                                @if ($row[4] === 'Active')
                                    <span class="badge bg-success">Active</span>
                                @elseif($row[4] === 'Inactive')
                                    <span class="badge bg-secondary">Inactive</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- DataTable --}}
    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-table me-1"></i> DataTable — Commission Ledger</div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-bordered table-hover align-middle w-100">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Member</th>
                        <th>Type</th>
                        <th>Amount (₹)</th>
                        <th>From Level</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $ledger = [
                            ['Rajesh Kumar', 'Level Income', '5,500', 2, '12 Jan 2024', 'Paid'],
                            ['Priya Sharma', 'Level Income', '2,750', 3, '13 Jan 2024', 'Paid'],
                            ['Sunita Patel', 'Royalty Bonus', '10,000', 1, '14 Jan 2024', 'Paid'],
                            ['Amit Verma', 'Level Income', '1,375', 2, '15 Jan 2024', 'Pending'],
                            ['Deepak Singh', 'Level Income', '550', 1, '16 Jan 2024', 'Paid'],
                            ['Meena Gupta', 'Level Income', '2,750', 4, '17 Jan 2024', 'Paid'],
                            ['Vicky Tiwari', 'Royalty Bonus', '5,000', 1, '18 Jan 2024', 'Processing'],
                            ['Kavita Joshi', 'Level Income', '1,375', 2, '19 Jan 2024', 'Pending'],
                            ['Ramesh Yadav', 'Level Income', '550', 1, '20 Jan 2024', 'Paid'],
                            ['Neha Dubey', 'Royalty Bonus', '10,000', 1, '21 Jan 2024', 'Paid'],
                            ['Rajesh Kumar', 'Level Income', '2,750', 3, '22 Jan 2024', 'Paid'],
                            ['Priya Sharma', 'Level Income', '550', 1, '23 Jan 2024', 'Pending'],
                            ['Sunita Patel', 'Level Income', '5,500', 2, '24 Jan 2024', 'Paid'],
                            ['Amit Verma', 'Royalty Bonus', '5,000', 1, '25 Jan 2024', 'Paid'],
                            ['Deepak Singh', 'Level Income', '275', 1, '26 Jan 2024', 'Paid'],
                        ];
                    @endphp
                    @foreach ($ledger as $i => $entry)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $entry[0] }}</td>
                            <td>{{ $entry[1] }}</td>
                            <td>{{ $entry[2] }}</td>
                            <td>{{ $entry[3] }}</td>
                            <td>{{ $entry[4] }}</td>
                            <td>
                                @if ($entry[5] === 'Paid')
                                    <span class="badge bg-success">Paid</span>
                                @elseif($entry[5] === 'Pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @else
                                    <span class="badge bg-info text-dark">Processing</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof simpleDatatables !== 'undefined') {
                new simpleDatatables.DataTable('#datatablesSimple');
            }
        });
    </script>
@endpush
