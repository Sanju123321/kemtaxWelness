@extends('backend.layouts.app')

@section('title', 'System Settings')

@section('content')
    <h1 class="mt-4">System Settings</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Settings</li>
    </ol>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button"
                class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        <div class="row g-4">

            {{-- General --}}
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white"><i class="fas fa-cog me-1"></i> General</div>
                    <div class="card-body">
                        @foreach ($settings['general'] ?? collect() as $setting)
                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ $setting->label }}</label>
                                @if ($setting->type === 'boolean')
                                    <div class="form-check form-switch">
                                        <input class="form-check-input toggle-bool" type="checkbox"
                                            name="settings[{{ $setting->key }}]" value="1" @checked($setting->value == '1')
                                            id="toggle_{{ $setting->key }}">
                                        <label class="form-check-label text-muted" id="lbl_{{ $setting->key }}">
                                            {{ $setting->value == '1' ? 'Enabled' : 'Disabled' }}
                                        </label>
                                    </div>
                                @elseif ($setting->type === 'textarea')
                                    <textarea name="settings[{{ $setting->key }}]" class="form-control" rows="3">{{ $setting->value }}</textarea>
                                @else
                                    <input type="{{ $setting->type === 'number' ? 'number' : 'text' }}"
                                        name="settings[{{ $setting->key }}]" class="form-control"
                                        value="{{ $setting->value }}"
                                        @if ($setting->type === 'number') step="0.01" min="0" @endif>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Financial --}}
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header bg-success text-white"><i class="fas fa-rupee-sign me-1"></i> Financial</div>
                    <div class="card-body">
                        @foreach ($settings['financial'] ?? collect() as $setting)
                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ $setting->label }}</label>
                                <input type="number" name="settings[{{ $setting->key }}]" class="form-control"
                                    value="{{ $setting->value }}" step="0.01" min="0">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Commission Rates --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-warning"><i class="fas fa-percentage me-1"></i> MLM Commission Rates</div>
                    <div class="card-body">
                        <div class="alert alert-info small mb-3">
                            <i class="fas fa-info-circle me-1"></i> Changes to commission rates take effect on the
                            <strong>next</strong> plan purchase. Existing distributed income is not affected.
                        </div>
                        <div class="row g-3">
                            @foreach ($settings['commission'] ?? collect() as $setting)
                                <div class="col-md-4 col-lg-2">
                                    <label class="form-label fw-semibold small">{{ $setting->label }}</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="settings[{{ $setting->key }}]" class="form-control"
                                            value="{{ $setting->value }}" step="0.1" min="0" max="100">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save me-1"></i> Save All Settings
            </button>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.toggle-bool').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                var key = this.id.replace('toggle_', '');
                var label = document.getElementById('lbl_' + key);
                if (label) label.textContent = this.checked ? 'Enabled' : 'Disabled';
            });
        });
    </script>
@endpush
