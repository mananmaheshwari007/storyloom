@extends('layouts.admin')

@section('title', 'Edit Hero Arc Carousel Section')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="page-title h3 mb-1">Hero Section — Image Arc Carousel</h1>
        <p class="text-muted small mb-0">Manage the hero section text content and the rotating fanned artwork carousel cards appearing at the top of the homepage.</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Hero Section</li>
        </ol>
    </nav>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('admin.hero.update') }}" method="POST">
    @csrf
    <div class="row g-4">
        <!-- Left Column: Copy & Buttons -->
        <div class="col-lg-5">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-fonts me-2 text-primary"></i> Hero Content & Copy</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="subheading" class="form-label font-weight-bold">Section Eyebrow</label>
                        <input type="text" class="form-control" id="subheading" name="subheading" value="{{ old('subheading', $hero->subheading ?? setting('hero_subheading', 'PERSONALISED KEEPSAKE STORYBOOKS')) }}">
                    </div>

                    <div class="mb-3">
                        <label for="heading" class="form-label font-weight-bold">Main Heading (HTML allowed like &lt;em&gt;)</label>
                        <input type="text" class="form-control" id="heading" name="heading" value="{{ old('heading', $hero->heading ?? setting('hero_heading', 'The story only <em>you</em> could give.')) }}" required>
                        <small class="text-muted">Use <code>&lt;em&gt;word&lt;/em&gt;</code> for terracotta italic script font highlighting.</small>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label font-weight-bold">Section Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $hero->description ?? setting('hero_description', 'We transform your memories into a beautifully illustrated keepsake book — every page painted around your people, your places, and the moments that made you a family.')) }}</textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="button_text" class="form-label font-weight-bold">Primary Button Text</label>
                            <input type="text" class="form-control" id="button_text" name="button_text" value="{{ old('button_text', $hero->button_text ?? setting('hero_btn1_text', 'BEGIN YOUR STORY')) }}">
                        </div>
                        <div class="col-md-6">
                            <label for="button_link" class="form-label font-weight-bold">Primary Button Link</label>
                            <input type="text" class="form-control" id="button_link" name="button_link" value="{{ old('button_link', $hero->button_link ?? setting('hero_btn1_link', '/begin')) }}">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="hero_btn2_text" class="form-label font-weight-bold">Secondary Button Text</label>
                            <input type="text" class="form-control" id="hero_btn2_text" name="hero_btn2_text" value="{{ setting('hero_btn2_text', 'READ A STORYLOOM') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="hero_btn2_link" class="form-label font-weight-bold">Secondary Button Link</label>
                            <input type="text" class="form-control" id="hero_btn2_link" name="hero_btn2_link" value="{{ setting('hero_btn2_link', '/library') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="hero_note" class="form-label font-weight-bold">Rating Sub-note / Tagline</label>
                        <input type="text" class="form-control" id="hero_note" name="hero_note" value="{{ setting('hero_note', 'Illustrated by hand · Crafted in India · Delivered worldwide') }}">
                    </div>

                    <div class="mb-3">
                        <label for="hero_carousel_speed" class="form-label font-weight-bold"><i class="bi bi-speedometer2 me-1 text-primary"></i> Carousel Rotation Speed (Seconds)</label>
                        <div class="input-group">
                            <input type="number" step="0.5" min="1" max="15" class="form-control" id="hero_carousel_speed" name="hero_carousel_speed" value="{{ setting('hero_carousel_speed', 3.0) }}">
                            <span class="input-group-text">seconds / card</span>
                        </div>
                        <small class="text-muted">Sets auto-rotation timer interval (e.g. 2.0s = fast, 3.0s = standard, 5.0s = leisurely).</small>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary w-100 py-2.5 fw-bold">
                        <i class="bi bi-save me-2"></i> Save Hero & Carousel Settings
                    </button>
                </div>
            </div>
        </div>

        <!-- Right Column: Carousel Story Cards Manager -->
        <div class="col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-images me-2 text-warning"></i> Rotating Arc Carousel Cards</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="addCardBtn">
                        <i class="bi bi-plus-lg me-1"></i> Add Carousel Card
                    </button>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-4">These cards rotate fanned along a 3D arc above the hero headline on the homepage. Edit images, titles, and sub-captions below:</p>

                    <div id="carouselCardsContainer">
                        @foreach($carouselCards as $index => $card)
                            <div class="card mb-3 border shadow-none card-item-row" data-card-index="{{ $index }}">
                                <div class="card-body bg-light position-relative p-3 rounded">
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-card-btn position-absolute top-0 end-0 m-2" title="Remove Card">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <div class="row g-3 align-items-center">
                                        <div class="col-md-3 text-center">
                                            <img src="{{ asset($card['image'] ?? 'assets/img/hero-reading-hilltop.webp') }}" alt="Preview" class="img-fluid rounded border card-preview-img" style="max-height: 100px; object-fit: cover;">
                                        </div>
                                        <div class="col-md-9">
                                            <div class="mb-2">
                                                <label class="form-label form-label-sm font-weight-bold mb-1">Image Path</label>
                                                <input type="text" class="form-control form-control-sm card-img-input" name="hero_cards[{{ $index }}][image]" value="{{ $card['image'] ?? '' }}" required>
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label class="form-label form-label-sm font-weight-bold mb-1">Story Title</label>
                                                    <input type="text" class="form-control form-control-sm" name="hero_cards[{{ $index }}][title]" value="{{ $card['title'] ?? '' }}" placeholder='"The First Home"' required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label form-label-sm font-weight-bold mb-1">Sub-caption</label>
                                                    <input type="text" class="form-control form-control-sm" name="hero_cards[{{ $index }}][caption]" value="{{ $card['caption'] ?? '' }}" placeholder="a Storyloom for an anniversary">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var container = document.getElementById("carouselCardsContainer");
    var addBtn = document.getElementById("addCardBtn");

    if (addBtn && container) {
        addBtn.addEventListener("click", function() {
            var newIndex = Date.now();
            
            var cardHtml = `
                <div class="card mb-3 border shadow-none card-item-row" data-card-index="${newIndex}">
                    <div class="card-body bg-light position-relative p-3 rounded">
                        <button type="button" class="btn btn-sm btn-outline-danger remove-card-btn position-absolute top-0 end-0 m-2" title="Remove Card">
                            <i class="bi bi-trash"></i>
                        </button>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-3 text-center">
                                <img src="{{ asset('assets/img/spread-home-morning.webp') }}" alt="Preview" class="img-fluid rounded border card-preview-img" style="max-height: 100px; object-fit: cover;">
                            </div>
                            <div class="col-md-9">
                                <div class="mb-2">
                                    <label class="form-label form-label-sm font-weight-bold mb-1">Image Path</label>
                                    <input type="text" class="form-control form-control-sm card-img-input" name="hero_cards[${newIndex}][image]" value="assets/img/spread-home-morning.webp" required>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <label class="form-label form-label-sm font-weight-bold mb-1">Story Title</label>
                                        <input type="text" class="form-control form-control-sm" name="hero_cards[${newIndex}][title]" value='"New Keepsake Story"' placeholder='"Story Title"' required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label form-label-sm font-weight-bold mb-1">Sub-caption</label>
                                        <input type="text" class="form-control form-control-sm" name="hero_cards[${newIndex}][caption]" value="a Storyloom for a milestone" placeholder="Sub-caption">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML("beforeend", cardHtml);
        });

        container.addEventListener("click", function(e) {
            var removeBtn = e.target.closest(".remove-card-btn");
            if (removeBtn) {
                var row = removeBtn.closest(".card-item-row");
                if (row) {
                    if (container.querySelectorAll(".card-item-row").length > 1) {
                        row.remove();
                    } else {
                        alert("The carousel must have at least 1 card.");
                    }
                }
            }
        });
    }
});
</script>
@endsection
