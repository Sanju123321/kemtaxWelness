@extends('backend.layouts.app')

@section('title', 'Contact Message')

@section('content')
    <h1 class="mt-4">Contact Message</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.contact.index') }}">Contact Messages</a></li>
        <li class="breadcrumb-item active">#{{ $msg->id }}</li>
    </ol>

    <div class="row g-4">
        {{-- Message card --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-envelope me-2"></i> Enquiry from <strong>{{ $msg->name }}</strong></span>
                    @if ($msg->is_read)
                        <span class="badge bg-success"><i class="fas fa-envelope-open me-1"></i>Read</span>
                    @else
                        <span class="badge bg-danger"><i class="fas fa-envelope me-1"></i>Unread</span>
                    @endif
                </div>
                <div class="card-body">
                    <div class="p-3 rounded-3"
                        style="background:linear-gradient(135deg,#f7f3ec,#fef9f0);border:1px solid #e8d8a0;">
                        <p class="mb-0"
                            style="font-family:Georgia,serif;font-size:15px;line-height:1.9;color:#3a2c1a;white-space:pre-wrap;">
                            {{ $msg->message }}</p>
                    </div>
                </div>
                <div class="card-footer text-muted small">
                    <i class="fas fa-clock me-1"></i> Received {{ $msg->created_at->format('d M Y, h:i A') }}
                    ({{ $msg->created_at->diffForHumans() }})
                </div>
            </div>
        </div>

        {{-- Sender info --}}
        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-user me-1"></i> Sender Details
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <tr>
                            <td class="text-muted fw-semibold ps-3" width="100">Name</td>
                            <td class="fw-bold">{{ $msg->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold ps-3">Email</td>
                            <td><a href="mailto:{{ $msg->email }}" class="text-success">{{ $msg->email }}</a></td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold ps-3">Phone</td>
                            <td>{{ $msg->phone ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold ps-3">Interest</td>
                            <td>{{ $msg->interest ?? '—' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Actions --}}
            <div class="card">
                <div class="card-header"><i class="fas fa-bolt me-1"></i> Actions</div>
                <div class="card-body d-grid gap-2">
                    <a href="mailto:{{ $msg->email }}" class="btn btn-success">
                        <i class="fas fa-reply me-2"></i>Reply via Email
                    </a>
                    <a href="{{ route('admin.contact.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Inbox
                    </a>
                    <form method="POST" action="{{ route('admin.contact.destroy', $msg->id) }}"
                        onsubmit="return confirm('Delete this message permanently?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-trash me-2"></i>Delete Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
