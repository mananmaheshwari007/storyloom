@extends('layouts.admin')

@section('title', 'Modify Keepsake Book')
@section('page_title', 'Edit Project Book')

@section('breadcrumbs')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}">Projects</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="card border-0 bg-white">
    <div class="card-body p-4">
      <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-3">
          <!-- Title -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Book Title</label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $project->title) }}" required>
            @error('title')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Slug -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Slug (URL path)</label>
            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $project->slug) }}">
            @error('slug')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Category -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Relationship Category</label>
            <input type="text" name="category" class="form-control @error('category') is-invalid @enderror" value="{{ old('category', $project->category) }}" placeholder="e.g. For Mom, For Spouse, For Sister" required>
            @error('category')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Client name -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Gifter / Client Name</label>
            <input type="text" name="client_name" class="form-control @error('client_name') is-invalid @enderror" value="{{ old('client_name', $project->client_name) }}" placeholder="e.g. Manan, Rohit">
            @error('client_name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Completion Date -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Completion Date</label>
            <input type="date" name="completion_date" class="form-control @error('completion_date') is-invalid @enderror" value="{{ old('completion_date', $project->completion_date ? $project->completion_date->format('Y-m-d') : '') }}">
            @error('completion_date')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Technologies used -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Medium &amp; Materials (comma separated)</label>
            <input type="text" name="technologies_used" class="form-control @error('technologies_used') is-invalid @enderror" value="{{ old('technologies_used', is_array($project->technologies_used) ? implode(', ', $project->technologies_used) : $project->technologies_used) }}" placeholder="e.g. Watercolor, Archival Paper, Hardbound Cover">
            @error('technologies_used')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Main Image (Cover) -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Front Cover Image</label>
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
            @error('image')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            
            @if($project->image)
              <div class="mt-2 p-1 border rounded bg-light d-inline-block">
                <img src="{{ asset($project->image) }}" height="100" class="rounded" alt="">
              </div>
            @endif
          </div>

          <!-- Gallery Images (Spreads) -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Inside Page Spreads (Appends to current)</label>
            <input type="file" name="gallery[]" class="form-control @error('gallery') is-invalid @enderror" multiple>
            @error('gallery')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            
            @if(!empty($project->gallery))
              <div class="mt-2 d-flex flex-wrap gap-2">
                @foreach($project->gallery as $img)
                  <div class="border rounded p-1 bg-light position-relative">
                    <img src="{{ asset($img['src'] ?? '') }}" height="40" class="rounded" alt="">
                  </div>
                @endforeach
              </div>
            @endif
          </div>

          <!-- Description -->
          <div class="col-12">
            <label class="form-label fw-semibold">Book Synopsis / Story description</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $project->description) }}</textarea>
            @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Status settings -->
          <div class="col-md-4">
            <label class="form-label fw-semibold">Featured on Homepage</label>
            <select name="featured" class="form-select @error('featured') is-invalid @enderror" required>
              <option value="0" {{ old('featured', $project->featured ? '1' : '0') === '0' ? 'selected' : '' }}>No</option>
              <option value="1" {{ old('featured', $project->featured ? '1' : '0') === '1' ? 'selected' : '' }}>Yes</option>
            </select>
            @error('featured')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-4">
            <label class="form-label fw-semibold">Display Status</label>
            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
              <option value="1" {{ old('status', $project->status ? '1' : '0') === '1' ? 'selected' : '' }}>Active</option>
              <option value="0" {{ old('status', $project->status ? '1' : '0') === '0' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="mt-4 pt-3 border-top d-flex gap-2">
          <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Save Changes</button>
          <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
@endsection
