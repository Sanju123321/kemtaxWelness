@extends('backend.layouts.app')

@section('title', 'Manage About Us')

@section('content')
    <h1 class="mt-4">Manage About Us</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">About Us</li>
    </ol>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-info-circle me-1"></i> Intro Section</div>
            <div class="card-body row g-3">
                <div class="col-md-6">
                    <label class="form-label">Heading</label>
                    <input type="text" name="intro_heading" class="form-control" value="{{ old('intro_heading', $about['intro_heading']) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Intro Image</label>
                    <input type="file" name="intro_image" class="form-control" accept="image/*">
                    @if (!empty($about['intro_image']))
                        <img src="{{ asset('storage/' . $about['intro_image']) }}" alt="Intro" class="img-thumbnail mt-2" style="max-height: 110px;">
                    @endif
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="intro_body" class="form-control" rows="4">{{ old('intro_body', $about['intro_body']) }}</textarea>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-trophy me-1"></i> Top Earners (Multiple Upload)</div>
            <div class="card-body">
                <div id="topEarnerWrap">
                    @forelse(old('top_earners', $about['top_earners']) as $idx => $earner)
                        <div class="row g-3 border rounded p-3 mb-3 top-earner-row">
                            <div class="col-md-4">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="top_earners[{{ $idx }}][name]" value="{{ $earner['name'] ?? '' }}">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="top_earners[{{ $idx }}][title]" value="{{ $earner['title'] ?? '' }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Photo</label>
                                <input type="file" class="form-control" name="top_earners[{{ $idx }}][image]" accept="image/*">
                                @if (!empty($earner['image']))
                                    <img src="{{ asset('storage/' . $earner['image']) }}" alt="Earner" class="img-thumbnail mt-2" style="max-height: 85px;">
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="row g-3 border rounded p-3 mb-3 top-earner-row">
                            <div class="col-md-4">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="top_earners[0][name]">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="top_earners[0][title]">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Photo</label>
                                <input type="file" class="form-control" name="top_earners[0][image]" accept="image/*">
                            </div>
                        </div>
                    @endforelse
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm" id="addTopEarner">
                    <i class="fas fa-plus me-1"></i>Add Top Earner
                </button>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-quote-left me-1"></i> Member Success Stories</div>
            <div class="card-body">
                @php $stories = old('stories', $about['stories']); @endphp
                @for($i = 0; $i < max(3, count($stories)); $i++)
                    <div class="row g-3 border rounded p-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Member Name</label>
                            <input type="text" class="form-control" name="stories[{{ $i }}][name]" value="{{ $stories[$i]['name'] ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="stories[{{ $i }}][title]" value="{{ $stories[$i]['title'] ?? '' }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Quote</label>
                            <textarea class="form-control" name="stories[{{ $i }}][quote]" rows="2">{{ $stories[$i]['quote'] ?? '' }}</textarea>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i>Save About Us
        </button>
    </form>
@endsection

@push('scripts')
    <script>
        (function() {
            const wrap = document.getElementById('topEarnerWrap');
            const addBtn = document.getElementById('addTopEarner');
            addBtn?.addEventListener('click', function() {
                const index = wrap.querySelectorAll('.top-earner-row').length;
                const row = document.createElement('div');
                row.className = 'row g-3 border rounded p-3 mb-3 top-earner-row';
                row.innerHTML =
                    '<div class="col-md-4"><label class="form-label">Name</label><input type="text" class="form-control" name="top_earners[' + index + '][name]"></div>' +
                    '<div class="col-md-5"><label class="form-label">Title</label><input type="text" class="form-control" name="top_earners[' + index + '][title]"></div>' +
                    '<div class="col-md-3"><label class="form-label">Photo</label><input type="file" class="form-control" name="top_earners[' + index + '][image]" accept="image/*"></div>';
                wrap.appendChild(row);
            });
        })();
    </script>
@endpush
