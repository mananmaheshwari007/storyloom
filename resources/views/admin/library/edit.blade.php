@extends('layouts.admin')

@section('title', 'Edit Storyloom Book')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800" style="font-family: var(--font-family-title); font-weight: 700;">Edit Book: {{ $book->title }}</h1>
        <p class="text-muted small mb-0">Modify book metadata, covers, and 3D reader pages.</p>
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

<form action="{{ route('admin.library.update', $book->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

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
                            <input type="text" name="title" class="form-control" value="{{ old('title', $book->title) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Display Mode <span class="text-danger">*</span></label>
                            <select name="type" class="form-select" required>
                                <option value="featured" {{ old('type', $book->type) == 'featured' ? 'selected' : '' }}>Featured Storyloom (Full Spreads + Interactive Plate)</option>
                                <option value="shelf" {{ old('type', $book->type) == 'shelf' ? 'selected' : '' }}>On The Shelf (Card Grid)</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">Subtitle / Gift Recipient Note</label>
                            <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $book->subtitle) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Relationship Tag</label>
                            <input type="text" name="relation_tag" class="form-control" value="{{ old('relation_tag', $book->relation_tag) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Occasion Tag</label>
                            <input type="text" name="occasion_tag" class="form-control" value="{{ old('occasion_tag', $book->occasion_tag) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Spreads Count Badge</label>
                            <input type="text" name="spreads_count" class="form-control" value="{{ old('spreads_count', $book->spreads_count) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Estimated Read Time Badge</label>
                            <input type="text" name="read_time" class="form-control" value="{{ old('read_time', $book->read_time) }}">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">Story Synopsis / Story Description</label>
                            <textarea name="synopsis" class="form-control" rows="4">{{ old('synopsis', $book->synopsis) }}</textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">Cover Plate Caption</label>
                            <input type="text" name="caption" class="form-control" value="{{ old('caption', $book->caption) }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3D Book Interior Pages / Spreads -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 font-weight-bold text-dark"><i class="bi bi-journal-page me-2 text-primary"></i> 3D Reader Interior Spreads (Book Pages)</h5>
                    <span class="badge bg-soft-primary text-primary">{{ is_array($book->pages_json) ? count($book->pages_json) : 0 }} Spreads Active</span>
                </div>
                <div class="card-body">
                    @if(is_array($book->pages_json) && count($book->pages_json) > 0)
                        <label class="form-label fw-bold mb-2">Current Interior Spreads:</label>
                        <div class="d-flex flex-wrap gap-2 mb-3 p-2 bg-light rounded" style="max-height: 160px; overflow-y: auto;">
                            @foreach($book->pages_json as $idx => $p)
                                <div class="position-relative">
                                    <img src="{{ asset($p['src']) }}" alt="Page {{ $idx+1 }}" style="height: 60px; width: 85px; object-fit: cover; border-radius: 4px; border: 1px solid #cbd5e1;">
                                    <span class="position-absolute bottom-0 end-0 bg-dark text-white px-1 small" style="font-size: 10px; border-radius: 2px;">{{ $idx + 1 }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-bold">Replace / Upload New Interior Spread Images (Multiple Files)</label>
                        <input type="file" name="pages_files[]" class="form-control" multiple accept="image/*">
                        <small class="form-text text-muted">Uploading files will replace existing interior pages. Max file size: <strong>5 MB</strong> per file. Recommended dimensions: <strong>1400 × 600 px</strong> or <strong>1600 × 900 px</strong> (Landscape spreads).</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Or JSON Custom Pages Config (Raw JSON Data)</label>
                        <textarea name="pages_json_raw" class="form-control font-monospace" rows="5">{{ old('pages_json_raw', json_encode($book->pages_json, JSON_PRETTY_PRINT)) }}</textarea>
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
                        @if($book->cover_image)
                            <div class="mb-2 text-center">
                                <img src="{{ asset($book->cover_image) }}" alt="Cover" class="img-thumbnail" style="max-height: 140px;">
                            </div>
                        @endif
                        <input type="file" name="cover_image" class="form-control" accept="image/*">
                        <small class="form-text text-muted">Max file size: <strong>5 MB</strong>. Recommended dimensions: <strong>900 × 1273 px</strong> (Portrait 1:1.4 aspect ratio).</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Back Cover Image</label>
                        @if($book->back_image)
                            <div class="mb-2 text-center">
                                <img src="{{ asset($book->back_image) }}" alt="Back Cover" class="img-thumbnail" style="max-height: 140px;">
                            </div>
                        @endif
                        <input type="file" name="back_image" class="form-control" accept="image/*">
                        <small class="form-text text-muted">Max file size: <strong>5 MB</strong>. Recommended dimensions: <strong>900 × 1273 px</strong> (Portrait 1:1.4 aspect ratio).</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Display Order</label>
                        <input type="number" name="order" class="form-control" value="{{ old('order', $book->order) }}">
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="status" id="statusSwitch" value="1" {{ old('status', $book->status) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="statusSwitch">Published / Active</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100" style="background-color: var(--primary-active); border-color: var(--primary-active);">
                        <i class="bi bi-save me-1"></i> Save Book Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
