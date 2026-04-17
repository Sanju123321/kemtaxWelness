@extends('backend.layouts.app')

@section('title', 'New Ticket')

@section('content')
    <h1 class="mt-4">
        Create Ticket</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.tickets.index') }}">Tickets</a></li>
        <li class="breadcrumb-item active">New</li>
    </ol>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header"><i class="fas fa-headset me-1"></i> New Support Ticket</div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('admin.tickets.store') }}">
                        @csrf
                        <div class="row g-3 mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Member <span class="text-danger">*</span></label>
                                <select name="user_id" class="form-select" required>
                                    <option value="">— Select Member —</option>
                                    @foreach ($users as $u)
                                        <option value="{{ $u->id }}" @selected(old('user_id') == $u->id)>{{ $u->name }}
                                            ({{ $u->email }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Subject <span class="text-danger">*</span></label>
                                <input type="text" name="subject" class="form-control" value="{{ old('subject') }}"
                                    required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Category <span class="text-danger">*</span></label>
                                <select name="category" class="form-select" required>
                                    @foreach (['billing', 'technical', 'mlm', 'account', 'other'] as $c)
                                        <option value="{{ $c }}" @selected(old('category') == $c)>{{ ucfirst($c) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Priority <span class="text-danger">*</span></label>
                                <select name="priority" class="form-select" required>
                                    @foreach (['low', 'medium', 'high', 'urgent'] as $p)
                                        <option value="{{ $p }}" @selected(old('priority', 'medium') == $p)>
                                            {{ ucfirst($p) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Message <span class="text-danger">*</span></label>
                                <textarea name="message" class="form-control" rows="5" required>{{ old('message') }}</textarea>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Create Ticket</button>
                            <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
