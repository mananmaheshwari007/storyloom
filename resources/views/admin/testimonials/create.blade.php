@extends('layouts.admin')

@section('title', 'Add New Testimonial')
@section('page_title', 'Create Testimonial')

@section('breadcrumbs')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.testimonials.index') }}">Testimonials</a></li>
      <li class="breadcrumb-item active" aria-current="page">Create</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="card border-0 bg-white">
    <div class="card-body p-4">
      <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Client Name</label>
            <input type="text" name="client_name" class="form-control @error('client_name') is-invalid @enderror" value="{{ old('client_name') }}" required>
            @error('client_name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Designation / Role (e.g. Gifted for Mom, Wife)</label>
            <input type="text" name="designation" class="form-control @error('designation') is-invalid @enderror" value="{{ old('designation') }}" placeholder="e.g. Gifted to her parents, Anniversaries">
            @error('designation')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-4">
            <label class="form-label fw-semibold">Company / Location (optional)</label>
            <input type="text" name="company" class="form-control @error('company') is-invalid @enderror" value="{{ old('company') }}" placeholder="e.g. Mumbai, Bangalore">
            @error('company')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-4">
            <label class="form-label fw-semibold">Rating (1 to 5 Stars)</label>
            <select name="rating" class="form-select @error('rating') is-invalid @enderror" required>
              <option value="5" {{ old('rating', '5') === '5' ? 'selected' : '' }}>5 Stars</option>
              <option value="4" {{ old('rating') === '4' ? 'selected' : '' }}>4 Stars</option>
              <option value="3" {{ old('rating') === '3' ? 'selected' : '' }}>3 Stars</option>
              <option value="2" {{ old('rating') === '2' ? 'selected' : '' }}>2 Stars</option>
              <option value="1" {{ old('rating') === '1' ? 'selected' : '' }}>1 Star</option>
            </select>
            @error('rating')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-4">
            <label class="form-label fw-semibold">Display Status</label>
            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
              <option value="1" {{ old('status', '1') === '1' ? 'selected' : '' }}>Active</option>
              <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-8">
            <label class="form-label fw-semibold">Client Avatar / Photo</label>
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
            @error('image')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-12">
            <label class="form-label fw-semibold">Review / Story details</label>
            <textarea name="review" class="form-control @error('review') is-invalid @enderror" rows="4" required>{{ old('review') }}</textarea>
            @error('review')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="mt-4 pt-3 border-top d-flex gap-2">
          <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Create Testimonial</button>
          <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
@endsection
