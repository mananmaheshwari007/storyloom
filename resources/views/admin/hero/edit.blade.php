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

    {{-- Section visibility. Turning one off removes it entirely; the remaining
         sections take their background colours in sequence, so the page never
         ends up with two tinted bands touching where a section used to be. --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-eye me-2 text-primary"></i> Which sections appear on the homepage</h5>
        </div>
        <div class="card-body">
            <p class="text-muted small">
                Everything is on by default. Switch one off and it disappears from the page — the sections
                above and below close up and re-shade themselves, so there's no gap and no clash.
                The hero is always shown.
            </p>
            <div class="row g-2">
                @foreach([
                    'problem'     => ['The trouble with gifts', 'bi-emoji-frown'],
                    'reveal'      => ['Your story, woven into a book', 'bi-book'],
                    'story'       => ['Who is your story for?', 'bi-people'],
                    'process'     => ['The plan (three steps)', 'bi-list-ol'],
                    'why'         => ['Why Storyloom', 'bi-patch-check'],
                    'testimonial' => ['Testimonial band', 'bi-chat-quote'],
                    'marquee'     => ['For every occasion', 'bi-tags'],
                    'faqteaser'   => ['FAQ teaser', 'bi-question-circle'],
                    'cta'         => ['Final call to action', 'bi-megaphone'],
                ] as $key => [$label, $icon])
                    @php $on = setting('section_' . $key, '1') !== '0'; @endphp
                    <div class="col-md-6">
                        <div class="form-check form-switch border rounded px-3 py-2 ms-0" style="padding-left:3rem !important;">
                            <input type="hidden" name="section_{{ $key }}" value="0">
                            <input class="form-check-input" type="checkbox" role="switch"
                                   id="section_{{ $key }}" name="section_{{ $key }}" value="1" {{ $on ? 'checked' : '' }}>
                            <label class="form-check-label small fw-semibold" for="section_{{ $key }}">
                                <i class="bi {{ $icon }} me-1 text-muted"></i>{{ $label }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Column: Copy & Text Content -->
        <div class="col-lg-5">

            <!-- 0. Promotional Top Bar -->
            <div class="card shadow-sm border-0 mb-4" style="border-left: 4px solid #B55B29 !important;">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-megaphone me-2 text-warning"></i> 0. Promotional Top Bar</h5>
                </div>
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="promo_bar_enabled" name="promo_bar_enabled" value="1" {{ setting('promo_bar_enabled', '0') === '1' ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="promo_bar_enabled">Enable Promotional Bar</label>
                        <small class="text-muted d-block">When enabled, a colored strip appears at the top of every page with your promotional text.</small>
                    </div>

                    <div class="mb-3">
                        <label for="promo_bar_text" class="form-label fw-bold">Promo Text <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                        <input type="text" class="form-control" id="promo_bar_text" name="promo_bar_text" value="{{ setting('promo_bar_text', '🎉 Launch offer — 15% off your first Storyloom!') }}">
                        <small class="text-muted">Supports HTML (e.g. <code>&lt;strong&gt;</code>, <code>&lt;em&gt;</code>). Keep it concise — one line works best.</small>
                    </div>

                    <div class="mb-3">
                        <label for="promo_bar_link" class="form-label fw-bold">Link URL (optional)</label>
                        <input type="text" class="form-control" id="promo_bar_link" name="promo_bar_link" value="{{ setting('promo_bar_link', '/begin') }}" placeholder="/begin or https://...">
                        <small class="text-muted">If set, the entire text becomes a clickable link.</small>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="promo_bar_bg_color" class="form-label fw-bold">Background Color</label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color" id="promo_bar_bg_color" name="promo_bar_bg_color" value="{{ setting('promo_bar_bg_color', '#B55B29') }}">
                                <input type="text" class="form-control" value="{{ setting('promo_bar_bg_color', '#B55B29') }}" onchange="document.getElementById('promo_bar_bg_color').value = this.value" oninput="document.getElementById('promo_bar_bg_color').value = this.value">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="promo_bar_text_color" class="form-label fw-bold">Text Color</label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color" id="promo_bar_text_color" name="promo_bar_text_color" value="{{ setting('promo_bar_text_color', '#FFFFFF') }}">
                                <input type="text" class="form-control" value="{{ setting('promo_bar_text_color', '#FFFFFF') }}" onchange="document.getElementById('promo_bar_text_color').value = this.value" oninput="document.getElementById('promo_bar_text_color').value = this.value">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Hero Copy -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-fonts me-2 text-primary"></i> 1. Hero Content & Copy <span class="badge bg-secondary ms-2">Desktop</span></h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="subheading" class="form-label font-weight-bold">Section Eyebrow</label>
                        <input type="text" class="form-control" id="subheading" name="subheading" value="{{ old('subheading', $hero->subheading ?? setting('hero_subheading', 'PERSONALISED KEEPSAKE STORYBOOKS')) }}">
                    </div>

                    <div class="mb-3">
                        <label for="heading" class="form-label font-weight-bold">Main Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                        <input type="text" class="form-control" id="heading" name="heading" value="{{ old('heading', $hero->heading ?? setting('hero_heading', 'The story only <em>you</em> could give.')) }}" required>
                        <small class="text-muted">Use <code>&lt;em&gt;word&lt;/em&gt;</code> for terracotta script font highlighting, and <code>&lt;br&gt;</code> to control exact line breaks.</small>
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

            <!-- 1b. Mobile Hero Content -->
            <div class="card shadow-sm border-0 mb-4" style="border-left: 4px solid #3F4E3A !important;">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-phone me-2 text-success"></i> 1b. Mobile Hero Content <span class="badge bg-success ms-2">Mobile Only</span></h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info py-2 mb-3" style="font-size: 0.82rem;">
                        <i class="bi bi-info-circle me-1"></i> These controls set the <strong>mobile-only</strong> hero layout (≤ 767px). Text is left-aligned over a full-bleed crossfading image slideshow. Desktop hero content is controlled separately above.
                    </div>

                    <div class="mb-3">
                        <label for="mobile_hero_heading" class="form-label fw-bold">Mobile Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                        <input type="text" class="form-control" id="mobile_hero_heading" name="mobile_hero_heading" value="{{ setting('mobile_hero_heading', 'The story only <em>you</em> could give.') }}">
                        <small class="text-muted">Use <code>&lt;em&gt;word&lt;/em&gt;</code> for script accent, and <code>&lt;br&gt;</code> to control exact line breaks.</small>
                    </div>

                    <div class="mb-3">
                        <label for="mobile_hero_description" class="form-label fw-bold">Mobile Body Text</label>
                        <textarea class="form-control" id="mobile_hero_description" name="mobile_hero_description" rows="3">{{ setting('mobile_hero_description', 'We transform your memories into a beautifully illustrated keepsake book — every page painted around your people, your places, and the moments that made you a family.') }}</textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="mobile_hero_btn_text" class="form-label fw-bold">Button Text</label>
                            <input type="text" class="form-control" id="mobile_hero_btn_text" name="mobile_hero_btn_text" value="{{ setting('mobile_hero_btn_text', 'BEGIN YOUR STORY') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="mobile_hero_btn_link" class="form-label fw-bold">Button Link</label>
                            <input type="text" class="form-control" id="mobile_hero_btn_link" name="mobile_hero_btn_link" value="{{ setting('mobile_hero_btn_link', '/begin') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="mobile_hero_slide_speed" class="form-label fw-bold"><i class="bi bi-speedometer2 me-1 text-success"></i> Slideshow Speed</label>
                        <div class="input-group">
                            <input type="number" step="0.5" min="2" max="15" class="form-control" id="mobile_hero_slide_speed" name="mobile_hero_slide_speed" value="{{ setting('mobile_hero_slide_speed', 4) }}">
                            <span class="input-group-text">seconds / image</span>
                        </div>
                    </div>

                    <hr class="my-3">
                    <h6 class="fw-bold text-dark mb-3"><i class="bi bi-images me-2 text-success"></i> Mobile Hero Background Images</h6>
                    <small class="text-muted d-block mb-3" style="font-size: 0.78rem;">
                        <i class="bi bi-info-circle me-1"></i> These images crossfade as a full-bleed background slideshow behind the mobile hero text. Portrait orientation (3:4 or 9:16) works best.
                    </small>

                    <div id="mobileHeroCardsContainer">
                        @foreach($mobileHeroCards as $mi => $mCard)
                        <div class="mobile-hero-card-row mb-3 p-3 bg-light rounded border img-upload-block">
                            <div class="row g-2 align-items-center">
                                <div class="col-auto text-center">
                                    <img src="{{ asset($mCard['image'] ?? 'assets/img/hero-reading-hilltop.webp') }}" alt="Slide {{ $mi + 1 }}" width="60" height="80" class="rounded shadow-sm object-fit-cover img-preview-el">
                                </div>
                                <div class="col">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">{{ $mi + 1 }}</span>
                                        <input type="text" class="form-control img-path-input" name="mobile_hero_cards[{{ $mi }}][image]" value="{{ $mCard['image'] ?? '' }}" placeholder="assets/img/...">
                                        <button type="button" class="btn btn-outline-success upload-trigger-btn">
                                            <i class="bi bi-cloud-upload me-1"></i> Upload
                                        </button>
                                        <button type="button" class="btn btn-outline-danger remove-img-btn" title="Remove image"><i class="bi bi-trash"></i></button>
                                        <input type="file" class="d-none hidden-file-input" name="mobile_hero_cards_file[{{ $mi }}]" accept="image/jpeg,image/png,image/webp,image/avif">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
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
                                        <button type="button" class="btn btn-outline-danger remove-img-btn" title="Remove image"><i class="bi bi-trash"></i></button>
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
                                        <button type="button" class="btn btn-outline-danger remove-img-btn" title="Remove image"><i class="bi bi-trash"></i></button>
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
                                        <button type="button" class="btn btn-outline-danger remove-img-btn" title="Remove image"><i class="bi bi-trash"></i></button>
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
                                        <button type="button" class="btn btn-outline-danger remove-img-btn" title="Remove image"><i class="bi bi-trash"></i></button>
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
                        <input type="text" class="form-control form-control-sm" name="reveal_heading" value="{{ setting('reveal_heading', 'Your story,<br>woven into a <em>book.</em>') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Section Lede / Intro</label>
                        <textarea class="form-control form-control-sm" name="reveal_lede" rows="2">{{ setting('reveal_lede', 'A completely personalised, hand-illustrated book created from your memories — an original story where every detail belongs to your family alone.') }}</textarea>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Button Text</label>
                            <input type="text" class="form-control form-control-sm" name="reveal_btn_text" value="{{ setting('reveal_btn_text', 'READ A STORYLOOM') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Button Link</label>
                            <input type="text" class="form-control form-control-sm" name="reveal_btn_link" value="{{ setting('reveal_btn_link', route('library')) }}">
                        </div>
                    </div>

                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-book me-1 text-primary"></i> Open Book Spread Showcase Image:</h6>

                    <!-- Open Book Spread Image Uploader & Live Preview -->
                    <div class="p-3 bg-light rounded border mb-3 img-upload-block">
                        <div class="fw-bold small text-dark mb-2"><i class="bi bi-image me-1 text-primary"></i> Open Book Spread Image</div>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-4 text-center">
                                <img src="{{ asset(setting('reveal_book_spread_image', 'assets/img/spread-home-morning.webp')) }}" alt="Open Book Spread" class="img-fluid rounded border img-preview-el shadow-sm" style="max-height: 110px; width: 100%; object-fit: cover;">
                            </div>
                            <div class="col-md-8">
                                <div class="mb-2">
                                    <label class="form-label form-label-sm font-weight-bold mb-1">Image Path / Upload</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control img-path-input" name="reveal_book_spread_image" value="{{ setting('reveal_book_spread_image', 'assets/img/spread-home-morning.webp') }}" placeholder="assets/img/spread-home-morning.webp">
                                        <button type="button" class="btn btn-outline-primary upload-trigger-btn">
                                            <i class="bi bi-cloud-upload me-1"></i> Upload Image
                                        </button>
                                        <button type="button" class="btn btn-outline-danger remove-img-btn" title="Remove image"><i class="bi bi-trash"></i></button>
                                        <input type="file" class="d-none hidden-file-input" name="reveal_book_spread_file" accept="image/*">
                                    </div>
                                </div>
                                <div>
                                    <label class="form-label form-label-sm font-weight-bold mb-1">Sub-caption (Optional)</label>
                                    <input type="text" class="form-control form-control-sm" name="reveal_book_spread_caption" value="{{ setting('reveal_book_spread_caption', '') }}" placeholder="e.g. an authentic Storyloom spread">
                                </div>
                            </div>
                        </div>
                    </div>

                    <small class="text-muted d-block mt-3" style="font-size: 0.72rem;">
                        <i class="bi bi-info-circle me-1"></i> Open Book Spread Specs: Max width <strong>900&ndash;1200 px</strong> &bull; Quality <strong>78&ndash;80</strong> &bull; Expected size <strong>60&ndash;130 KB</strong>
                    </small>
                </div>
            </div>

            <!-- Homepage Final CTA Banner Section -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-megaphone me-2 text-danger"></i> Homepage Final CTA Banner</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">CTA Eyebrow</label>
                        <input type="text" class="form-control form-control-sm" name="cta_eyebrow" value="{{ setting('cta_eyebrow', 'BEGIN YOUR STORYLOOM') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">CTA Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                        <input type="text" class="form-control form-control-sm" name="cta_heading" value="{{ setting('cta_heading', 'Every family has a story. What\'s yours?') }}">
                        <div class="form-text">Supports HTML tags like <code>&lt;em&gt;word&lt;/em&gt;</code> for brand italic accent.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">CTA Description Text</label>
                        <textarea class="form-control form-control-sm" name="cta_desc" rows="3">{{ setting('cta_desc', setting('cta_description', 'Tell us about your people, your places, and the moments that made you. We\'ll help you turn them into a storybook that lasts forever.')) }}</textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Primary Button Text</label>
                            <input type="text" class="form-control form-control-sm" name="cta_btn1_text" value="{{ setting('cta_btn1_text', 'BEGIN YOUR STORY') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Primary Button Link</label>
                            <input type="text" class="form-control form-control-sm" name="cta_btn1_link" value="{{ setting('cta_btn1_link', '/begin') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Secondary Button Text</label>
                            <input type="text" class="form-control form-control-sm" name="cta_btn2_text" value="{{ setting('cta_btn2_text', 'READ A STORYLOOM') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Secondary Button Link</label>
                            <input type="text" class="form-control form-control-sm" name="cta_btn2_link" value="{{ setting('cta_btn2_link', '/library') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Sub-note / Studio Hours Tagline</label>
                        <input type="text" class="form-control form-control-sm" name="cta_subnote_text" value="{{ setting('cta_subnote_text', setting('cta_subnote', 'Voice notes welcome · Delivered worldwide')) }}">
                    </div>

                    <!-- Background Artwork Image Upload -->
                    <div class="p-3 bg-light rounded border img-upload-block">
                        <label class="form-label font-weight-bold mb-1"><i class="bi bi-image me-1 text-primary"></i> CTA Background Artwork Image</label>
                        <div class="row g-3 align-items-center">
                            <div class="col-auto text-center">
                                <img src="{{ asset(setting('cta_bg_image', 'assets/img/hero-reading-hilltop.webp')) }}" alt="CTA Background" width="100" height="60" class="rounded border img-preview-el shadow-sm object-fit-cover">
                            </div>
                            <div class="col">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control img-path-input" name="cta_bg_image" value="{{ setting('cta_bg_image', 'assets/img/hero-reading-hilltop.webp') }}" placeholder="assets/img/hero-reading-hilltop.webp">
                                    <button type="button" class="btn btn-outline-primary upload-trigger-btn">
                                        <i class="bi bi-cloud-upload me-1"></i> Upload Image
                                    </button>
                                        <button type="button" class="btn btn-outline-danger remove-img-btn" title="Remove image"><i class="bi bi-trash"></i></button>
                                    <input type="file" class="d-none hidden-file-input" name="cta_bg_image_file" accept="image/*">
                                </div>
                                <small class="text-muted d-block mt-1" style="font-size: 0.72rem;">
                                    <i class="bi bi-info-circle me-1"></i> Specs: <strong>1920&times;1080 px</strong> &bull; WEBP / JPG &bull; <strong>Max 4 MB</strong>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @php
                // Same defaults the homepage falls back to, so these boxes show the
                // live copy instead of appearing empty. Blank saves fall back too.
                $planDefaults = [
                    1 => ['Share Your Story',       'Tell us about them — the memories, the inside jokes, the places, the photographs. A gentle conversation, not a form. Whatever you have is enough.'],
                    2 => ['Refine It Together',     'Our writers shape your memories into a story; our illustrators paint your world into its pages. You review everything and we refine it until it feels exactly right.'],
                    3 => ['Receive Your Storyloom', 'A hardbound, archival-quality book arrives at your door — wrapped, sealed, and ready for the moment they open it.'],
                ];
                $whyDefaults = [
                    1 => ['A story, not a spec',      'Not “32 pages” — a complete story they\'ll return to again and again, with a beginning, a middle, and your ending.'],
                    2 => ['Made to be handed down',   'Not “premium paper” — a book crafted to survive decades of bedtime readings, and still be there for the grandchildren.'],
                    3 => ['Unmistakably them',        'Their likeness, their street, their chai stall. A Storyloom could never belong to any other family — every detail on the page belongs to this one.'],
                    4 => ['Painterly, calm, classic', 'Closer to fine illustration than bright cartoon templates — art that belongs on a shelf, and in a will.'],
                ];
            @endphp

            <!-- "Most gifts are forgotten" Section -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-emoji-frown me-2 text-secondary"></i> "Most Gifts Are Forgotten" — Problem Section</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label font-weight-bold">Eyebrow</label>
                            <input type="text" class="form-control form-control-sm" name="problem_eyebrow" value="{{ setting('problem_eyebrow', 'The trouble with gifts') }}">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label font-weight-bold">Section Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                            <input type="text" class="form-control form-control-sm" name="problem_heading" value="{{ setting('problem_heading', 'Most gifts are <em>forgotten.</em>') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label font-weight-bold">Section Heading — Mobile <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                            <input type="text" class="form-control form-control-sm" name="problem_heading_mobile" value="{{ setting('problem_heading_mobile', '') }}" placeholder="Leave blank to use the same heading on mobile">
                            <div class="form-text">Shown instead of the heading above on screens under 768px — for a shorter line or a different break. Blank means mobile uses the desktop heading.</div>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        @foreach([1 => ['Flowers','fade in a week'], 2 => ['Chocolates','disappear in a day'], 3 => ['Gadgets','are replaced next year']] as $n => [$defWord, $defFate])
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100 bg-light">
                                    <div class="fw-bold text-muted mb-2" style="font-size:.78rem; letter-spacing:.08em;">GIFT {{ $n }}</div>
                                    <div class="mb-2">
                                        <label class="form-label font-weight-bold">Word</label>
                                        <input type="text" class="form-control form-control-sm" name="problem_gift{{ $n }}_word" value="{{ setting('problem_gift'.$n.'_word', $defWord) }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label font-weight-bold">Fate <span class="badge bg-info text-dark ms-1">HTML</span></label>
                                        <input type="text" class="form-control form-control-sm" name="problem_gift{{ $n }}_fate" value="{{ setting('problem_gift'.$n.'_fate', $defFate) }}">
                                    </div>
                                    {{-- .img-upload-block is required: the uploader JS finds the
                                         file input via uploadBtn.closest('.img-upload-block'). --}}
                                    <div class="mb-0 img-upload-block">
                                        <label class="form-label font-weight-bold">Icon <span class="badge bg-secondary ms-1">Optional</span></label>
                                        <div class="text-center mb-2">
                                            <img src="{{ setting('problem_gift'.$n.'_icon') ? asset(setting('problem_gift'.$n.'_icon')) : asset('assets/img/logo-emblem.png') }}"
                                                 alt="Gift {{ $n }} icon" width="48" height="48"
                                                 class="border rounded bg-white p-1 img-preview-el"
                                                 style="object-fit:contain; {{ setting('problem_gift'.$n.'_icon') ? '' : 'opacity:.25;' }}">
                                        </div>
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control img-path-input" name="problem_gift{{ $n }}_icon" value="{{ setting('problem_gift'.$n.'_icon') }}" placeholder="optional">
                                            <button type="button" class="btn btn-outline-primary upload-trigger-btn"><i class="bi bi-cloud-upload"></i></button>
                                        <button type="button" class="btn btn-outline-danger remove-img-btn" title="Remove image"><i class="bi bi-trash"></i></button>
                                            <input type="file" class="d-none hidden-file-input" name="problem_gift{{ $n }}_icon_file" accept=".png,.webp,.svg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mb-0">
                        <label class="form-label font-weight-bold">Closing Line <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                        <textarea class="form-control form-control-sm" name="problem_lede" rows="2">{{ setting('problem_lede', 'The people who shaped your life deserve something that says exactly what they mean to you — and keeps saying it, for years.') }}</textarea>
                    </div>
                    <div class="form-text mt-2">
                        <i class="bi bi-info-circle me-1"></i> Icons: transparent <strong>PNG / WEBP / SVG</strong>, square, approx <strong>144&times;144 px</strong>, max 1 MB. Leave blank for text only.
                    </div>
                </div>
            </div>

            <!-- The Plan (process) Section -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-signpost-split me-2 text-primary"></i> "The Plan" — Three Steps Section</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label font-weight-bold">Eyebrow</label>
                            <input type="text" class="form-control form-control-sm" name="process_eyebrow" value="{{ setting('process_eyebrow', 'The plan') }}">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label font-weight-bold">Section Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                            <input type="text" class="form-control form-control-sm" name="process_heading" value="{{ setting('process_heading', 'Three steps to a story they\'ll <em>never forget.</em>') }}">
                        </div>
                    </div>
                    @foreach($planDefaults as $n => [$defTitle, $defDesc])
                        <div class="border rounded p-3 mb-3 bg-light">
                            <div class="fw-bold text-muted mb-2" style="font-size:.78rem; letter-spacing:.08em;">STEP {{ $n }}</div>
                            <div class="mb-2">
                                <label class="form-label font-weight-bold">Title</label>
                                <input type="text" class="form-control form-control-sm" name="process_step{{ $n }}_title" value="{{ setting('process_step'.$n.'_title', $defTitle) }}">
                            </div>
                            <div class="mb-2">
                                <label class="form-label font-weight-bold">Description <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                                <textarea class="form-control form-control-sm" name="process_step{{ $n }}_desc" rows="2">{{ setting('process_step'.$n.'_desc', $defDesc) }}</textarea>
                            </div>
                            {{-- .img-upload-block is required: the uploader JS finds the
                                 file input via uploadBtn.closest('.img-upload-block'). --}}
                            <div class="mb-0 img-upload-block">
                                <label class="form-label font-weight-bold">Step Icon <span class="badge bg-secondary ms-1">Optional</span></label>
                                <div class="row g-2 align-items-center">
                                    <div class="col-auto text-center">
                                        <img src="{{ setting('process_step'.$n.'_icon') ? asset(setting('process_step'.$n.'_icon')) : asset('assets/img/logo-emblem.png') }}"
                                             alt="Step {{ $n }} icon" width="48" height="48"
                                             class="border rounded bg-white p-1 img-preview-el"
                                             style="object-fit:contain; {{ setting('process_step'.$n.'_icon') ? '' : 'opacity:.25;' }}">
                                    </div>
                                    <div class="col">
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control img-path-input" name="process_step{{ $n }}_icon" value="{{ setting('process_step'.$n.'_icon') }}" placeholder="leave blank to show the roman numeral">
                                            <button type="button" class="btn btn-outline-primary upload-trigger-btn"><i class="bi bi-cloud-upload me-1"></i> Upload</button>
                                        <button type="button" class="btn btn-outline-danger remove-img-btn" title="Remove image"><i class="bi bi-trash"></i></button>
                                            <input type="file" class="d-none hidden-file-input" name="process_step{{ $n }}_icon_file" accept=".png,.webp,.svg">
                                        </div>
                                        <small class="text-muted d-block mt-1" style="font-size:.72rem;">
                                            <i class="bi bi-info-circle me-1"></i> Transparent <strong>PNG / WEBP / SVG</strong> &bull; square, approx <strong>144&times;144 px</strong> &bull; max 1 MB. Blank = show the roman numeral instead.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Why Storyloom Section -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-patch-check me-2 text-success"></i> "Why Storyloom" — Value Cards</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label font-weight-bold">Eyebrow</label>
                            <input type="text" class="form-control form-control-sm" name="why_eyebrow" value="{{ setting('why_eyebrow', 'Why Storyloom') }}">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label font-weight-bold">Section Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                            <input type="text" class="form-control form-control-sm" name="why_heading" value="{{ setting('why_heading', 'Not a product. A <em>moment.</em>') }}">
                        </div>
                    </div>
                    <div class="row g-3">
                        @foreach($whyDefaults as $n => [$defTitle, $defDesc])
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100 bg-light">
                                    <div class="fw-bold text-muted mb-2" style="font-size:.78rem; letter-spacing:.08em;">CARD {{ $n }}</div>
                                    <div class="mb-2">
                                        <label class="form-label font-weight-bold">Title</label>
                                        <input type="text" class="form-control form-control-sm" name="why_card{{ $n }}_title" value="{{ setting('why_card'.$n.'_title', $defTitle) }}">
                                    </div>
                                    <div class="mb-0">
                                        <label class="form-label font-weight-bold">Description <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                                        <textarea class="form-control form-control-sm" name="why_card{{ $n }}_desc" rows="3">{{ setting('why_card'.$n.'_desc', $defDesc) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- The Moment It Opens (testimonials heading) -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-chat-quote me-2 text-warning"></i> "The Moment It Opens" — Testimonials Heading</h5>
                </div>
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input type="hidden" name="testimonial_show_head" value="0">
                        <input class="form-check-input" type="checkbox" role="switch" id="testimonialShowHead"
                               name="testimonial_show_head" value="1"
                               {{ setting('testimonial_show_head', '0') === '1' ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="testimonialShowHead">
                            Show the eyebrow &amp; heading above the testimonial band
                        </label>
                        <div class="form-text">Off by default — the band reads better on its own. The two fields below are kept either way.</div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label font-weight-bold">Eyebrow <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                            <input type="text" class="form-control form-control-sm" name="testimonial_eyebrow" value="{{ setting('testimonial_eyebrow', 'The moment it opens') }}">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label font-weight-bold">Section Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                            <input type="text" class="form-control form-control-sm" name="testimonial_heading" value="{{ setting('testimonial_heading', 'Some gifts get a thank-you. <em>These get tears.</em>') }}">
                        </div>
                    </div>
                    @php $tmList = \App\Models\Testimonial::orderBy('id')->get(); @endphp

                    <hr class="my-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold text-muted" style="font-size:.78rem; letter-spacing:.08em;">
                            QUOTES IN ROTATION ({{ $tmList->count() }})
                        </span>
                        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> Add Testimonial
                        </a>
                    </div>

                    @forelse($tmList as $tm)
                        <div class="d-flex align-items-center gap-3 border rounded p-2 mb-2 {{ $tm->status === 'active' ? 'bg-light' : 'bg-white opacity-75' }}">
                            @if($tm->image)
                                <img src="{{ asset($tm->image) }}" alt="" width="44" height="44" class="rounded border" style="object-fit:cover; flex:none;">
                            @else
                                <span class="d-inline-flex align-items-center justify-content-center border rounded bg-white text-muted" style="width:44px;height:44px;font-size:.6rem;flex:none;">no&nbsp;photo</span>
                            @endif
                            <div class="flex-grow-1 min-w-0">
                                <div class="fw-semibold text-dark" style="font-size:.88rem;">
                                    {{ $tm->client_name }}@if($tm->designation)<span class="text-muted fw-normal">, {{ $tm->designation }}</span>@endif
                                    @if($tm->status !== 'active')
                                        <span class="badge bg-secondary ms-1">hidden</span>
                                    @endif
                                </div>
                                <div class="text-muted text-truncate" style="font-size:.78rem;">{{ \Illuminate\Support\Str::limit($tm->review, 90) }}</div>
                            </div>
                            <a href="{{ route('admin.testimonials.edit', $tm->id) }}" class="btn btn-sm btn-outline-primary" title="Edit quote &amp; photo">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </div>
                    @empty
                        <div class="text-muted border rounded p-3 text-center" style="font-size:.85rem;">
                            No testimonials yet — the homepage shows a placeholder quote until you add one.
                        </div>
                    @endforelse

                    <div class="form-text mt-2">
                        <i class="bi bi-info-circle me-1"></i> Edit opens the full quote editor, where you can change the photo or remove it. Each quote's photo is what fades in on the left of the homepage band.
                    </div>
                </div>
            </div>

            <!-- For Every Occasion (marquee) -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-tags me-2 text-info"></i> "For Every Occasion" — Scrolling Chips</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label font-weight-bold">Eyebrow</label>
                            <input type="text" class="form-control form-control-sm" name="marquee_eyebrow" value="{{ setting('marquee_eyebrow', 'For every occasion') }}">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label font-weight-bold">Section Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                            <input type="text" class="form-control form-control-sm" name="marquee_heading" value="{{ setting('marquee_heading', 'Whenever words aren\'t <em>enough.</em>') }}">
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label font-weight-bold">Occasion Chips</label>
                        <textarea class="form-control form-control-sm" name="marquee_chips" rows="3">{{ setting('marquee_chips', 'Anniversaries, Birthdays, Weddings, Diwali, Raksha Bandhan, Mother\'s Day, Father\'s Day, Valentine\'s Day, Proposals, Retirement, Graduation, Baby\'s First Year, Farewells') }}</textarea>
                        <div class="form-text">Separate each occasion with a <strong>comma</strong>. They scroll continuously and each links to the Occasions page.</div>
                    </div>
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
                                        <button type="button" class="btn btn-outline-danger remove-img-btn" title="Remove image"><i class="bi bi-trash"></i></button>
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
                                        <button type="button" class="btn btn-outline-danger remove-img-btn" title="Remove image"><i class="bi bi-trash"></i></button>
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

        // "Remove image" is handled globally in layouts/admin.blade.php so it
        // works on every admin screen, not just this one.
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
