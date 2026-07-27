@extends('layouts.admin')

@section('title', 'Add Portfolio Item')

@section('content')
<div class="page-header">
    <h1 class="page-title">Add Portfolio Item</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.portfolio.index') }}">Portfolio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Item</li>
        </ol>
    </nav>
</div>

<div class="card shadow-sm max-w-4xl">
    <div class="card-body">
        <form action="{{ route('admin.portfolio.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label for="title" class="form-label">Portfolio Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Category (e.g. For Wife, For Sister, anniversaries)</label>
                <input type="text" class="form-control @error('category') is-invalid @enderror" id="category" name="category" value="{{ old('category') }}">
                @error('category')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="thumbnail_file" class="form-label">Upload Thumbnail Image</label>
                <input type="file" class="form-control @error('thumbnail_file') is-invalid @enderror" id="thumbnail_file" name="thumbnail_file" accept="image/*">
                <div class="form-text">Max file size: <strong>3 MB</strong>. Recommended dimensions: <strong>1100 × 1469 px</strong> (Portrait 3:4 aspect ratio).</div>
                @error('thumbnail_file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="gallery_files" class="form-label">Upload Additional Gallery Images (Select Multiple)</label>
                <input type="file" class="form-control @error('gallery_files') is-invalid @enderror" id="gallery_files" name="gallery_files[]" accept="image/*" multiple>
                <div class="form-text">Max file size: <strong>3 MB</strong> per file. Recommended dimensions: <strong>1100 × 1469 px</strong> or <strong>1600 × 900 px</strong>.</div>
                @error('gallery_files')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="status" class="form-label">Status</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary px-4 py-2"><i class="bi bi-save me-1"></i> Save Portfolio Item</button>
            <a href="{{ route('admin.portfolio.index') }}" class="btn btn-outline-secondary px-4 py-2 ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
