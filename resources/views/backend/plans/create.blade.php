@extends('backend.layouts.app')

@section('title', 'Create Plan')

@section('content')
    <h1 class="mt-4">Create Plan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.plans.index') }}">Plans</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-plus me-1"></i> New Plan</div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            <form method="POST" action="{{ route('admin.plans.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Plan Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}" placeholder="e.g. Starter Package" required />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Plan Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror" name="code"
                            value="{{ old('code') }}" placeholder="e.g. STARTER" required />
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Price (₹) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                            name="price" value="{{ old('price') }}" required />
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Base Value (₹) <span class="text-danger">*</span>
                            <small class="text-muted fw-normal">— used for commission calculation</small>
                        </label>
                        <input type="number" step="0.01" class="form-control @error('base_value') is-invalid @enderror"
                            name="base_value" value="{{ old('base_value') }}" required />
                        @error('base_value')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Daily Cap (₹) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('daily_cap') is-invalid @enderror"
                            name="daily_cap" value="{{ old('daily_cap') }}" required />
                        @error('daily_cap')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Total Cap (₹) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('total_cap') is-invalid @enderror"
                            name="total_cap" value="{{ old('total_cap') }}" required />
                        @error('total_cap')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                                {{ old('is_active', '1') ? 'checked' : '' }} />
                            <label class="form-check-label fw-semibold" for="is_active">Active</label>
                        </div>
                    </div>
                </div>
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save Plan</button>
                    <a href="{{ route('admin.plans.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
