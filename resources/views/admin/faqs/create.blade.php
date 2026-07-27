@extends('layouts.admin')

@section('title', 'Add New FAQ')
@section('page_title', 'Create FAQ')

@section('breadcrumbs')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.faqs.index') }}">FAQs</a></li>
      <li class="breadcrumb-item active" aria-current="page">Create</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="card border-0 bg-white">
    <div class="card-body p-4">
      <form action="{{ route('admin.faqs.store') }}" method="POST">
        @csrf

        <div class="row g-3">
          <div class="col-12">
            <label class="form-label fw-semibold">Question</label>
            <input type="text" name="question" class="form-control @error('question') is-invalid @enderror" value="{{ old('question') }}" required>
            @error('question')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-4">
            <label class="form-label fw-semibold">Category Group</label>
            <select name="category" class="form-select @error('category') is-invalid @enderror" required>
              <option value="general" {{ old('category') === 'general' ? 'selected' : '' }}>General (Writing &amp; Illustrating)</option>
              <option value="shipping" {{ old('category') === 'shipping' ? 'selected' : '' }}>Shipping &amp; Timelines</option>
              <option value="refunds" {{ old('category') === 'refunds' ? 'selected' : '' }}>Cancellations &amp; Corrections</option>
            </select>
            @error('category')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-4">
            <label class="form-label fw-semibold">Display Order</label>
            <input type="number" name="display_order" class="form-control @error('display_order') is-invalid @enderror" value="{{ old('display_order', 0) }}" required min="0">
            @error('display_order')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-4">
            <label class="form-label fw-semibold">Status</label>
            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
              <option value="1" {{ old('status', '1') === '1' ? 'selected' : '' }}>Active</option>
              <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-12">
            <label class="form-label fw-semibold">Answer Content</label>
            <textarea name="answer" class="form-control @error('answer') is-invalid @enderror" rows="4" required>{{ old('answer') }}</textarea>
            @error('answer')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="mt-4 pt-3 border-top d-flex gap-2">
          <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Create FAQ</button>
          <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
@endsection
