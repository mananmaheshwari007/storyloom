@extends('layouts.admin')

@section('title', 'Modify Team Profile')
@section('page_title', 'Edit Team Member')

@section('breadcrumbs')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.team.index') }}">Team Members</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="card border-0 bg-white">
    <div class="card-body p-4">
      <form action="{{ route('admin.team.update', $team->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Full Name</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $team->name) }}" required>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Designation / Role</label>
            <input type="text" name="designation" class="form-control @error('designation') is-invalid @enderror" value="{{ old('designation', $team->designation) }}" required>
            @error('designation')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-8">
            <label class="form-label fw-semibold">Profile Photo / Avatar</label>
            <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
            @error('photo')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            
            @if($team->photo)
              <div class="mt-2 p-1 border rounded bg-light d-inline-block">
                <img src="{{ asset($team->photo) }}" height="50" class="rounded" alt="">
              </div>
            @endif
          </div>

          <div class="col-md-4">
            <label class="form-label fw-semibold">Display Status</label>
            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
              <option value="1" {{ old('status', $team->status ? '1' : '0') === '1' ? 'selected' : '' }}>Active</option>
              <option value="0" {{ old('status', $team->status ? '1' : '0') === '0' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Social Links -->
          <div class="col-12 mt-4">
            <h5 class="fw-bold border-bottom pb-2 mb-3">Social Profiles (URLs, optional)</h5>
            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label fw-semibold">Instagram Link</label>
                <input type="text" name="social_links[instagram]" class="form-control" placeholder="https://instagram.com/username" value="{{ $team->social_links['instagram'] ?? '' }}">
              </div>
              <div class="col-md-4">
                <label class="form-label fw-semibold">LinkedIn Link</label>
                <input type="text" name="social_links[linkedin]" class="form-control" placeholder="https://linkedin.com/in/username" value="{{ $team->social_links['linkedin'] ?? '' }}">
              </div>
              <div class="col-md-4">
                <label class="form-label fw-semibold">Twitter / X Link</label>
                <input type="text" name="social_links[twitter]" class="form-control" placeholder="https://x.com/username" value="{{ $team->social_links['twitter'] ?? '' }}">
              </div>
            </div>
          </div>

          <div class="col-12 mt-3">
            <label class="form-label fw-semibold">Short bio / Description</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $team->description) }}</textarea>
            @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="mt-4 pt-3 border-top d-flex gap-2">
          <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Save Changes</button>
          <a href="{{ route('admin.team.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
@endsection
