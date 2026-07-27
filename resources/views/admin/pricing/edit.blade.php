@extends('layouts.admin')

@section('title', 'Modify Pricing Plan')
@section('page_title', 'Edit Pricing Plan')

@section('breadcrumbs')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.pricing.index') }}">Pricing Plans</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="card border-0 bg-white">
    <div class="card-body p-4">
      <form action="{{ route('admin.pricing.update', $pricing->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Plan Name</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $pricing->name) }}" required>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-3">
            <label class="form-label fw-semibold">Base Price (INR)</label>
            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $pricing->price) }}" required min="0">
            @error('price')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-3">
            <label class="form-label fw-semibold">Duration Text</label>
            <input type="text" name="duration" class="form-control @error('duration') is-invalid @enderror" value="{{ old('duration', $pricing->duration) }}" required>
            @error('duration')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">CTA Button Text (optional)</label>
            <input type="text" name="button_text" class="form-control @error('button_text') is-invalid @enderror" value="{{ old('button_text', $pricing->button_text) }}">
            @error('button_text')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">CTA Button URL (optional)</label>
            <input type="text" name="button_url" class="form-control @error('button_url') is-invalid @enderror" value="{{ old('button_url', $pricing->button_url) }}">
            @error('button_url')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Popular / Featured Badge</label>
            <select name="popular" class="form-select @error('popular') is-invalid @enderror" required>
              <option value="0" {{ old('popular', $pricing->popular ? '1' : '0') === '0' ? 'selected' : '' }}>Standard Plan</option>
              <option value="1" {{ old('popular', $pricing->popular ? '1' : '0') === '1' ? 'selected' : '' }}>Popular (Highlighted)</option>
            </select>
            @error('popular')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Status</label>
            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
              <option value="1" {{ old('status', $pricing->status ? '1' : '0') === '1' ? 'selected' : '' }}>Active</option>
              <option value="0" {{ old('status', $pricing->status ? '1' : '0') === '0' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Features Section -->
          <div class="col-12 mt-4">
            <h5 class="fw-bold border-bottom pb-2 mb-3">Plan Features</h5>
            <div id="features-container">
              @if(!empty($pricing->features))
                @foreach($pricing->features as $feature)
                  <div class="row g-2 mb-2 feature-row">
                    <div class="col-10">
                      <input type="text" name="features[]" class="form-control form-control-sm" placeholder="Feature text" value="{{ $feature }}" required>
                    </div>
                    <div class="col-2">
                      <button type="button" class="btn btn-sm btn-danger w-100 remove-feature-btn"><i class="bi bi-trash"></i></button>
                    </div>
                  </div>
                @endforeach
              @endif
            </div>
            <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-feature-btn"><i class="bi bi-plus-circle me-1"></i>Add Feature Line</button>
          </div>
        </div>

        <div class="mt-4 pt-3 border-top d-flex gap-2">
          <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Save Changes</button>
          <a href="{{ route('admin.pricing.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  // Add Feature
  document.getElementById('add-feature-btn').addEventListener('click', function () {
    var container = document.getElementById('features-container');
    var html = `
      <div class="row g-2 mb-2 feature-row">
        <div class="col-10">
          <input type="text" name="features[]" class="form-control form-control-sm" placeholder="Feature detail text" required>
        </div>
        <div class="col-2">
          <button type="button" class="btn btn-sm btn-danger w-100 remove-feature-btn"><i class="bi bi-trash"></i></button>
        </div>
      </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
  });

  // Remove feature
  document.addEventListener('click', function (e) {
    if (e.target.closest('.remove-feature-btn')) {
      e.target.closest('.feature-row').remove();
    }
  });
});
</script>
@endpush
