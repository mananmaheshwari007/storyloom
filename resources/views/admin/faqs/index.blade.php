@extends('layouts.admin')

@section('title', '8. FAQ Page Manager')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="page-title h3 mb-1"><i class="bi bi-question-circle me-2 text-primary"></i> 8. FAQ Page Manager</h1>
        <p class="text-muted small mb-0">Manage 100% of hero copy, questions &amp; answers accordion items, and final CTA on the FAQ page (/faq).</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary shadow-sm" style="background-color: var(--primary-active); border-color: var(--primary-active);">
            <i class="bi bi-plus-lg me-1"></i> Add FAQ Question
        </a>
    </div>
</div>

<!-- FAQ Page Header & CTA Settings Card -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="card-title mb-0 font-weight-bold text-dark"><i class="bi bi-fonts me-2 text-primary"></i> FAQ Page Hero Header &amp; CTA Controls</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.faqs.settings') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- 1. Hero Header Section -->
            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-layout-text-window me-1 text-primary"></i> 1. Page Hero Header:</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Hero Eyebrow</label>
                    <input type="text" name="faq_hero_eyebrow" class="form-control form-control-sm" value="{{ setting('faq_hero_eyebrow', 'Good questions') }}">
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-bold">Hero Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                    <input type="text" name="faq_hero_heading" class="form-control form-control-sm" value="{{ setting('faq_hero_heading', 'Frequently Asked <em>Questions.</em>') }}">
                    <div class="form-text">Use <code>&lt;em&gt;text&lt;/em&gt;</code> for the custom script font accent.</div>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold">Hero Description / Lede</label>
                    <textarea name="faq_hero_lede" class="form-control form-control-sm" rows="2">{{ setting('faq_hero_lede', 'Answers to questions about writing guides, references, drawing processes, proof prints, and shipping details.') }}</textarea>
                </div>
            </div>

            <hr class="my-4">

            <!-- 2. FAQ Final CTA Banner Section -->
            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-megaphone me-1 text-danger"></i> 2. FAQ Page Final CTA Banner:</h6>
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label fw-bold">CTA Banner Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                    <input type="text" name="faq_cta_heading" class="form-control form-control-sm" value="{{ setting('faq_cta_heading', 'Have a question that\'s <em>not here?</em>') }}">
                    <div class="form-text">Supports HTML formatting tags like <code>&lt;em&gt;word&lt;/em&gt;</code> for brand terracotta italic script.</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Primary Button Text &amp; Link</label>
                    <div class="input-group input-group-sm">
                        <input type="text" name="faq_cta_btn1_text" class="form-control" value="{{ setting('faq_cta_btn1_text', 'BEGIN YOUR STORY') }}">
                        <input type="text" name="faq_cta_btn1_link" class="form-control" value="{{ setting('faq_cta_btn1_link', route('begin')) }}">
                    </div>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold">CTA Banner Description</label>
                    <textarea name="faq_cta_desc" class="form-control form-control-sm" rows="2">{{ setting('faq_cta_desc', 'Tell us about your story idea or ask anything directly — we reply personally to every inquiry.') }}</textarea>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold"><i class="bi bi-image me-1 text-primary"></i> Background Artwork Image</label>
                    <div class="row g-3 align-items-center">
                        <div class="col-auto">
                            <img id="faq_cta_bg_preview" src="{{ asset(setting('faq_cta_bg', 'assets/img/spread-home-evening.webp')) }}" alt="CTA Background Preview" width="120" height="60" class="rounded border object-fit-cover shadow-sm">
                        </div>
                        <div class="col">
                            <input type="file" class="form-control form-control-sm mb-1" name="faq_cta_bg_file" accept="image/*" onchange="previewImg(this, 'faq_cta_bg_preview')">
                            <input type="text" class="form-control form-control-sm" name="faq_cta_bg" value="{{ setting('faq_cta_bg', 'assets/img/spread-home-evening.webp') }}">
                            <div class="form-text" style="font-size: 0.74rem;"><span class="badge bg-secondary">Recommended</span> 1920&times;1080 px &bull; WEBP or JPG &bull; Max 3 MB</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-sm btn-primary fw-bold px-4">
                    <i class="bi bi-save me-1"></i> Save FAQ Page Header &amp; CTA Settings
                </button>
            </div>
        </form>
    </div>
</div>

<!-- FAQ Accordion Items Table -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 font-weight-bold text-dark"><i class="bi bi-list-nested me-2 text-primary"></i> FAQ Accordion Questions</h5>
        <span class="badge bg-primary rounded-pill px-3 py-1.5">{{ count($faqs) }} Active Questions</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-3" style="width: 80px;">Order</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Status</th>
                        <th class="text-end pe-3" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $currentSection = null; @endphp
                    @forelse($faqs as $faq)
                        @php $thisSection = trim((string) $faq->section) ?: \App\Models\Faq::DEFAULT_SECTION; @endphp
                        @if($thisSection !== $currentSection)
                            @php $currentSection = $thisSection; @endphp
                            {{-- Section header row, so the list here reads in the
                                 same groups a visitor sees on the page. --}}
                            <tr class="table-light">
                                <td colspan="5" class="ps-3 py-2 fw-bold text-dark">
                                    <i class="bi bi-collection me-1 text-primary"></i>{{ $thisSection }}
                                    <span class="text-muted fw-normal small ms-2">section order {{ $faq->section_order }}</span>
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td class="ps-3 fw-bold">{{ $faq->display_order }}</td>
                            <td class="fw-semibold text-dark">{!! $faq->question !!}</td>
                            <td><small class="text-muted">{{ Str::limit(strip_tags($faq->answer), 90) }}</small></td>
                            <td>
                                <span class="badge rounded-pill bg-{{ $faq->status === 'active' ? 'success' : 'secondary' }} py-1 px-2.5">
                                    {{ ucfirst($faq->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-sm btn-outline-secondary me-1" title="Edit FAQ">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this FAQ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete FAQ">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No FAQ items found. Click "Add FAQ Question" to create one.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{-- Not paginated any more: sections only make sense with the whole set on
         one screen, so the pager was removed with the grouping. --}}
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
