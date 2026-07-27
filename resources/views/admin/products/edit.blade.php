@extends('layouts.admin')

@section('title', 'Modify Product Details')
@section('page_title', 'Edit Product')

@section('breadcrumbs')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="card border-0 bg-white">
    <div class="card-body p-4">
      <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Edition Name</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Slug</label>
            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $product->slug) }}">
            @error('slug')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-4">
            <label class="form-label fw-semibold">Base Price (INR)</label>
            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" step="0.01" required min="0">
            @error('price')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-4">
            <label class="form-label fw-semibold">Discounted Price (INR, optional)</label>
            <input type="number" name="discount_price" class="form-control @error('discount_price') is-invalid @enderror" value="{{ old('discount_price', $product->discount_price) }}" step="0.01" min="0">
            @error('discount_price')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-4">
            <label class="form-label fw-semibold">Product Category</label>
            <input type="text" name="category" class="form-control @error('category') is-invalid @enderror" value="{{ old('category', $product->category) }}">
            @error('category')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Main Image (Cover/Display)</label>
            <input type="file" name="main_image" class="form-control @error('main_image') is-invalid @enderror">
            @error('main_image')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            
            @if($product->main_image)
              <div class="mt-2 p-1 border rounded bg-light d-inline-block">
                <img src="{{ asset($product->main_image) }}" height="60" alt="">
              </div>
            @endif
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Gallery Images (Appends to current)</label>
            <input type="file" name="gallery_images[]" class="form-control @error('gallery_images') is-invalid @enderror" multiple>
            @error('gallery_images')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            
            @if(!empty($product->gallery_images))
              <div class="mt-2 d-flex flex-wrap gap-2">
                @foreach($product->gallery_images as $img)
                  <div class="border rounded p-1 bg-light">
                    <img src="{{ asset($img) }}" height="32" alt="">
                  </div>
                @endforeach
              </div>
            @endif
          </div>

          <div class="col-md-9">
            <label class="form-label fw-semibold">Short Description / Subtitle</label>
            <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description', $product->description) }}">
            @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-3">
            <label class="form-label fw-semibold">Status</label>
            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
              <option value="1" {{ old('status', $product->status ? '1' : '0') === '1' ? 'selected' : '' }}>Active</option>
              <option value="0" {{ old('status', $product->status ? '1' : '0') === '0' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="mt-4 pt-3 border-top d-flex gap-2">
          <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Save Changes</button>
          <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
@endsection
