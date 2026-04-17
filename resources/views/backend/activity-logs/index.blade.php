@extends('backend.layouts.app')

@section('title', 'Activity Log')

@section('content')
    <h1 class="mt-4">Admin Activity Log</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Activity Log</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div><i class="fas fa-history me-1"></i> All Admin Actions ({{ $logs->total() }})</div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Admin</th>
                            <th>Action</th>
                            <th>Target</th>
                            <th>Details</th>
                            <th>IP</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr>
                                <td>{{ $log->id }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $log->admin->name ?? 'System' }}</div>
                                </td>
                                <td>
                                    @php
                                        $actionColors = [
                                            'withdrawal_approved' => 'success',
                                            'withdrawal_rejected' => 'danger',
                                            'kyc_approved' => 'success',
                                            'kyc_rejected' => 'danger',
                                            'user_blocked' => 'danger',
                                            'user_unblocked' => 'success',
                                            'settings_updated' => 'info',
                                            'ticket_status_changed' => 'warning',
                                            'plan_assigned' => 'primary',
                                        ];
                                        $color = $actionColors[$log->action] ?? 'secondary';
                                    @endphp
                                    <span
                                        class="badge bg-{{ $color }}">{{ str_replace('_', ' ', $log->action) }}</span>
                                </td>
                                <td>
                                    @if ($log->target_type && $log->target_id)
                                        <small class="text-muted">{{ $log->target_type }} #{{ $log->target_id }}</small>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($log->details)
                                        <small>
                                            @foreach ($log->details as $k => $v)
                                                <span class="text-muted">{{ $k }}:</span>
                                                {{ is_array($v) ? implode(', ', $v) : $v }}<br>
                                            @endforeach
                                        </small>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td><small class="text-muted">{{ $log->ip ?? '—' }}</small></td>
                                <td><small>{{ $log->created_at->format('d M Y, h:i A') }}</small></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No activity logged yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($logs->hasPages())
            <div class="card-footer">
                <div class="pagination-wrapper">
                    <span class="text-muted small">Showing {{ $logs->firstItem() }}–{{ $logs->lastItem() }} of
                        {{ $logs->total() }}</span>
                    {{ $logs->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
