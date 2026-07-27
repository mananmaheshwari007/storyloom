@extends('layouts.admin')

@section('title', 'Manage About Section')
@section('page_title', 'About Section')

@section('breadcrumbs')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">About Section</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="card border-0 bg-white">
    <div class="card-body p-4">
      <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-3">
          <!-- Heading -->
          <div class="col-12">
            <label class="form-label fw-semibold">Heading</label>
            <input type="text" name="heading" class="form-control @error('heading') is-invalid @enderror" value="{{ old('heading', $about->heading) }}" required>
            @error('heading')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Description -->
          <div class="col-12">
            <label class="form-label fw-semibold">Description Text</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5" required>{{ old('description', $about->description) }}</textarea>
            @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Experience Years & Image -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Years of Experience</label>
            <input type="number" name="experience" class="form-control @error('experience') is-invalid @enderror" value="{{ old('experience', $about->experience) }}" required min="0">
            @error('experience')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">About Side Graphic / Photo</label>
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
            @error('image')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            
            @if($about->image)
              <div class="mt-2 p-2 border rounded bg-light d-inline-block">
                <img src="{{ asset($about->image) }}" height="100" alt="About image preview">
              </div>
            @endif
          </div>

          <!-- Skills Section -->
          <div class="col-12 col-lg-6 mt-4">
            <h5 class="fw-bold border-bottom pb-2 mb-3">Craftsmanship Skills</h5>
            <div id="skills-container">
              @if(!empty($about->skills))
                @foreach($about->skills as $index => $skill)
                  <div class="row g-2 mb-2 skill-row">
                    <div class="col-7">
                      <input type="text" name="skills[{{ $index }}][name]" class="form-control form-control-sm" placeholder="Skill name" value="{{ $skill['name'] }}" required>
                    </div>
                    <div class="col-3">
                      <input type="number" name="skills[{{ $index }}][percentage]" class="form-control form-control-sm" placeholder="%" value="{{ $skill['percentage'] }}" min="0" max="100" required>
                    </div>
                    <div class="col-2">
                      <button type="button" class="btn btn-sm btn-danger w-100 remove-skill-btn"><i class="bi bi-trash"></i></button>
                    </div>
                  </div>
                @endforeach
              @endif
            </div>
            <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-skill-btn"><i class="bi bi-plus-circle me-1"></i>Add Skill Row</button>
          </div>

          <!-- Statistics Section -->
          <div class="col-12 col-lg-6 mt-4">
            <h5 class="fw-bold border-bottom pb-2 mb-3">Statistics & Numbers</h5>
            <div id="stats-container">
              @if(!empty($about->statistics))
                @foreach($about->statistics as $index => $stat)
                  <div class="row g-2 mb-2 stat-row">
                    <div class="col-4">
                      <input type="text" name="statistics[{{ $index }}][value]" class="form-control form-control-sm" placeholder="e.g. 500+ or 100%" value="{{ $stat['value'] }}" required>
                    </div>
                    <div class="col-6">
                      <input type="text" name="statistics[{{ $index }}][label]" class="form-control form-control-sm" placeholder="Label / Description" value="{{ $stat['label'] }}" required>
                    </div>
                    <div class="col-2">
                      <button type="button" class="btn btn-sm btn-danger w-100 remove-stat-btn"><i class="bi bi-trash"></i></button>
                    </div>
                  </div>
                @endforeach
              @endif
            </div>
            <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-stat-btn"><i class="bi bi-plus-circle me-1"></i>Add Stat Row</button>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="mt-4 pt-3 border-top">
          <button type="submit" class="btn btn-primary px-4 py-2"><i class="bi bi-save me-2"></i>Save About Details</button>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  var skillIndex = {{ count($about->skills ?? []) }};
  var statIndex = {{ count($about->statistics ?? []) }};

  // Add Skill
  document.getElementById('add-skill-btn').addEventListener('click', function () {
    var container = document.getElementById('skills-container');
    var html = `
      <div class="row g-2 mb-2 skill-row">
        <div class="col-7">
          <input type="text" name="skills[${skillIndex}][name]" class="form-control form-control-sm" placeholder="Skill name" required>
        </div>
        <div class="col-3">
          <input type="number" name="skills[${skillIndex}][percentage]" class="form-control form-control-sm" placeholder="%" min="0" max="100" required>
        </div>
        <div class="col-2">
          <button type="button" class="btn btn-sm btn-danger w-100 remove-skill-btn"><i class="bi bi-trash"></i></button>
        </div>
      </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    skillIndex++;
  });

  // Add Stat
  document.getElementById('add-stat-btn').addEventListener('click', function () {
    var container = document.getElementById('stats-container');
    var html = `
      <div class="row g-2 mb-2 stat-row">
        <div class="col-4">
          <input type="text" name="statistics[${statIndex}][value]" class="form-control form-control-sm" placeholder="e.g. 500+ or 100%" required>
        </div>
        <div class="col-6">
          <input type="text" name="statistics[${statIndex}][label]" class="form-control form-control-sm" placeholder="Label / Description" required>
        </div>
        <div class="col-2">
          <button type="button" class="btn btn-sm btn-danger w-100 remove-stat-btn"><i class="bi bi-trash"></i></button>
        </div>
      </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    statIndex++;
  });

  // Remove rows (Event delegation)
  document.addEventListener('click', function (e) {
    if (e.target.closest('.remove-skill-btn')) {
      e.target.closest('.skill-row').remove();
    }
    if (e.target.closest('.remove-stat-btn')) {
      e.target.closest('.stat-row').remove();
    }
  });
});
</script>
@endpush
