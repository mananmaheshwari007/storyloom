@extends('layouts.admin')

@section('title', '7. About Page Manager')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="page-title h3 mb-1"><i class="bi bi-file-person me-2 text-primary"></i> 7. About Page Manager</h1>
        <p class="text-muted small mb-0">Manage story, mission statement, philosophy, statistics, and founder artwork on the About page.</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">About Section</li>
        </ol>
    </nav>
</div>

<form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card shadow-sm border-0 mb-4 bg-white sticky-top" style="top: 80px; z-index: 100;">
        <div class="card-body py-2.5 px-3 d-flex align-items-center justify-content-between">
            <span class="fw-bold text-dark small"><i class="bi bi-sliders me-1.5 text-primary"></i> About Page CMS Controls</span>
            <button type="submit" class="btn btn-sm btn-primary fw-bold px-4 py-1.5">
                <i class="bi bi-save me-1.5"></i> Save About Page Changes
            </button>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <!-- About Content -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-fonts me-2 text-primary"></i> Main Brand Story</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="heading" class="form-label fw-bold">Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                        <input type="text" class="form-control" id="heading" name="heading" value="{{ old('heading', $about->heading) }}" required>
                        <div class="form-text">Use <code>&lt;em&gt;text&lt;/em&gt;</code> for the custom script font accent or <code>&lt;br&gt;</code> for line breaks.</div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Main Description Paragraphs</label>
                        <textarea class="form-control" id="description" name="description" rows="6" required>{{ old('description', $about->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="experience_years" class="form-label fw-bold">Years of Experience / Activity</label>
                        <input type="number" class="form-control" id="experience_years" name="experience_years" value="{{ old('experience_years', $about->experience_years) }}">
                    </div>
                </div>
            </div>

            <!-- Stats and Skills -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-bar-chart me-2 text-success"></i> Skills & Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label fw-bold d-block">Statistics Counter Cards (3 items)</label>
                        <div class="row g-3">
                            @for($i = 0; $i < 3; $i++)
                                @php
                                    $statVal = isset($about->statistics[$i]) ? $about->statistics[$i] : ['number' => '', 'label' => ''];
                                @endphp
                                <div class="col-md-4">
                                    <div class="p-3 border rounded bg-light">
                                        <div class="mb-2">
                                            <label class="form-label small fw-bold">Stat #{{ $i + 1 }} Number (e.g. 1000+)</label>
                                            <input type="text" class="form-control form-control-sm" name="statistics[{{ $i }}][number]" value="{{ $statVal['number'] }}">
                                        </div>
                                        <div>
                                            <label class="form-label small fw-bold">Stat #{{ $i + 1 }} Label (e.g. Stories Painted)</label>
                                            <input type="text" class="form-control form-control-sm" name="statistics[{{ $i }}][label]" value="{{ $statVal['label'] }}">
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Company Skills / Pillars List</label>
                        <div class="row g-2">
                            @for($s = 0; $s < 4; $s++)
                                @php
                                    $skillVal = isset($about->skills[$s]) ? $about->skills[$s] : '';
                                @endphp
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="skills[{{ $s }}]" value="{{ $skillVal }}" placeholder="Pillar #{{ $s + 1 }}">
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Image Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-image me-2 text-warning"></i> Featured Artwork Image</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold">Artwork Image Path</label>
                        <input type="text" class="form-control mb-2" id="image_path" name="image" value="{{ old('image', $about->image) }}" placeholder="assets/img/spread-home-morning.webp">
                        
                        <div class="mb-2 text-center p-2 bg-light border rounded">
                            <img id="about_img_preview" src="{{ asset($about->image ?: 'assets/img/spread-home-morning.webp') }}" alt="About Preview" class="img-fluid rounded shadow-sm" style="max-height: 160px; object-fit: cover;">
                        </div>

                        <label class="form-label small fw-bold mt-2">Upload New Image File</label>
                        <input type="file" class="form-control form-control-sm" name="image_file" id="image_file" accept="image/jpeg,image/png,image/webp,image/avif" onchange="previewFileImage(this, 'about_img_preview')">
                        <div class="form-text mt-1" style="font-size: 0.76rem;">
                            <span class="badge bg-secondary me-1">Recommended Specs</span> 1200 &times; 800 px &bull; WEBP or PNG &bull; Max 3 MB
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
function previewFileImage(input, previewId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(previewId).src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
