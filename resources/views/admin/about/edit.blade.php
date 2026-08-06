@extends('layouts.admin')

@section('title', '7. About Page Manager')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="page-title h3 mb-1"><i class="bi bi-file-person me-2 text-primary"></i> 7. About Page Manager</h1>
        <p class="text-muted small mb-0">Manage 100% of hero copy, story prose, "What We Stand For" cards, emblem explanation, founder quote, and final CTA on the About page (/about).</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">About Page</li>
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

    <!-- 1. Hero Header & Story Prose Section -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-fonts me-2 text-primary"></i> 1. Page Hero Header &amp; Main Brand Story Prose</h5>
        </div>
        <div class="card-body">
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Hero Eyebrow</label>
                    <input type="text" name="about_hero_eyebrow" class="form-control form-control-sm" value="{{ setting('about_hero_eyebrow', 'ABOUT STORYLOOM') }}">
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-bold">Hero Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                    <input type="text" name="about_hero_heading" class="form-control form-control-sm" value="{{ setting('about_hero_heading', 'We exist because memories<br>deserve better than a <em>camera roll.</em>') }}">
                    <div class="form-text">Use <code>&lt;em&gt;text&lt;/em&gt;</code> for the custom script font accent.</div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-8">
                    @php
                        // Pre-filled from the old three-paragraph fields the
                        // first time this is opened, so nothing already written
                        // is lost in the switch to a single box.
                        $aboutBody = trim(setting('about_hero_body', ''));

                        if ($aboutBody === '') {
                            $aboutBody = \App\Support\Prose::join([
                                setting('about_hero_p1', 'Families have stories. Often hundreds — and most of them die with us.'),
                                setting('about_hero_p2', 'They live in WhatsApp, scattered across hard drives, lost in phones and albums nobody opens. And as time passes, the details start to blur, and memories lose their frame.'),
                                setting('about_hero_p3', 'The story is the most valuable thing a family can leave behind. It deserves better than a screen.'),
                            ]);
                        }
                    @endphp
                    <div class="mb-3">
                        <label class="form-label fw-bold">Story Text <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                        <textarea name="about_hero_body" class="form-control form-control-sm" rows="10">{{ $aboutBody }}</textarea>
                        <div class="form-text">
                            Write it as you would anywhere else — leave a <strong>blank line between paragraphs</strong> and they'll be spaced correctly on the page.
                            The first paragraph gets the large drop cap automatically. <code>&lt;em&gt;</code>, <code>&lt;strong&gt;</code> and <code>&lt;br&gt;</code> work if you want them.
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-3 border rounded bg-light">
                        <label class="form-label fw-bold text-dark mb-1"><i class="bi bi-image me-1 text-primary"></i> Polaroid Artwork Card</label>
                        <div class="mb-2 text-center">
                            <img id="about_art_preview" src="{{ asset(setting('about_artwork_img', 'assets/img/spread-street-morning.webp')) }}" class="rounded border object-fit-cover shadow-sm" style="max-height: 140px; width: 100%;">
                        </div>
                        <label class="form-label micro fw-bold mt-2">Upload Artwork Image</label>
                        <input type="file" class="form-control form-control-sm mb-2" name="about_artwork_img_file" accept="image/*" onchange="previewImg(this, 'about_art_preview')">
                        <input type="text" class="form-control form-control-sm mb-2" name="about_artwork_img" value="{{ setting('about_artwork_img', 'assets/img/spread-street-morning.webp') }}">
                        <label class="form-label micro fw-bold">Polaroid Handwritten Caption</label>
                        <input type="text" name="about_artwork_caption" class="form-control form-control-sm" value="{{ setting('about_artwork_caption', 'An everyday moment — captured for a family heirloom.') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. What We Stand For (4 Cards) -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-shield-check me-2 text-warning"></i> 2. What We Stand For Section (4 Cards)</h5>
        </div>
        <div class="card-body">
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Section Eyebrow</label>
                    <input type="text" name="stand_eyebrow" class="form-control form-control-sm" value="{{ setting('stand_eyebrow', 'WHAT WE STAND FOR') }}">
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-bold">Section Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                    <input type="text" name="stand_heading" class="form-control form-control-sm" value="{{ setting('stand_heading', 'Craftsmanship over speed.<br>Specificity over <em>sentiment.</em>') }}">
                </div>
            </div>

            @php
                $standDefaults = [
                    1 => ['title' => 'Every detail belongs to you', 'desc' => 'It\'s not a generic template. Every illustration — every street, corner, face — belongs to your story.'],
                    2 => ['title' => 'The book is the monument', 'desc' => 'Not a photo album. A custom hardbound book built to last longer than the memories inside it.'],
                    3 => ['title' => 'Paper, not plastic', 'desc' => 'Archival-quality paper, cloth-bound covers, true hot-stamped foil.'],
                    4 => ['title' => 'Made to be handed down', 'desc' => 'Built for living rooms — built to be kept for generations.'],
                ];
            @endphp

            <div class="row g-3">
                @for($c = 1; $c <= 4; $c++)
                    @php
                        $cDef = $standDefaults[$c];
                        $cTitle = setting("stand_card{$c}_title", $cDef['title']);
                        $cDesc = setting("stand_card{$c}_desc", $cDef['desc']);
                    @endphp
                    <div class="col-md-6 col-lg-3">
                        <div class="p-3 border rounded bg-light h-100">
                            <h6 class="fw-bold text-dark mb-2">Pillar Card #{{ $c }}</h6>
                            <div class="mb-2">
                                <label class="form-label micro fw-bold">Title</label>
                                <input type="text" name="stand_card{{ $c }}_title" class="form-control form-control-sm" value="{{ $cTitle }}">
                            </div>
                            <div>
                                <label class="form-label micro fw-bold">Description</label>
                                <textarea name="stand_card{{ $c }}_desc" class="form-control form-control-sm" rows="3">{{ $cDesc }}</textarea>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- 3. The Mark We Make Section -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-award me-2 text-primary"></i> 3. The Mark We Make (Emblem Section)</h5>
        </div>
        <div class="card-body">
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Section Eyebrow</label>
                    <input type="text" name="mark_eyebrow" class="form-control form-control-sm" value="{{ setting('mark_eyebrow', 'THE MARK WE MAKE') }}">
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-bold">Section Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                    <input type="text" name="mark_heading" class="form-control form-control-sm" value="{{ setting('mark_heading', 'An heirloom mark,<br>not a <em>startup logo.</em>') }}">
                </div>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Paragraph 1 (Emblem Loom Explanation)</label>
                    <textarea name="mark_p1" class="form-control form-control-sm" rows="4">{{ setting('mark_p1', 'Look closely at our emblem. At the top, a loom — vertical posts with threads strung between them: a family\'s scattered moments, still unformed. Below, those same threads fall and open into the pages of a book. One becomes the other.') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Paragraph 2 (Double Ring & Seals Explanation)</label>
                    <textarea name="mark_p2" class="form-control form-control-sm" rows="4">{{ setting('mark_p2', 'The double ring borrows from seals and crests — marks that have always signified craftsmanship and things made to be handed down. It only reveals itself on a second look. So do our books.') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. A Note from the Founder Section -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-quote me-2 text-success"></i> 4. A Note from the Founder</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Section Eyebrow</label>
                    <input type="text" name="founder_eyebrow" class="form-control form-control-sm" value="{{ setting('founder_eyebrow', 'A NOTE FROM THE FOUNDER') }}">
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-bold">Founder Author Signature</label>
                    <input type="text" name="founder_author" class="form-control form-control-sm" value="{{ setting('founder_author', 'MANAN · FOUNDER, STORYLOOM') }}">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold">Founder Quote Text</label>
                    <textarea name="founder_quote" class="form-control form-control-sm" rows="3">{{ setting('founder_quote', '“I started Storyloom after watching my mother re-read a forty-year-old letter until the folds wore through. We keep almost nothing now. I wanted to build the thing families keep.”') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. About Page Final CTA Banner Section -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-megaphone me-2 text-danger"></i> 5. About Page Final CTA Banner</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label fw-bold">CTA Banner Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                    <input type="text" name="about_cta_heading" class="form-control form-control-sm" value="{{ setting('about_cta_heading', 'Your family\'s chapter<br>is <em>ready</em> to be written.') }}">
                    <div class="form-text">Supports HTML formatting tags like <code>&lt;em&gt;word&lt;/em&gt;</code> for brand terracotta italic script.</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Primary Button Label</label>
                    <input type="text" name="about_cta_btn1" class="form-control form-control-sm" value="{{ setting('about_cta_btn1', 'BEGIN YOUR STORY') }}">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold">CTA Banner Description</label>
                    <textarea name="about_cta_desc" class="form-control form-control-sm" rows="2">{{ setting('about_cta_desc', 'Somewhere a memory is waiting to be told and painted into a book. Tell us your story to begin, or read a storyloom.') }}</textarea>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold"><i class="bi bi-image me-1 text-primary"></i> Background Artwork Image</label>
                    <div class="row g-3 align-items-center">
                        <div class="col-auto">
                            <img id="about_cta_bg_preview" src="{{ asset(setting('about_cta_bg', 'assets/img/spread-alone-bench.webp')) }}" alt="CTA Background Preview" width="120" height="60" class="rounded border object-fit-cover shadow-sm">
                        </div>
                        <div class="col">
                            <input type="file" class="form-control form-control-sm mb-1" name="about_cta_bg_file" accept="image/*" onchange="previewImg(this, 'about_cta_bg_preview')">
                            <input type="text" class="form-control form-control-sm" name="about_cta_bg" value="{{ setting('about_cta_bg', 'assets/img/spread-alone-bench.webp') }}">
                            <div class="form-text" style="font-size: 0.74rem;"><span class="badge bg-secondary">Recommended</span> 1920&times;1080 px &bull; WEBP or JPG &bull; Max 3 MB</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-sm btn-primary fw-bold px-4">
                    <i class="bi bi-save me-1"></i> Save About Page Settings &amp; CTA
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
function previewImg(input, previewId) {
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
