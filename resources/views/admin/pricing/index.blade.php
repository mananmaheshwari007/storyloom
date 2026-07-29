@extends('layouts.admin')

@section('title', '6. Pricing Page Manager')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="page-title h3 mb-1"><i class="bi bi-tags me-2 text-primary"></i> 6. Pricing Page Manager</h1>
        <p class="text-muted small mb-0">Manage 100% of hero copy, stats strip, tier packages, essay copy, and final CTA on the Pricing page (/pricing).</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.pricing.create') }}" class="btn btn-primary shadow-sm" style="background-color: var(--primary-active); border-color: var(--primary-active);">
            <i class="bi bi-plus-lg me-1"></i> Add Pricing Tier Plan
        </a>
    </div>
</div>

<!-- Page Header, Stats, Essay & CTA Settings Card -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="card-title mb-0 font-weight-bold text-dark"><i class="bi bi-fonts me-2 text-primary"></i> Pricing Page Hero Header, Stats, Essay &amp; CTA Controls</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.pricing.settings') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- 1. Hero Header Section -->
            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-layout-text-window me-1 text-primary"></i> 1. Page Hero Header:</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Hero Eyebrow</label>
                    <input type="text" name="pricing_hero_eyebrow" class="form-control form-control-sm" value="{{ setting('pricing_hero_eyebrow', 'PRICING') }}">
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-bold">Hero Title / Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                    <input type="text" name="pricing_hero_title" class="form-control form-control-sm" value="{{ setting('pricing_hero_title', 'What a one-of-one book <em>includes.</em>') }}">
                    <div class="form-text">Use <code>&lt;em&gt;text&lt;/em&gt;</code> for the custom script font accent.</div>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold">Hero Description / Lede</label>
                    <textarea name="pricing_hero_lede" class="form-control form-control-sm" rows="3">{{ setting('pricing_hero_lede', 'Every Storyloom — whichever edition — is written from scratch, illustrated from scratch, and reviewed by you before printing. You\'re not buying a book off a shelf; you\'re commissioning the only copy that will ever exist.') }}</textarea>
                </div>
            </div>

            <hr class="my-4">

            <!-- 2. Stats Strip Section (3 Counters) -->
            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-bar-chart me-1 text-success"></i> 2. Stats Counter Strip (3 Counters):</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="p-3 border rounded bg-light">
                        <label class="form-label micro fw-bold text-dark mb-1">Stat #1 (e.g. 60+)</label>
                        <input type="text" name="pricing_stat1_num" class="form-control form-control-sm mb-2" value="{{ setting('pricing_stat1_num', '60+') }}">
                        <label class="form-label micro fw-bold text-muted mb-1">Label</label>
                        <input type="text" name="pricing_stat1_lbl" class="form-control form-control-sm" value="{{ setting('pricing_stat1_lbl', 'hours of writing & illustration') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 border rounded bg-light">
                        <label class="form-label micro fw-bold text-dark mb-1">Stat #2 (e.g. 100%)</label>
                        <input type="text" name="pricing_stat2_num" class="form-control form-control-sm mb-2" value="{{ setting('pricing_stat2_num', '100%') }}">
                        <label class="form-label micro fw-bold text-muted mb-1">Label</label>
                        <input type="text" name="pricing_stat2_lbl" class="form-control form-control-sm" value="{{ setting('pricing_stat2_lbl', 'original story & art — no templates') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 border rounded bg-light">
                        <label class="form-label micro fw-bold text-dark mb-1">Stat #3 (e.g. ∞)</label>
                        <input type="text" name="pricing_stat3_num" class="form-control form-control-sm mb-2" value="{{ setting('pricing_stat3_num', '∞') }}">
                        <label class="form-label micro fw-bold text-muted mb-1">Label</label>
                        <input type="text" name="pricing_stat3_lbl" class="form-control form-control-sm" value="{{ setting('pricing_stat3_lbl', 'times it will be read aloud') }}">
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <label class="form-label fw-bold">Subnote Below Pricing Packages Grid</label>
                    <input type="text" name="pricing_grid_subnote" class="form-control form-control-sm" value="{{ setting('pricing_grid_subnote', 'Working towards a specific date or budget? Tell us when you begin — every book is planned personally.') }}">
                </div>
            </div>

            <hr class="my-4">

            <!-- 3. "A Note on Price" Essay Section -->
            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-journal-text me-1 text-primary"></i> 3. "A Note on Price" Essay Section:</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Section Eyebrow</label>
                    <input type="text" name="price_note_eyebrow" class="form-control form-control-sm" value="{{ setting('price_note_eyebrow', 'A note on price') }}">
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-bold">Section Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                    <input type="text" name="price_note_heading" class="form-control form-control-sm" value="{{ setting('price_note_heading', 'Why a book can cost more than a <em>phone cover.</em>') }}">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold">First Paragraph (with Drop Cap)</label>
                    <textarea name="price_note_p1" class="form-control form-control-sm" rows="3">{{ setting('price_note_p1', 'A Storyloom is not printed-on-demand merchandise. It is a commission — weeks of a writer\'s and an illustrator\'s full attention on one family\'s story. Every spread is composed for you: your faces, your streets, your weather, your light.') }}</textarea>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold">Second Paragraph</label>
                    <textarea name="price_note_p2" class="form-control form-control-sm" rows="3">{{ setting('price_note_p2', 'Divide the price by the years it will sit on a bedside table, be read at bedtimes, survive house moves, and eventually be handed to someone not yet born — and it becomes the least expensive thing you\'ll ever give.') }}</textarea>
                </div>
            </div>

            <hr class="my-4">

            <!-- 4. Pricing Final CTA Banner Section -->
            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-megaphone me-1 text-danger"></i> 4. Pricing Page Final CTA Banner:</h6>
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label fw-bold">CTA Banner Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                    <input type="text" name="pricing_cta_heading" class="form-control form-control-sm" value="{{ setting('pricing_cta_heading', 'Begin with a conversation, not a <em style="font-family: \'Cormorant Garamond\', Cormorant, Georgia, serif; font-style: italic; font-weight: 500; color: #E88B52;">payment.</em>') }}">
                    <div class="form-text">Supports HTML formatting tags like <code>&lt;em style="..."&gt;word&lt;/em&gt;</code> for brand terracotta italic script.</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Primary Button Text &amp; Link</label>
                    <div class="input-group input-group-sm">
                        <input type="text" name="pricing_cta_btn1_text" class="form-control" value="{{ setting('pricing_cta_btn1_text', 'BEGIN YOUR STORY') }}">
                        <input type="text" name="pricing_cta_btn1_link" class="form-control" value="{{ setting('pricing_cta_btn1_link', route('begin')) }}">
                    </div>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold">CTA Banner Description</label>
                    <textarea name="pricing_cta_desc" class="form-control form-control-sm" rows="2">{{ setting('pricing_cta_desc', 'Tell us your story first. You\'ll get a plan, a timeline, and a quote — and you decide only when you can already picture the book.') }}</textarea>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold"><i class="bi bi-image me-1 text-primary"></i> Background Artwork Image</label>
                    <div class="row g-3 align-items-center">
                        <div class="col-auto">
                            <img id="pricing_cta_bg_preview" src="{{ asset(setting('pricing_cta_bg', 'assets/img/spread-under-stars.webp')) }}" alt="CTA Background Preview" width="120" height="60" class="rounded border object-fit-cover shadow-sm">
                        </div>
                        <div class="col">
                            <input type="file" class="form-control form-control-sm mb-1" name="pricing_cta_bg_file" accept="image/*" onchange="previewImg(this, 'pricing_cta_bg_preview')">
                            <input type="text" class="form-control form-control-sm" name="pricing_cta_bg" value="{{ setting('pricing_cta_bg', 'assets/img/spread-under-stars.webp') }}">
                            <div class="form-text" style="font-size: 0.74rem;"><span class="badge bg-secondary">Recommended</span> 1920&times;1080 px &bull; WEBP or JPG &bull; Max 3 MB</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-sm btn-primary fw-bold px-4">
                    <i class="bi bi-save me-1"></i> Save Pricing Page Settings &amp; CTA
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Pricing Tier Plans Table -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 font-weight-bold text-dark"><i class="bi bi-list-stars me-2 text-primary"></i> Pricing Tier Plans</h5>
        <span class="badge bg-primary rounded-pill px-3 py-1.5">{{ count($plans) }} Active Packages</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-3">Plan Name</th>
                        <th>Price</th>
                        <th>Duration</th>
                        <th>Features List</th>
                        <th>Popular</th>
                        <th>Status</th>
                        <th class="text-end pe-3" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($plans as $plan)
                        <tr>
                            <td class="ps-3 fw-semibold text-dark">{{ $plan->plan_name }}</td>
                            <td>₹{{ number_format($plan->price, 2) }}</td>
                            <td>{{ $plan->duration }}</td>
                            <td>
                                @if($plan->features)
                                    <ul class="mb-0 small ps-3">
                                        @foreach($plan->features as $feat)
                                            <li>{{ $feat }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td>
                                @if($plan->popular_plan)
                                    <span class="badge bg-warning text-dark py-1 px-2"><i class="bi bi-star-fill me-1"></i> Popular</span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge rounded-pill bg-{{ $plan->status === 'active' ? 'success' : 'secondary' }} py-1 px-2.5">
                                    {{ ucfirst($plan->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.pricing.edit', $plan) }}" class="btn btn-sm btn-outline-secondary me-1" title="Edit Plan">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.pricing.destroy', $plan) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this pricing plan?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Plan">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No pricing plans found. Click "Add Pricing Tier Plan" to create one.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($plans->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $plans->links() }}
        </div>
    @endif
</div>
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
