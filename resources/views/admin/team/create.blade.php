@extends('layouts.admin')

@section('title', 'Add Team Member')

@section('content')
<div class="page-header">
    <h1 class="page-title">Add Team Member</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.team.index') }}">Team</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Member</li>
        </ol>
    </nav>
</div>

<div class="card shadow-sm max-w-4xl">
    <div class="card-body">
        <form action="{{ route('admin.team.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="designation" class="form-label">Designation / Role</label>
                    <input type="text" class="form-control @error('designation') is-invalid @enderror" id="designation" name="designation" value="{{ old('designation') }}" required>
                    @error('designation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Short Biography / Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="instagram" class="form-label">Instagram Profile URL</label>
                    <input type="url" class="form-control" id="instagram" name="social_links[instagram]" value="{{ old('social_links.instagram') }}">
                </div>
                <div class="col-md-6">
                    <label for="twitter" class="form-label">Twitter / X Profile URL</label>
                    <input type="url" class="form-control" id="twitter" name="social_links[twitter]" value="{{ old('social_links.twitter') }}">
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="photo_file" class="form-label">Upload Profile Photo</label>
                    <input type="file" class="form-control @error('photo_file') is-invalid @enderror" id="photo_file" name="photo_file" accept="image/*">
                    <div class="form-text">Max file size: <strong>2 MB</strong>. Recommended dimensions: <strong>600 × 600 px</strong> (Square 1:1 format).</div>
                    @error('photo_file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary px-4 py-2"><i class="bi bi-save me-1"></i> Save Team Member</button>
            <a href="{{ route('admin.team.index') }}" class="btn btn-outline-secondary px-4 py-2 ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
