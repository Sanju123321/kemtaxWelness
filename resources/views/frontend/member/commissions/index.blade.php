@extends('frontend.layouts.member')

@section('title', 'Recent Commissions')

@section('content')
    <section class="section" style="background:#f4f6f9;min-height:calc(100vh - 120px);">
        <div class="container">
            <div class="card border-0 shadow-sm" style="border-radius:12px;">
                <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap" style="gap:10px;">
                    <h5 class="mb-0"><i class="fas fa-history mr-2 text-color"></i>Recent Commissions</h5>
                    <a href="{{ route('member.dashboard') }}" class="btn btn-sm btn-outline-success">
                        <i class="fas fa-arrow-left mr-1"></i>Back to Dashboard
                    </a>
                </div>
                <div class="card-body">
                    <form method="GET" class="row align-items-end" style="gap:10px;">
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="search" value="{{ $search }}"
                                placeholder="Search by member, type, level, status">
                        </div>
                        <div class="col-md-2">
                            <label class="mb-1 small text-muted">From Date</label>
                            <input type="date" class="form-control" name="date_from" value="{{ $dateFrom ?? '' }}">
                        </div>
                        <div class="col-md-2">
                            <label class="mb-1 small text-muted">To Date</label>
                            <input type="date" class="form-control" name="date_to" value="{{ $dateTo ?? '' }}">
                        </div>
                        <div class="col-md-2">
                            <label class="mb-1 small text-muted">Commission Type</label>
                            <select name="commission_type" class="form-control">
                                <option value="">All Types</option>
                                <option value="referral" {{ ($commissionType ?? '') === 'referral' ? 'selected' : '' }}>Referral</option>
                                <option value="plan_upgrade" {{ ($commissionType ?? '') === 'plan_upgrade' ? 'selected' : '' }}>Upgraded Plan</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="sort_by" class="form-control">
                                <option value="date" {{ $sortBy === 'date' ? 'selected' : '' }}>Sort by Date</option>
                                <option value="from" {{ $sortBy === 'from' ? 'selected' : '' }}>Sort by Member</option>
                                <option value="type" {{ $sortBy === 'type' ? 'selected' : '' }}>Sort by Type</option>
                                <option value="level" {{ $sortBy === 'level' ? 'selected' : '' }}>Sort by Level</option>
                                <option value="amount" {{ $sortBy === 'amount' ? 'selected' : '' }}>Sort by Amount</option>
                                <option value="status" {{ $sortBy === 'status' ? 'selected' : '' }}>Sort by Status</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <select name="sort_dir" class="form-control">
                                <option value="desc" {{ $sortDir === 'desc' ? 'selected' : '' }}>Descending</option>
                                <option value="asc" {{ $sortDir === 'asc' ? 'selected' : '' }}>Ascending</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-main btn-block">Apply</button>
                        </div>
                        <div class="col-md-1">
                            <a href="{{ route('member.commissions.history') }}" class="btn btn-outline-secondary btn-block">Reset</a>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Date</th>
                                <th>From Member</th>
                                <th>Type</th>
                                <th>Level</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rows as $row)
                                <tr>
                                    <td>{{ $row->created_at->format('M d, Y') }}</td>
                                    <td>{{ $row->fromUser->name ?? 'N/A' }}</td>
                                    <td>{{ ($row->commission_source ?? 'referral') === 'plan_upgrade' ? 'Upgraded Plan' : 'Referral' }}</td>
                                    <td>{{ (int) $row->level <= 1 ? 'Direct (Level 1)' : 'Level ' . (int) $row->level }}</td>
                                    <td><strong class="text-success">₹{{ number_format((float) $row->amount, 2) }}</strong></td>
                                    <td>
                                        <span class="badge {{ $row->status === 'credited' ? 'badge-success' : 'badge-warning' }}">
                                            {{ ucfirst($row->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No commission records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white">
                    {{ $rows->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
