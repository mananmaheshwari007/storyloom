@extends('layouts.admin')

@section('title', '7. About Page Manager')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="page-title h3 mb-1"><i class="bi bi-file-person me-2 text-primary"></i> 7. About Page Manager</h1>
        <p class="text-muted small mb-0">Manage story, hero intro, brand philosophy, values cards, founder artwork, and final CTA on the About page.</p>
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
            <!-- Hero Header Section -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-fonts me-2 text-primary"></i> 1. Page Hero Header</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Hero Eyebrow</label>
                        <input type="text" class="form-control" name="about_hero_eyebrow" value="{{ setting('about_hero_eyebrow', 'ABOUT STORYLOOM') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Hero Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                        <input type="text" class="form-control" name="about_hero_heading" value="{{ setting('about_hero_heading', 'Every story is a <em>keepsake.</em>') }}">
                        <div class="form-text">Use <code>&lt;em&gt;text&lt;/em&gt;</code> for the custom script font accent.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Hero Lede / Intro Text</label>
                        <textarea class="form-control" name="about_hero_lede" rows="3">{{ setting('about_hero_lede', 'Storyloom was born from a simple belief: the moments that shaped your life deserve more than a fading photo or a forgotten text message.') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- About Content -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-journal-text me-2 text-primary"></i> 2. Main Brand Story</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="heading" class="form-label fw-bold">Story Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                        <input type="text" class="form-control" id="heading" name="heading" value="{{ old('heading', $about->heading) }}" required>
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

            <!-- Core Values / Philosophy -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-heart me-2 text-danger"></i> 3. Core Values & Brand Pillars</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3 p-3 bg-light rounded border">
                        <label class="form-label fw-bold text-dark mb-1">Value 1 Title & Description</label>
                        <input type="text" class="form-control mb-2" name="about_val1_title" value="{{ setting('about_val1_title', 'Crafted One-by-One') }}">
                        <textarea class="form-control form-control-sm" name="about_val1_desc" rows="2">{{ setting('about_val1_desc', 'No templates. Every story is painted around your real people and places.') }}</textarea>
                    </div>
                    <div class="mb-3 p-3 bg-light rounded border">
                        <label class="form-label fw-bold text-dark mb-1">Value 2 Title & Description</label>
                        <input type="text" class="form-control mb-2" name="about_val2_title" value="{{ setting('about_val2_title', 'Archival Quality') }}">
                        <textarea class="form-control form-control-sm" name="about_val2_desc" rows="2">{{ setting('about_val2_desc', 'Hardbound binding and heavy art paper designed to last for generations.') }}</textarea>
                    </div>
                    <div class="mb-3 p-3 bg-light rounded border">
                        <label class="form-label fw-bold text-dark mb-1">Value 3 Title & Description</label>
                        <input type="text" class="form-control mb-2" name="about_val3_title" value="{{ setting('about_val3_title', 'Delivered Worldwide') }}">
                        <textarea class="form-control form-control-sm" name="about_val3_desc" rows="2">{{ setting('about_val3_desc', 'Safely packaged, ribbon-sealed, and shipped to families everywhere.') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Final CTA Banner -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-megaphone me-2 text-danger"></i> 4. About Page Final CTA</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">CTA Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                        <input type="text" class="form-control" name="about_cta_heading" value="{{ setting('about_cta_heading', 'Ready to turn your memories into a <em>book?</em>') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">CTA Description</label>
                        <textarea class="form-control" name="about_cta_desc" rows="2">{{ setting('about_cta_desc', 'Start a conversation with our editorial team today.') }}</textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Button Label</label>
                            <input type="text" class="form-control" name="about_cta_btn_text" value="{{ setting('about_cta_btn_text', 'BEGIN YOUR STORY') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Button Link</label>
                            <input type="text" class="form-control" name="about_cta_btn_link" value="{{ setting('about_cta_btn_link', '/begin') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Stats and Skills -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-bar-chart me-2 text-success"></i> Statistics & Pillars</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label fw-bold d-block">Statistics Counters (3 items)</label>
                        <div class="row g-2">
                            @for($i = 0; $i < 3; $i++)
                                @php
                                    $statVal = isset($about->statistics[$i]) ? $about->statistics[$i] : ['number' => '', 'label' => ''];
                                @endphp
                                <div class="col-12 mb-2">
                                    <div class="p-2.5 border rounded bg-light">
                                        <label class="form-label micro fw-bold">Stat #{{ $i + 1 }} Number & Label</label>
                                        <input type="text" class="form-control form-control-sm mb-1" name="statistics[{{ $i }}][number]" value="{{ $statVal['number'] }}" placeholder="1000+">
                                        <input type="text" class="form-control form-control-sm" name="statistics[{{ $i }}][label]" value="{{ $statVal['label'] }}" placeholder="Stories Painted">
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Company Skills / Pillars List</label>
                        @for($s = 0; $s < 4; $s++)
                            @php
                                $skillVal = isset($about->skills[$s]) ? $about->skills[$s] : '';
                            @endphp
                            <input type="text" class="form-control form-control-sm mb-2" name="skills[{{ $s }}]" value="{{ $skillVal }}" placeholder="Pillar #{{ $s + 1 }}">
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Image Asset Card -->
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
