@extends('layouts.admin')

@section('title', 'Add New Library Book')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800" style="font-family: var(--font-family-title); font-weight: 700;">Add New Storyloom Book</h1>
        <p class="text-muted small mb-0">Upload covers, interior spread pages, tags, and reader metadata.</p>
    </div>
    <a href="{{ route('admin.library.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Library Manager
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0 ps-3">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('admin.library.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-4">
        <!-- Main Details -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 font-weight-bold text-dark"><i class="bi bi-info-circle me-2 text-primary"></i> Book Details & Copy</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Book Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" placeholder="e.g. The First Home" value="{{ old('title') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Display Mode <span class="text-danger">*</span></label>
                            <select name="type" class="form-select" required>
                                <option value="featured" {{ old('type') == 'featured' ? 'selected' : '' }}>Featured Storyloom (Full Spreads + Interactive Plate)</option>
                                <option value="shelf" {{ old('type') == 'shelf' ? 'selected' : '' }}>On The Shelf (Card Grid)</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">Subtitle / Gift Recipient Note</label>
                            <input type="text" name="subtitle" class="form-control" placeholder="e.g. A birthday gift for Mansi / For a sister — a rakhi gift" value="{{ old('subtitle') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Relationship Tag</label>
                            <input type="text" name="relation_tag" class="form-control" placeholder="e.g. For a wife" value="{{ old('relation_tag') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Occasion Tag</label>
                            <input type="text" name="occasion_tag" class="form-control" placeholder="e.g. Birthday / Raksha Bandhan" value="{{ old('occasion_tag') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Spreads Count Badge</label>
                            <input type="text" name="spreads_count" class="form-control" placeholder="e.g. 15 spreads" value="{{ old('spreads_count') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Estimated Read Time Badge</label>
                            <input type="text" name="read_time" class="form-control" placeholder="e.g. 8 min read" value="{{ old('read_time') }}">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">Story Synopsis / Story Description</label>
                            <textarea name="synopsis" class="form-control" rows="4" placeholder="Their first flat had a leaking tap, one steel cup, and a view of every rooftop in the city...">{{ old('synopsis') }}</textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">Cover Plate Caption</label>
                            <input type="text" name="caption" class="form-control" placeholder="e.g. the actual cover — printed, bound, gifted" value="{{ old('caption') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3D Book Interior Pages / Spreads -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 font-weight-bold text-dark"><i class="bi bi-journal-page me-2 text-primary"></i> 3D Reader Interior Spreads (Book Pages)</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Upload Interior Spread Images (Multiple Files)</label>
                        <input type="file" name="pages_files[]" class="form-control" multiple accept="image/*">
                        <small class="form-text text-muted">Select all spread images for this book. Max file size: <strong>5 MB</strong> per file. Recommended dimensions: <strong>1400 × 600 px</strong> or <strong>1600 × 900 px</strong> (Landscape spreads).</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Or JSON Custom Pages Config (Optional Advanced)</label>
                        <textarea name="pages_json_raw" class="form-control font-monospace" rows="4" placeholder='[{"src": "assets/img/book1/s01.webp", "alt": "spread 1"}]'>{{ old('pages_json_raw') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Options & Cover Media -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 font-weight-bold text-dark"><i class="bi bi-image me-2 text-primary"></i> Covers & Media</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Front Cover Image</label>
                        <input type="file" name="cover_image" class="form-control" accept="image/*">
                        <small class="form-text text-muted">Max file size: <strong>5 MB</strong>. Recommended dimensions: <strong>900 × 1273 px</strong> (Portrait 1:1.4 aspect ratio).</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Back Cover Image (Optional)</label>
                        <input type="file" name="back_image" class="form-control" accept="image/*">
                        <small class="form-text text-muted">Max file size: <strong>5 MB</strong>. Recommended dimensions: <strong>900 × 1273 px</strong> (Portrait 1:1.4 aspect ratio).</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Display Order</label>
                        <input type="number" name="order" class="form-control" value="{{ old('order', 1) }}">
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="status" id="statusSwitch" value="1" checked>
                        <label class="form-check-label fw-bold" for="statusSwitch">Published / Active</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100" style="background-color: var(--primary-active); border-color: var(--primary-active);">
                        <i class="bi bi-save me-1"></i> Create Storyloom Book
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
