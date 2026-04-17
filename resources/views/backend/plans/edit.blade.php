@extends('backend.layouts.app')

@section('title', 'Edit Plan')

@section('content')
    <h1 class="mt-4">Edit Plan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.plans.index') }}">Plans</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-edit me-1"></i> Edit: {{ $plan->name }}</div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            <form method="POST" action="{{ route('admin.plans.update', $plan->id) }}">
                @csrf @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Plan Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name', $plan->name) }}" required />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Plan Code</label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror" name="code"
                            value="{{ old('code', $plan->code) }}" required />
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Price (₹)</label>
                        <input type="number" step="0.01" class="form-control" name="price"
                            value="{{ old('price', $plan->price) }}" required />
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Base Value (₹)</label>
                        <input type="number" step="0.01" class="form-control" name="base_value"
                            value="{{ old('base_value', $plan->base_value) }}" required />
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Daily Cap (₹)</label>
                        <input type="number" step="0.01" class="form-control" name="daily_cap"
                            value="{{ old('daily_cap', $plan->daily_cap) }}" required />
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Total Cap (₹)</label>
                        <input type="number" step="0.01" class="form-control" name="total_cap"
                            value="{{ old('total_cap', $plan->total_cap) }}" required />
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                                {{ $plan->is_active ? 'checked' : '' }} />
                            <label class="form-check-label fw-semibold" for="is_active">Active</label>
                        </div>
                    </div>
                </div>
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-warning"><i class="fas fa-save me-1"></i> Update Plan</button>
                    <a href="{{ route('admin.plans.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
