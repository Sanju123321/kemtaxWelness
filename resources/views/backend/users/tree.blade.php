@extends('backend.layouts.app')

@section('title', 'MLM Tree — ' . $user->name)

@section('content')
    <h1 class="mt-4">MLM Tree</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
        <li class="breadcrumb-item active">Tree: {{ $user->name }}</li>
    </ol>

    {{-- User Info --}}
    <div class="card mb-4">
        <div class="card-body d-flex align-items-center gap-3">
            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold"
                style="width:56px;height:56px;font-size:1.4rem;flex-shrink:0">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <div>
                <div class="fw-bold fs-5">{{ $user->name }}</div>
                <div class="text-muted small">{{ $user->email }} &bull; Ref: {{ $user->reference_code ?? '—' }}</div>
            </div>
            <div class="ms-auto text-end">
                <span
                    class="badge {{ $user->has_plan ? 'bg-success' : 'bg-secondary' }}">{{ $user->has_plan ? 'Active Member' : 'No Plan' }}</span>
                <div class="small text-muted mt-1">Total Downlines: <strong>{{ $downlineCount }}</strong></div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><i class="fas fa-sitemap me-1"></i> Downline Tree</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Level</th>
                            <th>Member</th>
                            <th>Email</th>
                            <th>Ref Code</th>
                            <th>Status</th>
                            <th>Commission Earned</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($downlines as $node)
                            <tr>
                                <td><span class="badge bg-primary">L{{ $node->level }}</span></td>
                                <td>
                                    <div class="fw-semibold">{{ $node->user->name ?? '—' }}</div>
                                </td>
                                <td><small>{{ $node->user->email ?? '' }}</small></td>
                                <td><small>{{ $node->user->reference_code ?? '—' }}</small></td>
                                <td>
                                    <span
                                        class="badge {{ ($node->user->status ?? 'active') === 'active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($node->user->status ?? 'active') }}
                                    </span>
                                </td>
                                <td class="text-success fw-semibold">
                                    ₹{{ number_format($node->user->total_earned ?? 0, 2) }}
                                </td>
                                <td><small>{{ $node->user->created_at?->format('d M Y') ?? '—' }}</small></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No downlines found for this user.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($downlines->hasPages())
            <div class="card-footer">
                <div class="pagination-wrapper">
                    <span class="text-muted small">Showing {{ $downlines->firstItem() }}–{{ $downlines->lastItem() }} of
                        {{ $downlines->total() }}</span>
                    {{ $downlines->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
