@extends('layouts.admin')

@section('title', 'Manage Hero Section')
@section('page_title', 'Hero Section')

@section('breadcrumbs')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Hero Section</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="card border-0 bg-white">
    <div class="card-body p-4">
      <form action="{{ route('admin.hero.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-3">
          <!-- Heading -->
          <div class="col-12">
            <label class="form-label fw-semibold">Heading (HTML supported, use &lt;em&gt;&lt;/em&gt; for highlight color)</label>
            <input type="text" name="heading" class="form-control @error('heading') is-invalid @enderror" value="{{ old('heading', $hero->heading) }}" required>
            @error('heading')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Subheading -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Subheading / Eyebrow Text</label>
            <input type="text" name="subheading" class="form-control @error('subheading') is-invalid @enderror" value="{{ old('subheading', $hero->subheading) }}">
            @error('subheading')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Description -->
          <div class="col-12">
            <label class="form-label fw-semibold">Description Text</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $hero->description) }}</textarea>
            @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Button Text -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Button Text</label>
            <input type="text" name="button_text" class="form-control @error('button_text') is-invalid @enderror" value="{{ old('button_text', $hero->button_text) }}">
            @error('button_text')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Button Link -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Button Link / Redirect URL</label>
            <input type="text" name="button_link" class="form-control @error('button_link') is-invalid @enderror" value="{{ old('button_link', $hero->button_link) }}">
            @error('button_link')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Background Image -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Hero Background Image</label>
            <input type="file" name="bg_image" class="form-control @error('bg_image') is-invalid @enderror">
            @error('bg_image')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            
            @if($hero->bg_image)
              <div class="mt-2 p-2 border rounded bg-light d-inline-block">
                <img src="{{ asset($hero->bg_image) }}" height="100" alt="Background image preview">
              </div>
            @endif
          </div>
        </div>

        <!-- Submit Button -->
        <div class="mt-4 pt-3 border-top">
          <button type="submit" class="btn btn-primary px-4 py-2"><i class="bi bi-save me-2"></i>Save Hero Details</button>
        </div>
      </form>
    </div>
  </div>
@endsection
