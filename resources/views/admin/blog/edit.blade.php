@extends('layouts.admin')

@section('title', 'Modify Blog Post')
@section('page_title', 'Edit Post')

@section('breadcrumbs')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.blog.index') }}">Blog Posts</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="card border-0 bg-white">
    <div class="card-body p-4">
      <form action="{{ route('admin.blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-3">
          <!-- Title -->
          <div class="col-md-8">
            <label class="form-label fw-semibold">Article Title</label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $blog->title) }}" required>
            @error('title')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Slug -->
          <div class="col-md-4">
            <label class="form-label fw-semibold">Slug</label>
            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $blog->slug) }}">
            @error('slug')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Short Description -->
          <div class="col-12">
            <label class="form-label fw-semibold">Short Summary / Excerpt</label>
            <input type="text" name="short_description" class="form-control @error('short_description') is-invalid @enderror" value="{{ old('short_description', $blog->short_description) }}" placeholder="A brief hook sentence for the blog listing page">
            @error('short_description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Main Image -->
          <div class="col-md-8">
            <label class="form-label fw-semibold">Featured Article Image</label>
            <input type="file" name="featured_image" class="form-control @error('featured_image') is-invalid @enderror">
            @error('featured_image')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            
            @if($blog->featured_image)
              <div class="mt-2 p-1 border rounded bg-light d-inline-block">
                <img src="{{ asset($blog->featured_image) }}" height="60" class="rounded" alt="">
              </div>
            @endif
          </div>

          <!-- Status -->
          <div class="col-md-4">
            <label class="form-label fw-semibold">Publish Status</label>
            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
              <option value="1" {{ old('status', $blog->status ? '1' : '0') === '1' ? 'selected' : '' }}>Published</option>
              <option value="0" {{ old('status', $blog->status ? '1' : '0') === '0' ? 'selected' : '' }}>Draft</option>
            </select>
            @error('status')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Content Body -->
          <div class="col-12">
            <label class="form-label fw-semibold">Body Content (HTML/Paragraphs supported)</label>
            <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="12" required>{{ old('content', $blog->content) }}</textarea>
            @error('content')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- SEO Meta Data Overrides -->
          <div class="col-12 mt-4">
            <h5 class="fw-bold border-bottom pb-2 mb-3">SEO Override Tags (Optional)</h5>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">SEO Meta Title</label>
                <input type="text" name="meta_title" class="form-control" placeholder="Defaults to Article Title" value="{{ old('meta_title', $blog->meta_title) }}">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">SEO Keywords</label>
                <input type="text" name="keywords" class="form-control" placeholder="e.g. storyloom, memory book, family illustration" value="{{ old('keywords', $blog->keywords) }}">
              </div>
              <div class="col-12">
                <label class="form-label fw-semibold">SEO Meta Description</label>
                <textarea name="meta_description" class="form-control" rows="2" placeholder="Defaults to Short Summary">{{ old('meta_description', $blog->meta_description) }}</textarea>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-4 pt-3 border-top d-flex gap-2">
          <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Save Changes</button>
          <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
@endsection
