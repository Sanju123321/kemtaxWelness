@extends('backend.layouts.app')

@section('title', 'Add KYC Document')

@section('content')
    <h1 class="mt-4">
        Add KYC Document</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.kyc.index') }}">KYC</a></li>
        <li class="breadcrumb-item active">Add</li>
    </ol>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header"><i class="fas fa-id-card me-1"></i> KYC Entry</div>
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
                    <form method="POST" action="{{ route('admin.kyc.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Member <span class="text-danger">*</span></label>
                            <select name="user_id" class="form-select" required>
                                <option value="">— Select Member —</option>
                                @foreach ($users as $u)
                                    <option value="{{ $u->id }}" @selected(old('user_id') == $u->id)>{{ $u->name }}
                                        ({{ $u->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Document Type <span class="text-danger">*</span></label>
                                <select name="doc_type" class="form-select" required>
                                    @foreach (['aadhaar', 'pan', 'selfie', 'other'] as $t)
                                        <option value="{{ $t }}" @selected(old('doc_type') == $t)>{{ ucfirst($t) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Document Number</label>
                                <input type="text" name="doc_number" class="form-control"
                                    value="{{ old('doc_number') }}">
                            </div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required>
                                @foreach (['pending', 'verified', 'rejected'] as $s)
                                    <option value="{{ $s }}" @selected(old('status', 'pending') == $s)>{{ ucfirst($s) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Admin Note</label>
                            <textarea name="admin_note" class="form-control" rows="3">{{ old('admin_note') }}</textarea>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Save KYC</button>
                            <a href="{{ route('admin.kyc.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
