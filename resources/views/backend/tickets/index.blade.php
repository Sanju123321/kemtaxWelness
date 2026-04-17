@extends('backend.layouts.app')

@section('title', 'Support Tickets')

@section('content')
    <h1 class="mt-4">Support Tickets</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Tickets</li>
    </ol>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button"
                class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        @foreach (['open' => ['Open', 'danger'], 'in_progress' => ['In Progress', 'warning'], 'resolved' => ['Resolved', 'success'], 'closed' => ['Closed', 'secondary']] as $key => [$label, $color])
            <div class="col-md-3">
                <div class="card border-{{ $color }}">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">{{ $label }}</div>
                            <div class="fs-3 fw-bold text-{{ $color }}">{{ $stats[$key] }}</div>
                        </div>
                        <i class="fas fa-ticket-alt fa-2x text-{{ $color }} opacity-50"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div><i class="fas fa-headset me-1"></i> All Tickets</div>
            <div class="d-flex gap-2">
                <form method="GET" class="d-flex gap-2">
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        @foreach (['open', 'in_progress', 'resolved', 'closed'] as $s)
                            <option value="{{ $s }}" @selected(request('status') == $s)>
                                {{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                        @endforeach
                    </select>
                    <select name="priority" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Priority</option>
                        @foreach (['low', 'medium', 'high', 'urgent'] as $p)
                            <option value="{{ $p }}" @selected(request('priority') == $p)>{{ ucfirst($p) }}</option>
                        @endforeach
                    </select>
                </form>
                <a href="{{ route('admin.tickets.create') }}" class="btn btn-sm btn-primary"><i
                        class="fas fa-plus me-1"></i>New Ticket</a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Ticket #</th>
                            <th>Subject</th>
                            <th>Member</th>
                            <th>Category</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Replies</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tickets as $ticket)
                            <tr>
                                <td><span class="badge bg-dark">{{ $ticket->ticket_number }}</span></td>
                                <td>{{ Str::limit($ticket->subject, 40) }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $ticket->user->name ?? '—' }}</div>
                                    <small class="text-muted">{{ $ticket->user->email ?? '' }}</small>
                                </td>
                                <td><span class="badge bg-secondary">{{ ucfirst($ticket->category) }}</span></td>
                                <td>
                                    @php
                                        $pColors = [
                                            'low' => 'success',
                                            'medium' => 'info',
                                            'high' => 'warning',
                                            'urgent' => 'danger',
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $pColors[$ticket->priority] ?? 'secondary' }} text-dark">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $sColors = [
                                            'open' => 'danger',
                                            'in_progress' => 'warning',
                                            'resolved' => 'success',
                                            'closed' => 'secondary',
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $sColors[$ticket->status] ?? 'secondary' }}">
                                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                    </span>
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $ticket->replies_count }}</span></td>
                                <td><small>{{ $ticket->created_at->format('d M Y') }}</small></td>
                                <td>
                                    <a href="{{ route('admin.tickets.show', $ticket->id) }}"
                                        class="btn btn-xs btn-primary">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">No tickets found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($tickets->hasPages())
            <div class="card-footer">
                <div class="pagination-wrapper">
                    <span class="text-muted small">Showing {{ $tickets->firstItem() }}–{{ $tickets->lastItem() }} of
                        {{ $tickets->total() }}</span>
                    {{ $tickets->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
