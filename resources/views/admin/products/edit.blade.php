@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Product</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
        </ol>
    </nav>
</div>

<div class="card shadow-sm max-w-4xl">
    <div class="card-body">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Product / Package Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $product->slug) }}" required>
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label for="price" class="form-label">Price (₹)</label>
                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="discount_price" class="form-label">Discount Price (₹, Optional)</label>
                    <input type="number" step="0.01" class="form-control @error('discount_price') is-invalid @enderror" id="discount_price" name="discount_price" value="{{ old('discount_price', $product->discount_price) }}">
                    @error('discount_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="category" class="form-label">Category</label>
                    <input type="text" class="form-control @error('category') is-invalid @enderror" id="category" name="category" value="{{ old('category', $product->category) }}">
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="main_image_file" class="form-label">Upload New Cover Image (Optional)</label>
                <input type="file" class="form-control @error('main_image_file') is-invalid @enderror" id="main_image_file" name="main_image_file" accept="image/*">
                <div class="form-text">Max file size: <strong>3 MB</strong>. Recommended dimensions: <strong>1200 × 1200 px</strong> or <strong>1600 × 900 px</strong>.</div>
                @error('main_image_file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @if($product->main_image)
                    <div class="mt-2 text-muted" style="font-size: 0.85rem;">
                        Current Cover: <code>{{ $product->main_image }}</code>
                        <div class="mt-1"><img src="{{ asset($product->main_image) }}" alt="Preview" height="80" class="border rounded"></div>
                    </div>
                @endif
            </div>

            <!-- Current Gallery -->
            @if($product->gallery_images && count($product->gallery_images) > 0)
                <div class="mb-3">
                    <label class="form-label d-block fw-semibold">Current Gallery Images (Check to Remove)</label>
                    <div class="row g-2">
                        @foreach($product->gallery_images as $index => $img)
                            <div class="col-6 col-sm-4 col-md-3">
                                <div class="card h-100 border p-2 position-relative text-center">
                                    <img src="{{ asset($img) }}" alt="Gallery Image" class="img-fluid rounded mb-2" style="max-height: 100px; object-fit: contain;">
                                    <div class="form-check justify-content-center d-flex">
                                        <input class="form-check-input" type="checkbox" name="remove_gallery[]" value="{{ $index }}" id="remove_gallery_{{ $index }}">
                                        <label class="form-check-label small ms-1 text-danger fw-bold" for="remove_gallery_{{ $index }}">Delete</label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="mb-3">
                <label for="gallery_files" class="form-label">Upload Additional Gallery Images (Select Multiple)</label>
                <input type="file" class="form-control @error('gallery_files') is-invalid @enderror" id="gallery_files" name="gallery_files[]" accept="image/*" multiple>
                <div class="form-text">Max file size: <strong>3 MB</strong> per file. Recommended dimensions: <strong>1600 × 900 px</strong> or <strong>1200 × 1200 px</strong>.</div>
                @error('gallery_files')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="status" class="form-label">Status</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="draft" {{ old('status', $product->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status', $product->status) === 'published' ? 'selected' : '' }}>Published</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary px-4 py-2"><i class="bi bi-save me-1"></i> Update Product</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary px-4 py-2 ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
