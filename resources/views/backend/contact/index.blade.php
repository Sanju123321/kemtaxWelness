@extends('backend.layouts.app')

@section('title', 'Contact Messages')

@section('content')
    <h1 class="mt-4">Contact Messages</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Contact Messages</li>
    </ol>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button"
                class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    {{-- Stats row --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-danger">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Unread</div>
                        <div class="fs-3 fw-bold text-danger">{{ $unreadCount }}</div>
                    </div>
                    <i class="fas fa-envelope fa-2x text-danger opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Read</div>
                        <div class="fs-3 fw-bold text-success">{{ $messages->total() - $unreadCount }}</div>
                    </div>
                    <i class="fas fa-envelope-open fa-2x text-success opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-primary">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Total</div>
                        <div class="fs-3 fw-bold text-primary">{{ $messages->total() }}</div>
                    </div>
                    <i class="fas fa-inbox fa-2x text-primary opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div><i class="fas fa-envelope me-1"></i> Enquiries</div>
            <form method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search name / email…"
                    value="{{ request('search') }}">
                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All</option>
                    <option value="unread" @selected(request('status') === 'unread')>Unread</option>
                    <option value="read" @selected(request('status') === 'read')>Read</option>
                </select>
                <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                @if (request('search') || request('status'))
                    <a href="{{ route('admin.contact.index') }}" class="btn btn-sm btn-secondary">Clear</a>
                @endif
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Interest</th>
                            <th>Message</th>
                            <th>Received</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($messages as $msg)
                            <tr class="{{ $msg->is_read ? '' : 'table-warning' }}">
                                <td>{{ $msg->id }}</td>
                                <td class="fw-semibold">
                                    @if (!$msg->is_read)
                                        <span class="badge bg-danger me-1">New</span>
                                    @endif
                                    {{ $msg->name }}
                                </td>
                                <td>
                                    <a href="mailto:{{ $msg->email }}"
                                        class="text-decoration-none">{{ $msg->email }}</a>
                                </td>
                                <td>{{ $msg->phone ?? '—' }}</td>
                                <td>{{ $msg->interest ?? '—' }}</td>
                                <td style="max-width:220px;">
                                    <span class="d-inline-block text-truncate" style="max-width:200px;"
                                        title="{{ $msg->message }}">
                                        {{ $msg->message }}
                                    </span>
                                </td>
                                <td><small>{{ $msg->created_at->format('d M Y, h:i A') }}</small></td>
                                <td>
                                    @if ($msg->is_read)
                                        <span class="badge bg-success"><i class="fas fa-envelope-open me-1"></i>Read</span>
                                    @else
                                        <span class="badge bg-danger"><i class="fas fa-envelope me-1"></i>Unread</span>
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    <a href="{{ route('admin.contact.show', $msg->id) }}"
                                        class="btn btn-sm btn-outline-primary" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="mailto:{{ $msg->email }}" class="btn btn-sm btn-outline-success"
                                        title="Reply via email">
                                        <i class="fas fa-reply"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.contact.destroy', $msg->id) }}"
                                        class="d-inline" onsubmit="return confirm('Delete this message?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">No contact messages found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($messages->hasPages())
            <div class="card-footer">
                <span class="text-muted small">Showing {{ $messages->firstItem() }}–{{ $messages->lastItem() }} of
                    {{ $messages->total() }}</span>
                {{ $messages->links() }}
            </div>
        @endif
    </div>
@endsection
