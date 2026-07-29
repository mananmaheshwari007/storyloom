@extends('layouts.admin')

@section('title', 'How It Works Page Manager')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800" style="font-family: var(--font-family-title); font-weight: 700;">How It Works Page Manager</h1>
        <p class="text-muted small mb-0">Manage hero intro, timeline steps, stats bar, craftsmanship section, and CTA copy.</p>
    </div>
</div>

<form action="{{ route('admin.how.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-4">
        <!-- Main Form Column -->
        <div class="col-lg-8">
            <!-- 1. Hero Section -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 font-weight-bold text-dark"><i class="bi bi-fonts me-2 text-primary"></i> 1. Hero Intro Section</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Hero Eyebrow</label>
                        <input type="text" name="how_hero_eyebrow" class="form-control" value="{{ setting('how_hero_eyebrow', 'How it works') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Hero Heading (supports &lt;em&gt;)</label>
                        <input type="text" name="how_hero_heading" class="form-control" value="{{ setting('how_hero_heading', 'From a conversation to a <em>keepsake.</em>') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Hero Lede / Description</label>
                        <textarea name="how_hero_lede" class="form-control" rows="3" required>{{ setting('how_hero_lede', 'You bring the memories. We bring the writers, the illustrators, and the patience. Here is exactly what happens between “I\'d like to make one” and the moment they open it.') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- 2. Timeline Steps -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 font-weight-bold text-dark"><i class="bi bi-clock-history me-2 text-primary"></i> 2. Process Timeline Steps</h5>
                </div>
                <div class="card-body">
                    @for($i = 1; $i <= 6; $i++)
                        @php
                            $defaultBadges = [1 => 'Week 1 · Days 1–3', 2 => 'Week 1–2', 3 => 'Week 2–4', 4 => 'Week 4', 5 => 'Week 4–5', 6 => 'Week 5'];
                            $defaultTitles = [1 => 'The Consultation', 2 => 'The Story Takes Shape', 3 => 'The Illustrations Are Painted', 4 => 'Layout & Your Final Review', 5 => 'Printing & Binding', 6 => 'Wrapped, Sealed, Delivered'];
                            $defaultDescs = [
                                1 => 'A relaxed conversation — call, WhatsApp, voice notes. Whatever you have is enough.',
                                2 => 'Our writers shape your memories into a story, and you refine every line with us.',
                                3 => 'Your real places and real faces, painted spread by spread in our house style.',
                                4 => 'You review the complete book. Nothing prints until you say it\'s perfect.',
                                5 => 'Archival paper, casebound hardcover — built for decades of bedtime readings.',
                                6 => 'Wrapped, ribbon-tied, sealed — delivered anywhere in India, and worldwide.'
                            ];
                        @endphp
                        <div class="p-3 mb-3 bg-light rounded border">
                            <h6 class="fw-bold text-primary mb-3">Step {{ $i }}</h6>
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Badge / Week</label>
                                    <input type="text" name="how_step{{ $i }}_badge" class="form-control form-control-sm" value="{{ setting('how_step'.$i.'_badge', $defaultBadges[$i]) }}" required>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label small fw-bold">Step Title</label>
                                    <input type="text" name="how_step{{ $i }}_title" class="form-control form-control-sm" value="{{ setting('how_step'.$i.'_title', $defaultTitles[$i]) }}" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold">Description <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                                    <textarea name="how_step{{ $i }}_desc" class="form-control form-control-sm" rows="2" required>{{ setting('how_step'.$i.'_desc', $defaultDescs[$i]) }}</textarea>
                                </div>
                                <div class="col-md-12 img-upload-block">
                                    <label class="form-label small fw-bold">Step Icon <span class="badge bg-secondary ms-1">Optional</span></label>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ setting('how_step'.$i.'_icon') ? asset(setting('how_step'.$i.'_icon')) : asset('assets/img/logo-emblem.png') }}"
                                             alt="Step {{ $i }} icon" width="44" height="44"
                                             class="border rounded bg-white p-1 img-preview-el"
                                             style="object-fit:contain; flex:none; {{ setting('how_step'.$i.'_icon') ? '' : 'opacity:.25;' }}">
                                        <div class="flex-grow-1">
                                            <div class="input-group input-group-sm">
                                                <input type="text" name="how_step{{ $i }}_icon" class="form-control img-path-input" value="{{ setting('how_step'.$i.'_icon') }}" placeholder="optional — leave blank for no icon">
                                                <input type="file" name="how_step{{ $i }}_icon_file" class="form-control hidden-file-input" accept=".png,.webp,.svg">
                                                <button type="button" class="btn btn-outline-danger remove-img-btn" title="Remove image"><i class="bi bi-trash"></i></button>
                                            </div>
                                            <small class="text-muted d-block mt-1" style="font-size:.7rem;">Transparent <strong>PNG / WEBP / SVG</strong> &bull; square approx <strong>128&times;128 px</strong> &bull; max 1 MB &bull; trash icon clears it</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                    <div class="mt-3 p-3 bg-white border rounded">
                        <label class="form-label small fw-bold">Timeline Note Text (Appears below timeline steps)</label>
                        <input type="text" name="how_timeline_note" class="form-control form-control-sm" value="{{ setting('how_timeline_note', 'Every Storyloom is created individually. Timelines may vary slightly depending on revisions and illustration complexity.') }}">
                    </div>
                </div>
            </div>

            <!-- 3. Stats Strip -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 font-weight-bold text-dark"><i class="bi bi-bar-chart me-2 text-primary"></i> 3. Highlights Bar / Stats Strip</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Stat 1 Number</label>
                            <input type="text" name="how_stat1_num" class="form-control form-control-sm" value="{{ setting('how_stat1_num', '3–5') }}">
                            <label class="form-label small fw-bold mt-2">Stat 1 Label</label>
                            <input type="text" name="how_stat1_label" class="form-control form-control-sm" value="{{ setting('how_stat1_label', 'weeks, start to doorstep') }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Stat 2 Number</label>
                            <input type="text" name="how_stat2_num" class="form-control form-control-sm" value="{{ setting('how_stat2_num', '2') }}">
                            <label class="form-label small fw-bold mt-2">Stat 2 Label</label>
                            <input type="text" name="how_stat2_label" class="form-control form-control-sm" value="{{ setting('how_stat2_label', 'review rounds included, more if needed') }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Stat 3 Number</label>
                            <input type="text" name="how_stat3_num" class="form-control form-control-sm" value="{{ setting('how_stat3_num', '1') }}">
                            <label class="form-label small fw-bold mt-2">Stat 3 Label</label>
                            <input type="text" name="how_stat3_label" class="form-control form-control-sm" value="{{ setting('how_stat3_label', 'book like it, anywhere — yours') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Craftsmanship & CTA Media -->
        <div class="col-lg-4">
            <!-- 4. Craftsmanship Section -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 font-weight-bold text-dark"><i class="bi bi-gem me-2 text-primary"></i> 4. Craftsmanship Section</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Section Eyebrow</label>
                        <input type="text" name="craft_eyebrow" class="form-control form-control-sm" value="{{ setting('craft_eyebrow', 'Built to be handed down') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Heading (supports &lt;em&gt;)</label>
                        <input type="text" name="craft_heading" class="form-control form-control-sm" value="{{ setting('craft_heading', 'Quality you can feel in the <em>first page-turn.</em>') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Synopsis Note</label>
                        <textarea name="craft_synopsis" class="form-control form-control-sm" rows="3">{{ setting('craft_synopsis', 'A keepsake is a promise about time. So we obsess over the things you\'ll only notice years from now:') }}</textarea>
                    </div>

                    <div class="mb-3 p-3 bg-light rounded border">
                        <label class="form-label small fw-bold text-primary mb-2"><i class="bi bi-check2-circle me-1"></i> Craftsmanship Feature Points (Tick Mark Texts)</label>
                        <div class="mb-2">
                            <label class="form-label micro text-muted mb-1">Point 1</label>
                            <input type="text" name="craft_feature_1" class="form-control form-control-sm" value="{{ setting('craft_feature_1', 'Heavyweight archival art paper that won\'t yellow or turn brittle') }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label micro text-muted mb-1">Point 2</label>
                            <input type="text" name="craft_feature_2" class="form-control form-control-sm" value="{{ setting('craft_feature_2', 'Casebound hardcover with reinforced binding that opens flat') }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label micro text-muted mb-1">Point 3</label>
                            <input type="text" name="craft_feature_3" class="form-control form-control-sm" value="{{ setting('craft_feature_3', 'Colour-calibrated printing that stays true to every painted spread') }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label micro text-muted mb-1">Point 4</label>
                            <input type="text" name="craft_feature_4" class="form-control form-control-sm" value="{{ setting('craft_feature_4', 'A keepsake box strong enough to become the book\'s forever home') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Feature Artwork Image</label>
                        <div class="mb-2 text-center">
                            <img src="{{ asset(setting('craft_artwork_img', 'assets/img/spread-home-morning.webp')) }}" class="img-thumbnail" style="max-height: 120px;">
                        </div>
                        <input type="file" name="craft_artwork_img_file" class="form-control form-control-sm" accept="image/*">
                        <div class="form-text">Max file size: <strong>3 MB</strong>. Recommended dimensions: <strong>1600 × 900 px</strong> or <strong>1400 × 600 px</strong>.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Artwork Caption</label>
                        <input type="text" name="craft_artwork_caption" class="form-control form-control-sm" value="{{ setting('craft_artwork_caption', 'every spread, printed exactly as painted') }}">
                    </div>
                </div>
            </div>

            <!-- 5. Final CTA Section -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 font-weight-bold text-dark"><i class="bi bi-megaphone me-2 text-primary"></i> 5. Final CTA Banner</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">CTA Heading</label>
                        <input type="text" name="how_cta_heading" class="form-control form-control-sm" value="{{ setting('how_cta_heading', 'The first step is one <em style="color: #E88B52;">conversation.</em>') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">CTA Description</label>
                        <textarea name="how_cta_desc" class="form-control form-control-sm" rows="3">{{ setting('how_cta_desc', 'Tell us who the story is for. We\'ll tell you exactly how we\'d bring it to life — no commitment until you\'ve seen the plan.') }}</textarea>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Primary Button Label</label>
                            <input type="text" name="how_cta_btn1" class="form-control form-control-sm" value="{{ setting('how_cta_btn1', 'BEGIN YOUR STORY') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Primary Button Link</label>
                            <input type="text" name="how_cta_btn1_link" class="form-control form-control-sm" value="{{ setting('how_cta_btn1_link', '/begin') }}">
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Secondary Button Label</label>
                            <input type="text" name="how_cta_btn2" class="form-control form-control-sm" value="{{ setting('how_cta_btn2', 'SEE PRICING') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Secondary Button Link</label>
                            <input type="text" name="how_cta_btn2_link" class="form-control form-control-sm" value="{{ setting('how_cta_btn2_link', '/pricing') }}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-2" style="background-color: var(--primary-active); border-color: var(--primary-active);">
                        <i class="bi bi-check-circle me-1"></i> Save How It Works Page
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
