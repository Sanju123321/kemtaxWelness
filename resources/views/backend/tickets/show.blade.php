@extends('backend.layouts.app')

@section('title', 'Ticket #' . $ticket->ticket_number)

@section('content')
    <h1 class="mt-4">Ticket: {{ $ticket->ticket_number }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.tickets.index') }}">Tickets</a></li>
        <li class="breadcrumb-item active">{{ $ticket->ticket_number }}</li>
    </ol>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button"
                class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="row g-4">
        {{-- Left: ticket details --}}
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-dark text-white"><i class="fas fa-ticket-alt me-1"></i> Ticket Details</div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-5 text-muted">Ticket #</dt>
                        <dd class="col-7 fw-bold">{{ $ticket->ticket_number }}</dd>

                        <dt class="col-5 text-muted">Subject</dt>
                        <dd class="col-7">{{ $ticket->subject }}</dd>

                        <dt class="col-5 text-muted">Category</dt>
                        <dd class="col-7"><span class="badge bg-secondary">{{ ucfirst($ticket->category) }}</span></dd>

                        <dt class="col-5 text-muted">Priority</dt>
                        <dd class="col-7">
                            @php $pColors = ['low'=>'success','medium'=>'info','high'=>'warning','urgent'=>'danger']; @endphp
                            <span
                                class="badge bg-{{ $pColors[$ticket->priority] ?? 'secondary' }}">{{ ucfirst($ticket->priority) }}</span>
                        </dd>

                        <dt class="col-5 text-muted">Status</dt>
                        <dd class="col-7">
                            @php $sColors = ['open'=>'danger','in_progress'=>'warning','resolved'=>'success','closed'=>'secondary']; @endphp
                            <span
                                class="badge bg-{{ $sColors[$ticket->status] ?? 'secondary' }}">{{ ucfirst(str_replace('_', ' ', $ticket->status)) }}</span>
                        </dd>

                        <dt class="col-5 text-muted">Member</dt>
                        <dd class="col-7">{{ $ticket->user->name ?? '—' }}<br><small
                                class="text-muted">{{ $ticket->user->email ?? '' }}</small></dd>

                        <dt class="col-5 text-muted">Opened</dt>
                        <dd class="col-7"><small>{{ $ticket->created_at->format('d M Y, h:i A') }}</small></dd>
                    </dl>
                </div>
            </div>

            {{-- Change Status --}}
            <div class="card">
                <div class="card-header">Change Status</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.tickets.status', $ticket->id) }}">
                        @csrf
                        <div class="mb-3">
                            <select name="status" class="form-select">
                                @foreach (['open', 'in_progress', 'resolved', 'closed'] as $s)
                                    <option value="{{ $s }}" @selected($ticket->status == $s)>
                                        {{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary w-100">Update Status</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Right: conversation --}}
        <div class="col-lg-8">
            {{-- Original message --}}
            <div class="card mb-3 border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <span><i class="fas fa-user me-1"></i> {{ $ticket->user->name ?? 'Member' }}</span>
                    <small>{{ $ticket->created_at->format('d M Y, h:i A') }}</small>
                </div>
                <div class="card-body">{{ $ticket->message }}</div>
            </div>

            {{-- Replies --}}
            @foreach ($replies as $reply)
                <div class="card mb-3 {{ $reply->is_admin ? 'border-success ms-4' : 'border-secondary' }}">
                    <div
                        class="card-header {{ $reply->is_admin ? 'bg-success text-white' : 'bg-light' }} d-flex justify-content-between">
                        <span>
                            @if ($reply->is_admin)
                                <i class="fas fa-user-shield me-1"></i> {{ $reply->admin->name ?? 'Admin' }}
                            @else
                                <i class="fas fa-user me-1"></i> {{ $reply->user->name ?? 'Member' }}
                            @endif
                        </span>
                        <small>{{ $reply->created_at->format('d M Y, h:i A') }}</small>
                    </div>
                    <div class="card-body">{{ $reply->message }}</div>
                </div>
            @endforeach

            {{-- Reply form --}}
            @if ($ticket->status !== 'closed')
                <div class="card border-success">
                    <div class="card-header bg-success text-white"><i class="fas fa-reply me-1"></i> Admin Reply</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.tickets.reply', $ticket->id) }}">
                            @csrf
                            <div class="mb-3">
                                <textarea name="message" class="form-control" rows="4" placeholder="Type your reply..." required></textarea>
                                @error('message')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane me-1"></i> Send
                                Reply</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-secondary">This ticket is closed. Reopen it to reply.</div>
            @endif
        </div>
    </div>
@endsection
