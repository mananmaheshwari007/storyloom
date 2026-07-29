@extends('layouts.admin')

@section('title', 'Edit Testimonial')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Testimonial</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.testimonials.index') }}">Testimonials</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Testimonial</li>
        </ol>
    </nav>
</div>

<div class="card shadow-sm max-w-4xl">
    <div class="card-body">
        <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="client_name" class="form-label">Client Name</label>
                <input type="text" class="form-control @error('client_name') is-invalid @enderror" id="client_name" name="client_name" value="{{ old('client_name', $testimonial->client_name) }}" required>
                @error('client_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="designation" class="form-label">Relationship / Designation</label>
                    <input type="text" class="form-control @error('designation') is-invalid @enderror" id="designation" name="designation" value="{{ old('designation', $testimonial->designation) }}" required>
                    @error('designation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="company" class="form-label">Company / Group (Optional)</label>
                    <input type="text" class="form-control @error('company') is-invalid @enderror" id="company" name="company" value="{{ old('company', $testimonial->company) }}">
                </div>
            </div>

            <div class="mb-3">
                <label for="review" class="form-label">Review Quote</label>
                <textarea class="form-control @error('review') is-invalid @enderror" id="review" name="review" rows="5" required>{{ old('review', $testimonial->review) }}</textarea>
                @error('review')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="rating" class="form-label">Star Rating (1 to 5)</label>
                    <select class="form-select @error('rating') is-invalid @enderror" id="rating" name="rating" required>
                        <option value="5" {{ old('rating', $testimonial->rating) == 5 ? 'selected' : '' }}>5 Stars</option>
                        <option value="4" {{ old('rating', $testimonial->rating) == 4 ? 'selected' : '' }}>4 Stars</option>
                        <option value="3" {{ old('rating', $testimonial->rating) == 3 ? 'selected' : '' }}>3 Stars</option>
                        <option value="2" {{ old('rating', $testimonial->rating) == 2 ? 'selected' : '' }}>2 Stars</option>
                        <option value="1" {{ old('rating', $testimonial->rating) == 1 ? 'selected' : '' }}>1 Star</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="active" {{ old('status', $testimonial->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $testimonial->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label for="image_file" class="form-label">Upload New Client Photo (Optional)</label>
                <input type="file" class="form-control @error('image_file') is-invalid @enderror" id="image_file" name="image_file" accept="image/*">
                <div class="form-text">Max file size: <strong>2 MB</strong>. Recommended dimensions: <strong>300 × 300 px</strong> (Square 1:1 avatar format).</div>
                @error('image_file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @if($testimonial->image)
                    <div class="mt-2 text-muted" style="font-size: 0.85rem;">
                        Current Photo: <code>{{ $testimonial->image }}</code>
                        <div class="mt-1 d-flex align-items-center gap-3">
                            <img src="{{ asset($testimonial->image) }}" alt="Preview" height="80" class="border rounded">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="remove_image" name="remove_image">
                                <label class="form-check-label text-danger fw-semibold" for="remove_image">
                                    <i class="bi bi-trash me-1"></i> Remove this photo
                                </label>
                                <div class="form-text">Applied when you save. The testimonial keeps working without a photo.</div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary px-4 py-2"><i class="bi bi-save me-1"></i> Update Testimonial</button>
            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary px-4 py-2 ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
