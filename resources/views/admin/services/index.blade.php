@extends('layouts.admin')

@section('title', '4. Occasions Page Manager')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="page-title h3 mb-1"><i class="bi bi-heart me-2 text-primary"></i> 4. Occasions Page Manager</h1>
        <p class="text-muted small mb-0">Manage 100% of hero copy, festival cards, milestone cards, relationship tags, and final CTA on the Occasions page (/occasions).</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Occasions Page</li>
        </ol>
    </nav>
</div>

<form action="{{ route('admin.services.settings') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card shadow-sm border-0 mb-4 bg-white sticky-top" style="top: 80px; z-index: 100;">
        <div class="card-body py-2.5 px-3 d-flex align-items-center justify-content-between">
            <span class="fw-bold text-dark small"><i class="bi bi-sliders me-1.5 text-primary"></i> Occasions Page CMS Controls</span>
            <button type="submit" class="btn btn-sm btn-primary fw-bold px-4 py-1.5">
                <i class="bi bi-save me-1.5"></i> Save Occasions Page Changes
            </button>
        </div>
    </div>

    <!-- 1. Hero Header Section -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-fonts me-2 text-primary"></i> 1. Page Hero Header</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Hero Eyebrow</label>
                    <input type="text" name="occasions_hero_eyebrow" class="form-control form-control-sm" value="{{ setting('occasions_hero_eyebrow', 'OCCASIONS') }}">
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-bold">Hero Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                    <input type="text" name="occasions_hero_heading" class="form-control form-control-sm" value="{{ setting('occasions_hero_heading', 'For the days that<br>deserve more than a <em>gift.</em>') }}">
                    <div class="form-text">Use <code>&lt;em&gt;text&lt;/em&gt;</code> for the custom script font accent.</div>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold">Hero Description / Lede</label>
                    <textarea name="occasions_hero_lede" class="form-control form-control-sm" rows="3">{{ setting('occasions_hero_lede', 'Some occasions come with easy answers — a cake, a card, a voucher. And some deserve the one gift that could only ever belong to one person. A Storyloom takes three to five weeks to craft, so the best time to begin is now.') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Festivals & Celebrations (4 Cards) -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-calendar-event me-2 text-warning"></i> 2. Festivals &amp; Celebrations Section (4 Cards)</h5>
        </div>
        <div class="card-body">
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Section Eyebrow</label>
                    <input type="text" name="festivals_eyebrow" class="form-control form-control-sm" value="{{ setting('festivals_eyebrow', 'FESTIVALS & CELEBRATIONS') }}">
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-bold">Section Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                    <input type="text" name="festivals_heading" class="form-control form-control-sm" value="{{ setting('festivals_heading', 'Gifts for the days the<br>whole family <em>gathers.</em>') }}">
                </div>
            </div>

            @php
                $festDefaults = [
                    1 => ['title' => 'Diwali', 'tag' => 'FESTIVAL', 'desc' => 'Your family\'s own festival — opened together, kept forever.', 'img' => 'assets/img/spread-home-evening.webp'],
                    2 => ['title' => 'Raksha Bandhan', 'tag' => 'FESTIVAL', 'desc' => 'The rakhi fades by winter. The story of a brother and sister doesn\'t.', 'img' => 'assets/img/book2-spread-pool.webp'],
                    3 => ['title' => 'Mother\'s Day & Father\'s Day', 'tag' => 'FESTIVAL', 'desc' => 'Everything never said across the dinner table — said page by page.', 'img' => 'assets/img/spread-street-morning.webp'],
                    4 => ['title' => 'Valentine\'s Day', 'tag' => 'FESTIVAL', 'desc' => 'How you actually fell in love — including the parts only you two know.', 'img' => 'assets/img/spread-alone-bench.webp'],
                ];
            @endphp

            <div class="row g-3">
                @for($f = 1; $f <= 4; $f++)
                    @php
                        $fDef = $festDefaults[$f];
                        $fTitle = setting("fest{$f}_title", $fDef['title']);
                        $fTag = setting("fest{$f}_tag", $fDef['tag']);
                        $fDesc = setting("fest{$f}_desc", $fDef['desc']);
                        $fImg = setting("fest{$f}_img", $fDef['img']);
                    @endphp
                    <div class="col-md-6">
                        <div class="p-3 border rounded bg-light">
                            <h6 class="fw-bold text-dark mb-2"><i class="bi bi-card-heading me-1 text-primary"></i> Festival Card #{{ $f }}</h6>
                            <div class="mb-2">
                                <label class="form-label micro fw-bold">Card Title</label>
                                <input type="text" name="fest{{ $f }}_title" class="form-control form-control-sm" value="{{ $fTitle }}">
                            </div>
                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <label class="form-label micro fw-bold">Badge Tag</label>
                                    <input type="text" name="fest{{ $f }}_tag" class="form-control form-control-sm" value="{{ $fTag }}">
                                </div>
                                <div class="col-6">
                                    <label class="form-label micro fw-bold">Image Path</label>
                                    <input type="text" name="fest{{ $f }}_img" class="form-control form-control-sm" value="{{ $fImg }}">
                                </div>
                            </div>
                            <div class="mb-2">
                                <label class="form-label micro fw-bold">Description</label>
                                <textarea name="fest{{ $f }}_desc" class="form-control form-control-sm" rows="2">{{ $fDesc }}</textarea>
                            </div>
                            <div class="d-flex align-items-center gap-2 mt-2">
                                <img id="fest{{ $f }}_preview" src="{{ asset($fImg) }}" width="60" height="40" class="rounded border object-fit-cover">
                                <input type="file" class="form-control form-control-sm" name="fest{{ $f }}_img_file" accept="image/*" onchange="previewImg(this, 'fest{{ $f }}_preview')">
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- 3. Milestones (8 Cards) -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-star me-2 text-primary"></i> 3. Milestones &amp; Life Chapters Section (8 Cards)</h5>
        </div>
        <div class="card-body">
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Section Eyebrow</label>
                    <input type="text" name="milestones_eyebrow" class="form-control form-control-sm" value="{{ setting('milestones_eyebrow', 'MILESTONES') }}">
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-bold">Section Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                    <input type="text" name="milestones_heading" class="form-control form-control-sm" value="{{ setting('milestones_heading', 'For the chapters that <em>close</em><br>— and the ones that open.') }}">
                </div>
            </div>

            @php
                $msDefaults = [
                    1 => ['title' => 'Anniversaries', 'desc' => 'Ten years, or fifty — written around the years you built together.', 'img' => 'assets/img/spread-bench-sunset.webp'],
                    2 => ['title' => 'Weddings', 'desc' => 'The story of how two hand-written paths came to intertwine together.', 'img' => 'assets/img/spread-flower-street.webp'],
                    3 => ['title' => 'Proposals', 'desc' => 'The moment you asked. The initial spark before the question.', 'img' => 'assets/img/spread-under-stars.webp'],
                    4 => ['title' => 'Birthdays', 'desc' => 'Every landmark milestone, bound in one book.', 'img' => 'assets/img/spread-shared-fries.webp'],
                    5 => ['title' => 'Retirement', 'desc' => 'Forty years of work bound into more than a plaque and a pen.', 'img' => 'assets/img/spread-alone-bench.webp'],
                    6 => ['title' => 'Baby\'s First Year', 'desc' => 'The small, fleeting moments recorded before they fade.', 'img' => 'assets/img/spread-home-morning.webp'],
                    7 => ['title' => 'Farewells & Long Distance', 'desc' => 'A piece of home for someone who is moving across oceans.', 'img' => 'assets/img/spread-night-farewell.webp'],
                    8 => ['title' => 'Graduation', 'desc' => 'From first desk to first degree, recorded in a book.', 'img' => 'assets/img/spread-cafe-window.webp'],
                ];
            @endphp

            <div class="row g-3">
                @for($m = 1; $m <= 8; $m++)
                    @php
                        $mDef = $msDefaults[$m];
                        $mTitle = setting("ms{$m}_title", $mDef['title']);
                        $mDesc = setting("ms{$m}_desc", $mDef['desc']);
                        $mImg = setting("ms{$m}_img", $mDef['img']);
                    @endphp
                    <div class="col-md-6 col-lg-3">
                        <div class="p-3 border rounded bg-light h-100 d-flex flex-column justify-content-between">
                            <div>
                                <h6 class="fw-bold text-dark mb-2">Milestone #{{ $m }}</h6>
                                <div class="mb-2">
                                    <label class="form-label micro fw-bold">Title</label>
                                    <input type="text" name="ms{{ $m }}_title" class="form-control form-control-sm" value="{{ $mTitle }}">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label micro fw-bold">Description</label>
                                    <textarea name="ms{{ $m }}_desc" class="form-control form-control-sm" rows="2">{{ $mDesc }}</textarea>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label micro fw-bold">Image Path</label>
                                    <input type="text" name="ms{{ $m }}_img" class="form-control form-control-sm" value="{{ $mImg }}">
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2 mt-2">
                                <img id="ms{{ $m }}_preview" src="{{ asset($mImg) }}" width="50" height="35" class="rounded border object-fit-cover">
                                <input type="file" class="form-control form-control-sm" name="ms{{ $m }}_img_file" accept="image/*" onchange="previewImg(this, 'ms{{ $m }}_preview')">
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- 4. By Relationship Ticker -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-people me-2 text-primary"></i> 4. By Relationship Ticker Section</h5>
        </div>
        <div class="card-body">
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Section Eyebrow</label>
                    <input type="text" name="rel_eyebrow" class="form-control form-control-sm" value="{{ setting('rel_eyebrow', 'BY RELATIONSHIP') }}">
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-bold">Section Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                    <input type="text" name="rel_heading" class="form-control form-control-sm" value="{{ setting('rel_heading', 'Whoever they are to<br>you, there\'s a <em>book</em> in it.') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Relationship Chips (Comma-separated list)</label>
                <textarea name="rel_chips" class="form-control form-control-sm" rows="2">{{ setting('rel_chips', 'For a best friend, For a teacher, For a mentor, For your wife, For your husband, For Mom, For Dad, For your partner') }}</textarea>
                <div class="form-text">Separate tags with a comma. These scroll infinitely across the marquee ticker on the page.</div>
            </div>
            <div class="mb-2">
                <label class="form-label fw-bold">Script Subnote Below Ticker</label>
                <input type="text" name="rel_subnote" class="form-control form-control-sm" value="{{ setting('rel_subnote', '...and for relationships that don\'t have a neat name — those often make the best books.') }}">
            </div>
        </div>
    </div>

    <!-- 5. Final CTA Banner -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-megaphone me-2 text-danger"></i> 5. Occasions Page Final CTA Banner</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label fw-bold">CTA Banner Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                    <input type="text" name="occasion_banner_heading" class="form-control form-control-sm" value="{{ setting('occasion_banner_heading', 'Which occasion is coming <em>next?</em>') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Button Label</label>
                    <input type="text" name="cta_btn1_text" class="form-control form-control-sm" value="{{ setting('cta_btn1_text', 'BEGIN YOUR STORY') }}">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold">CTA Banner Description</label>
                    <textarea name="occasion_banner_desc" class="form-control form-control-sm" rows="2">{{ setting('occasion_banner_desc', 'A Storyloom takes three to four weeks to craft. Cover books take 3 weeks from draft... Tell us your story, and return with the perfect custom gift saved in time.') }}</textarea>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold"><i class="bi bi-image me-1 text-primary"></i> Background Artwork Image</label>
                    <div class="row g-3 align-items-center">
                        <div class="col-auto">
                            <img id="occasion_cta_bg_preview" src="{{ asset(setting('occasion_cta_bg', 'assets/img/spread-bench-dusk.webp')) }}" alt="CTA Background Preview" width="120" height="60" class="rounded border object-fit-cover shadow-sm">
                        </div>
                        <div class="col">
                            <input type="file" class="form-control form-control-sm mb-1" name="occasion_cta_bg_file" accept="image/*" onchange="previewImg(this, 'occasion_cta_bg_preview')">
                            <input type="text" class="form-control form-control-sm" name="occasion_cta_bg" value="{{ setting('occasion_cta_bg', 'assets/img/spread-bench-dusk.webp') }}">
                            <div class="form-text" style="font-size: 0.74rem;"><span class="badge bg-secondary">Recommended</span> 1920&times;1080 px &bull; WEBP or JPG &bull; Max 3 MB</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-sm btn-primary fw-bold px-4">
                    <i class="bi bi-save me-1"></i> Save Occasions Page Settings &amp; Cards
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
