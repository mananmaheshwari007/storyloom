@extends('layouts.admin')

@section('title', 'Homepage Editor')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="page-title h3 mb-1"><i class="bi bi-house-door me-2 text-primary"></i> Homepage Editor</h1>
        <p class="text-muted small mb-0">Manage all text copy, hero rotating artwork cards, relationship cards, featured story spreads, brand emblem, and call-to-action sections across the homepage.</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Homepage Editor</li>
        </ol>
    </nav>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('admin.hero.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <!-- Floating Save Bar -->
    <div class="card shadow-sm border-0 mb-4 bg-white sticky-top" style="top: 80px; z-index: 100;">
        <div class="card-body py-2.5 px-3 d-flex align-items-center justify-content-between">
            <span class="fw-bold text-dark small"><i class="bi bi-sliders me-1.5 text-primary"></i> Homepage CMS Manager</span>
            <button type="submit" class="btn btn-sm btn-primary fw-bold px-4 py-1.5">
                <i class="bi bi-save me-1.5"></i> Save Homepage Changes
            </button>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Column: Copy & Text Content -->
        <div class="col-lg-5">
            
            <!-- Hero Copy -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-fonts me-2 text-primary"></i> 1. Hero Content & Copy</h5>
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
                        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $hero->description ?? setting('hero_description', 'We transform your memories into a beautifully illustrated keepsake book — every page painted around your people, your places, and the moments that made you a family.')) }}</textarea>
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

                    <div class="mb-0">
                        <label for="hero_carousel_speed" class="form-label font-weight-bold"><i class="bi bi-speedometer2 me-1 text-primary"></i> Carousel Rotation Speed (Seconds)</label>
                        <div class="input-group">
                            <input type="number" step="0.5" min="1" max="15" class="form-control" id="hero_carousel_speed" name="hero_carousel_speed" value="{{ setting('hero_carousel_speed', 3.0) }}">
                            <span class="input-group-text">seconds / card</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Brand Emblem & Transformation Quotes -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-stars me-2 text-warning"></i> Brand Emblem & Transformation</h5>
                </div>
                <div class="card-body">
                    <!-- Emblem Image Upload with Live Preview & Uniform Layout -->
                    <div class="mb-3 p-3 bg-light rounded border img-upload-block">
                        <label class="form-label font-weight-bold mb-1"><i class="bi bi-shield-check me-1 text-primary"></i> Brand Emblem Logo / Center Mark</label>
                        <div class="row g-3 align-items-center mb-2">
                            <div class="col-auto text-center">
                                <img src="{{ asset(setting('site_emblem', 'assets/img/logo-emblem.png')) }}" alt="Emblem" width="56" height="56" class="bg-white p-1 border rounded img-preview-el shadow-sm object-fit-contain">
                            </div>
                            <div class="col">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control img-path-input" name="site_emblem" value="{{ setting('site_emblem', 'assets/img/logo-emblem.png') }}" placeholder="assets/img/logo-emblem.png">
                                    <button type="button" class="btn btn-outline-primary upload-trigger-btn">
                                        <i class="bi bi-cloud-upload me-1"></i> Upload Image
                                    </button>
                                    <input type="file" class="d-none hidden-file-input" name="site_emblem_file" accept="image/png,image/webp,image/svg+xml">
                                </div>
                                <small class="text-muted d-block mt-1" style="font-size: 0.72rem;">
                                    <i class="bi bi-info-circle me-1"></i> Specs: <strong>2&times; display size</strong> &bull; PNG-8 / WebP &bull; <strong>&lt; 10 KB</strong>
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">"Before" Quote</label>
                            <input type="text" class="form-control form-control-sm" name="transform_before_quote" value="{{ setting('transform_before_quote', '“I don\'t know what to gift them…”') }}">
                            <label class="form-label font-weight-bold mt-2">"Before" Sub-label</label>
                            <input type="text" class="form-control form-control-sm" name="transform_before_who" value="{{ setting('transform_before_who', 'Every year, before') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">"After" Quote</label>
                            <input type="text" class="form-control form-control-sm" name="transform_after_quote" value="{{ setting('transform_after_quote', '“I can\'t believe you made this.”') }}">
                            <label class="form-label font-weight-bold mt-2">"After" Sub-label</label>
                            <input type="text" class="form-control form-control-sm" name="transform_after_who" value="{{ setting('transform_after_who', 'The moment they open it') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Final CTA Section Editor -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-box-arrow-in-right me-2 text-danger"></i> Final Call to Action (CTA)</h5>
                </div>
                <div class="card-body">
                    <!-- CTA Background Image Upload with Uniform Layout & Live Preview -->
                    <div class="mb-3 p-3 bg-light rounded border img-upload-block">
                        <label class="form-label font-weight-bold mb-1"><i class="bi bi-image me-1 text-danger"></i> CTA Background Image</label>
                        <div class="row g-3 align-items-center mb-2">
                            <div class="col-auto text-center">
                                <img src="{{ asset(setting('cta_bg_image', 'assets/img/spread-under-stars.webp')) }}" alt="CTA Bg" width="90" height="54" class="object-fit-cover rounded border img-preview-el shadow-sm">
                            </div>
                            <div class="col">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control img-path-input" name="cta_bg_image" value="{{ setting('cta_bg_image', 'assets/img/spread-under-stars.webp') }}" placeholder="assets/img/spread-under-stars.webp">
                                    <button type="button" class="btn btn-outline-primary upload-trigger-btn">
                                        <i class="bi bi-cloud-upload me-1"></i> Upload Image
                                    </button>
                                    <input type="file" class="d-none hidden-file-input" name="cta_bg_image_file" accept="image/webp,image/jpeg,image/png">
                                </div>
                                <small class="text-muted d-block mt-1" style="font-size: 0.72rem;">
                                    <i class="bi bi-info-circle me-1"></i> Specs: Max width <strong>900 px</strong> &bull; Quality <strong>78&ndash;80</strong> &bull; Expected size <strong>60&ndash;130 KB</strong>
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">CTA Eyebrow</label>
                        <input type="text" class="form-control" name="cta_eyebrow" value="{{ setting('cta_eyebrow', 'BEGIN TONIGHT') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">CTA Heading (HTML allowed like &lt;em&gt;)</label>
                        <input type="text" class="form-control" name="cta_heading" value="{{ setting('cta_heading', 'Every relationship has a story worth <em>preserving.</em>') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">CTA Description</label>
                        <textarea class="form-control" name="cta_desc" rows="2">{{ setting('cta_desc', 'Another occasion will come around soon. This time, give them something that says everything — and stays said, forever.') }}</textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Primary Button Text</label>
                            <input type="text" class="form-control" name="cta_btn1_text" value="{{ setting('cta_btn1_text', 'BEGIN YOUR STORY') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Primary Link</label>
                            <input type="text" class="form-control" name="cta_btn1_link" value="{{ setting('cta_btn1_link', route('begin')) }}">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Secondary Button Text</label>
                            <input type="text" class="form-control" name="cta_btn2_text" value="{{ setting('cta_btn2_text', 'READ A STORYLOOM') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Secondary Link</label>
                            <input type="text" class="form-control" name="cta_btn2_link" value="{{ setting('cta_btn2_link', route('library')) }}">
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label font-weight-bold">Subnote / Guarantee Text</label>
                        <input type="text" class="form-control" name="cta_subnote_text" value="{{ setting('cta_subnote_text', 'We’ll guide you through every step') }}">
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Carousel Cards & Artwork Spreads Showcase -->
        <div class="col-lg-7">
            
            <!-- Hero Arc Carousel Manager -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-images me-2 text-warning"></i> Rotating Arc Carousel Cards</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="addCardBtn">
                        <i class="bi bi-plus-lg me-1"></i> Add Carousel Card
                    </button>
                </div>
                <div class="card-body">
                    <!-- Image Guidelines Box -->
                    <div class="alert alert-info border-0 shadow-sm py-2.5 px-3 mb-4 small d-flex align-items-start gap-2.5 rounded" style="background-color: #f0f7ff; border-left: 4px solid #0d6efd !important;">
                        <i class="bi bi-info-circle-fill text-primary fs-5 mt-0.5"></i>
                        <div>
                            <div class="fw-bold text-dark mb-0.5">Hero Cards Specifications:</div>
                            <div class="text-muted">
                                &bull; <strong>Max Width:</strong> <code>600 px</code> &nbsp;|&nbsp; <strong>Quality:</strong> <code>75</code> (WebP)<br>
                                &bull; <strong>Expected File Size:</strong> <code>50&ndash;80 KB</code> &nbsp;|&nbsp; <strong>Formats:</strong> WebP, JPG, PNG, AVIF
                            </div>
                        </div>
                    </div>

                    <div id="carouselCardsContainer">
                        @foreach($carouselCards as $index => $card)
                            <div class="card mb-3 border shadow-none card-item-row img-upload-block" data-card-index="{{ $index }}">
                                <div class="card-body bg-light position-relative p-3 rounded">
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-card-btn position-absolute top-0 end-0 m-2" title="Remove Card">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <div class="row g-3 align-items-center">
                                        <div class="col-md-3 text-center">
                                            <img src="{{ asset($card['image'] ?? 'assets/img/hero-reading-hilltop.webp') }}" alt="Preview" class="img-fluid rounded border card-preview-img img-preview-el shadow-sm" style="max-height: 110px; width: 80px; object-fit: cover;">
                                        </div>
                                        <div class="col-md-9">
                                            <div class="mb-2">
                                                <label class="form-label form-label-sm font-weight-bold mb-1">Image Path / Upload</label>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control card-img-input img-path-input" name="hero_cards[{{ $index }}][image]" value="{{ $card['image'] ?? '' }}" placeholder="assets/img/spread-name.webp" required>
                                                    <button type="button" class="btn btn-outline-primary upload-card-img-btn upload-trigger-btn">
                                                        <i class="bi bi-cloud-upload me-1"></i> Upload Image
                                                    </button>
                                                    <input type="file" class="d-none card-file-input hidden-file-input" name="hero_cards_file[{{ $index }}]" accept="image/webp,image/jpeg,image/png,image/avif">
                                                </div>
                                                <small class="text-muted d-block mt-1" style="font-size: 0.72rem;">
                                                    <i class="bi bi-aspect-ratio me-1"></i> Max width: <strong>600 px</strong> &bull; Quality: <strong>75</strong> &bull; Expected size: <strong>50&ndash;80 KB</strong>
                                                </small>
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

            <!-- "Who is your story for?" Relationship Cards Manager -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-heart me-2 text-danger"></i> "Who is your story for?" Relationship Cards</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="addStoryForBtn">
                        <i class="bi bi-plus-lg me-1"></i> Add Relationship Card
                    </button>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Section Eyebrow</label>
                            <input type="text" class="form-control form-control-sm" name="story_for_eyebrow" value="{{ setting('story_for_eyebrow', 'Who is your story for?') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Main Heading (HTML allowed)</label>
                            <input type="text" class="form-control form-control-sm" name="story_for_heading" value="{{ setting('story_for_heading', 'Every relationship has its own <em>book.</em>') }}">
                        </div>
                    </div>

                    <div id="storyForCardsContainer">
                        @foreach($storyForCards as $index => $sCard)
                            <div class="card mb-3 border shadow-none story-for-item-row img-upload-block" data-card-index="{{ $index }}">
                                <div class="card-body bg-light position-relative p-3 rounded">
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-story-card-btn position-absolute top-0 end-0 m-2" title="Remove Card">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <div class="row g-3 align-items-center">
                                        <div class="col-md-3 text-center">
                                            <img src="{{ asset($sCard['image'] ?? 'assets/img/spread-bench-sunset.webp') }}" alt="Preview" class="img-fluid rounded border story-for-preview-img img-preview-el shadow-sm" style="max-height: 80px; width: 100px; object-fit: cover;">
                                        </div>
                                        <div class="col-md-9">
                                            <div class="mb-2">
                                                <label class="form-label form-label-sm font-weight-bold mb-1">Card Image / Upload</label>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control story-for-img-input img-path-input" name="story_for_cards[{{ $index }}][image]" value="{{ $sCard['image'] ?? '' }}" placeholder="assets/img/spread-name.webp" required>
                                                    <button type="button" class="btn btn-outline-primary upload-story-for-img-btn upload-trigger-btn">
                                                        <i class="bi bi-cloud-upload me-1"></i> Upload Image
                                                    </button>
                                                    <input type="file" class="d-none story-for-file-input hidden-file-input" name="story_for_cards_file[{{ $index }}]" accept="image/webp,image/jpeg,image/png,image/avif">
                                                </div>
                                                <small class="text-muted d-block mt-1" style="font-size: 0.72rem;">
                                                    <i class="bi bi-aspect-ratio me-1"></i> Specs: <strong>240 px</strong> width &bull; Quality <strong>75</strong> &bull; Expected size <strong>7&ndash;18 KB</strong>
                                                </small>
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label class="form-label form-label-sm font-weight-bold mb-1">Title (e.g. For Your Wife)</label>
                                                    <input type="text" class="form-control form-control-sm" name="story_for_cards[{{ $index }}][title]" value="{{ $sCard['title'] ?? '' }}" placeholder="For Your Wife" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label form-label-sm font-weight-bold mb-1">Occasions Hint</label>
                                                    <input type="text" class="form-control form-control-sm" name="story_for_cards[{{ $index }}][hint]" value="{{ $sCard['hint'] ?? '' }}" placeholder="anniversaries · birthdays">
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

            <!-- Reveal & Featured Artwork Spreads Showcase -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-journal-album me-2 text-success"></i> Reveal & Featured Artwork Spreads</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Section Eyebrow</label>
                        <input type="text" class="form-control form-control-sm" name="reveal_eyebrow" value="{{ setting('reveal_eyebrow', 'Introducing Storyloom') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Main Heading (HTML allowed)</label>
                        <input type="text" class="form-control form-control-sm" name="reveal_heading" value="{{ setting('reveal_heading', 'Your memories, woven into a <em>storybook.</em>') }}">
                    </div>

                    <div class="mb-4">
                        <label class="form-label font-weight-bold">Section Lede / Intro</label>
                        <textarea class="form-control form-control-sm" name="reveal_lede" rows="2">{{ setting('reveal_lede', 'A completely personalised, hand-illustrated book created from your memories — an original story where every detail belongs to your family alone.') }}</textarea>
                    </div>

                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Featured Artwork Spreads Showcase Plates:</h6>

                    <!-- Showcase Plate 1 with Uniform Upload UI & Live Preview -->
                    <div class="p-3 bg-light rounded border mb-3 img-upload-block">
                        <div class="fw-bold small text-dark mb-2"><i class="bi bi-image me-1 text-primary"></i> Showcase Plate 1</div>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-3 text-center">
                                <img src="{{ asset(setting('reveal_plate1_image', 'assets/img/spread-home-morning.webp')) }}" alt="Plate 1" class="img-fluid rounded border img-preview-el shadow-sm" style="max-height: 80px; object-fit: cover;">
                            </div>
                            <div class="col-md-9">
                                <div class="mb-2">
                                    <label class="form-label form-label-sm font-weight-bold mb-1">Image Path / Upload</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control img-path-input" name="reveal_plate1_image" value="{{ setting('reveal_plate1_image', 'assets/img/spread-home-morning.webp') }}" placeholder="assets/img/spread-home-morning.webp">
                                        <button type="button" class="btn btn-outline-primary upload-trigger-btn">
                                            <i class="bi bi-cloud-upload me-1"></i> Upload Image
                                        </button>
                                        <input type="file" class="d-none hidden-file-input" name="reveal_plate1_file" accept="image/*">
                                    </div>
                                </div>
                                <input type="text" class="form-control form-control-sm" name="reveal_plate1_caption" value="{{ setting('reveal_plate1_caption', 'the flat where it all began') }}" placeholder="Plate 1 Caption">
                            </div>
                        </div>
                    </div>

                    <!-- Showcase Plate 2 with Uniform Upload UI & Live Preview -->
                    <div class="p-3 bg-light rounded border mb-3 img-upload-block">
                        <div class="fw-bold small text-dark mb-2"><i class="bi bi-image me-1 text-success"></i> Showcase Plate 2</div>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-3 text-center">
                                <img src="{{ asset(setting('reveal_plate2_image', 'assets/img/spread-flower-street.webp')) }}" alt="Plate 2" class="img-fluid rounded border img-preview-el shadow-sm" style="max-height: 80px; object-fit: cover;">
                            </div>
                            <div class="col-md-9">
                                <div class="mb-2">
                                    <label class="form-label form-label-sm font-weight-bold mb-1">Image Path / Upload</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control img-path-input" name="reveal_plate2_image" value="{{ setting('reveal_plate2_image', 'assets/img/spread-flower-street.webp') }}" placeholder="assets/img/spread-flower-street.webp">
                                        <button type="button" class="btn btn-outline-primary upload-trigger-btn">
                                            <i class="bi bi-cloud-upload me-1"></i> Upload Image
                                        </button>
                                        <input type="file" class="d-none hidden-file-input" name="reveal_plate2_file" accept="image/*">
                                    </div>
                                </div>
                                <input type="text" class="form-control form-control-sm" name="reveal_plate2_caption" value="{{ setting('reveal_plate2_caption', 'the evening walk, every single day') }}" placeholder="Plate 2 Caption">
                            </div>
                        </div>
                    </div>

                    <!-- Showcase Plate 3 with Uniform Upload UI & Live Preview -->
                    <div class="p-3 bg-light rounded border img-upload-block">
                        <div class="fw-bold small text-dark mb-2"><i class="bi bi-image me-1 text-warning"></i> Showcase Plate 3</div>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-3 text-center">
                                <img src="{{ asset(setting('reveal_plate3_image', 'assets/img/spread-shared-fries.webp')) }}" alt="Plate 3" class="img-fluid rounded border img-preview-el shadow-sm" style="max-height: 80px; object-fit: cover;">
                            </div>
                            <div class="col-md-9">
                                <div class="mb-2">
                                    <label class="form-label form-label-sm font-weight-bold mb-1">Image Path / Upload</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control img-path-input" name="reveal_plate3_image" value="{{ setting('reveal_plate3_image', 'assets/img/spread-shared-fries.webp') }}" placeholder="assets/img/spread-shared-fries.webp">
                                        <button type="button" class="btn btn-outline-primary upload-trigger-btn">
                                            <i class="bi bi-cloud-upload me-1"></i> Upload Image
                                        </button>
                                        <input type="file" class="d-none hidden-file-input" name="reveal_plate3_file" accept="image/*">
                                    </div>
                                </div>
                                <input type="text" class="form-control form-control-sm" name="reveal_plate3_caption" value="{{ setting('reveal_plate3_caption', 'one plate, two forks — always') }}" placeholder="Plate 3 Caption">
                            </div>
                        </div>
                    </div>

                    <small class="text-muted d-block mt-3" style="font-size: 0.72rem;">
                        <i class="bi bi-info-circle me-1"></i> Story Spreads Specs: Max width <strong>800 px</strong> &bull; Quality <strong>72&ndash;75</strong> &bull; Expected size <strong>60&ndash;95 KB</strong>
                    </small>
                </div>
            </div>

        </div>
    </div>
</form>

<script>
document.addEventListener("DOMContentLoaded", function() {

    // 1. Dynamic Card Addition for Hero Carousel Cards
    var container = document.getElementById("carouselCardsContainer");
    var addBtn = document.getElementById("addCardBtn");

    if (addBtn && container) {
        addBtn.addEventListener("click", function() {
            var newIndex = Date.now();
            var cardHtml = `
                <div class="card mb-3 border shadow-none card-item-row img-upload-block" data-card-index="${newIndex}">
                    <div class="card-body bg-light position-relative p-3 rounded">
                        <button type="button" class="btn btn-sm btn-outline-danger remove-card-btn position-absolute top-0 end-0 m-2" title="Remove Card">
                            <i class="bi bi-trash"></i>
                        </button>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-3 text-center">
                                <img src="{{ asset('assets/img/spread-home-morning.webp') }}" alt="Preview" class="img-fluid rounded border card-preview-img img-preview-el shadow-sm" style="max-height: 110px; width: 80px; object-fit: cover;">
                            </div>
                            <div class="col-md-9">
                                <div class="mb-2">
                                    <label class="form-label form-label-sm font-weight-bold mb-1">Image Path / Upload</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control card-img-input img-path-input" name="hero_cards[${newIndex}][image]" value="assets/img/spread-home-morning.webp" placeholder="assets/img/spread-name.webp" required>
                                        <button type="button" class="btn btn-outline-primary upload-card-img-btn upload-trigger-btn">
                                            <i class="bi bi-cloud-upload me-1"></i> Upload Image
                                        </button>
                                        <input type="file" class="d-none card-file-input hidden-file-input" name="hero_cards_file[${newIndex}]" accept="image/webp,image/jpeg,image/png,image/avif">
                                    </div>
                                    <small class="text-muted d-block mt-1" style="font-size: 0.72rem;">
                                        <i class="bi bi-aspect-ratio me-1"></i> Max width: <strong>600 px</strong> &bull; Quality: <strong>75</strong> &bull; Expected size: <strong>50&ndash;80 KB</strong>
                                    </small>
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
                if (row && container.querySelectorAll(".card-item-row").length > 1) {
                    row.remove();
                } else {
                    alert("Must have at least 1 hero card.");
                }
            }
        });
    }

    // 2. Dynamic Card Addition for "Who is your story for?" Cards
    var sfContainer = document.getElementById("storyForCardsContainer");
    var addSfBtn = document.getElementById("addStoryForBtn");

    if (addSfBtn && sfContainer) {
        addSfBtn.addEventListener("click", function() {
            var newIndex = Date.now();
            var cardHtml = `
                <div class="card mb-3 border shadow-none story-for-item-row img-upload-block" data-card-index="${newIndex}">
                    <div class="card-body bg-light position-relative p-3 rounded">
                        <button type="button" class="btn btn-sm btn-outline-danger remove-story-card-btn position-absolute top-0 end-0 m-2" title="Remove Card">
                            <i class="bi bi-trash"></i>
                        </button>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-3 text-center">
                                <img src="{{ asset('assets/img/spread-bench-sunset.webp') }}" alt="Preview" class="img-fluid rounded border story-for-preview-img img-preview-el shadow-sm" style="max-height: 80px; width: 100px; object-fit: cover;">
                            </div>
                            <div class="col-md-9">
                                <div class="mb-2">
                                    <label class="form-label form-label-sm font-weight-bold mb-1">Card Image / Upload</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control story-for-img-input img-path-input" name="story_for_cards[${newIndex}][image]" value="assets/img/spread-bench-sunset.webp" placeholder="assets/img/spread-name.webp" required>
                                        <button type="button" class="btn btn-outline-primary upload-story-for-img-btn upload-trigger-btn">
                                            <i class="bi bi-cloud-upload me-1"></i> Upload Image
                                        </button>
                                        <input type="file" class="d-none story-for-file-input hidden-file-input" name="story_for_cards_file[${newIndex}]" accept="image/webp,image/jpeg,image/png,image/avif">
                                    </div>
                                    <small class="text-muted d-block mt-1" style="font-size: 0.72rem;">
                                        <i class="bi bi-aspect-ratio me-1"></i> Specs: <strong>240 px</strong> width &bull; Quality <strong>75</strong> &bull; Expected size <strong>7&ndash;18 KB</strong>
                                    </small>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <label class="form-label form-label-sm font-weight-bold mb-1">Title (e.g. For Your Wife)</label>
                                        <input type="text" class="form-control form-control-sm" name="story_for_cards[${newIndex}][title]" value="For Someone Special" placeholder="For Your Wife" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label form-label-sm font-weight-bold mb-1">Occasions Hint</label>
                                        <input type="text" class="form-control form-control-sm" name="story_for_cards[${newIndex}][hint]" value="anniversaries · birthdays" placeholder="anniversaries · birthdays">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            sfContainer.insertAdjacentHTML("beforeend", cardHtml);
        });

        sfContainer.addEventListener("click", function(e) {
            var removeBtn = e.target.closest(".remove-story-card-btn");
            if (removeBtn) {
                var row = removeBtn.closest(".story-for-item-row");
                if (row && sfContainer.querySelectorAll(".story-for-item-row").length > 1) {
                    row.remove();
                } else {
                    alert("Must have at least 1 relationship card.");
                }
            }
        });
    }

    // 3. UNIFORM UNIVERSAL IMAGE UPLOADER WITH INSTANT LIVE PREVIEW
    document.addEventListener("click", function(e) {
        var uploadBtn = e.target.closest(".upload-trigger-btn");
        if (uploadBtn) {
            var block = uploadBtn.closest(".img-upload-block");
            if (block) {
                var hiddenInput = block.querySelector(".hidden-file-input");
                if (hiddenInput) {
                    hiddenInput.click();
                }
            }
        }
    });

    document.addEventListener("change", function(e) {
        if (e.target && e.target.classList.contains("hidden-file-input")) {
            var fileInput = e.target;
            if (!fileInput.files || fileInput.files.length === 0) return;

            var file = fileInput.files[0];
            var block = fileInput.closest(".img-upload-block");
            if (!block) return;

            var imgPreview = block.querySelector(".img-preview-el");
            var pathInput = block.querySelector(".img-path-input");
            var uploadBtn = block.querySelector(".upload-trigger-btn");

            // INSTANT LIVE PREVIEW (Before & during AJAX upload)
            if (imgPreview) {
                var liveUrl = URL.createObjectURL(file);
                imgPreview.src = liveUrl;
            }

            // File size validation (Max 4 MB)
            if (file.size > 4 * 1024 * 1024) {
                alert("Selected file exceeds maximum allowed size of 4 MB.");
                fileInput.value = "";
                return;
            }

            // Perform instant AJAX upload to server
            if (uploadBtn) {
                var originalBtnHtml = uploadBtn.innerHTML;
                uploadBtn.disabled = true;
                uploadBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-1" role="status"></span> Uploading...`;

                var formData = new FormData();
                formData.append("image", file);
                var csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                fetch("{{ route('admin.hero.uploadImage') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken || "",
                        "Accept": "application/json"
                    },
                    body: formData
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    uploadBtn.disabled = false;
                    uploadBtn.innerHTML = originalBtnHtml;

                    if (data.success) {
                        if (pathInput) {
                            pathInput.value = data.url;
                        }
                        if (imgPreview) {
                            imgPreview.src = data.asset_url || ("/" + data.url);
                        }
                    } else {
                        alert(data.message || "Image upload failed.");
                    }
                })
                .catch(function(err) {
                    uploadBtn.disabled = false;
                    uploadBtn.innerHTML = originalBtnHtml;
                    alert("Upload error: " + err.message);
                });
            }
        }
    });

});
</script>
@endsection
