@extends('layouts.admin')

@section('title', '5. Journal Page Manager')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="page-title h3 mb-1"><i class="bi bi-journal-text me-2 text-primary"></i> 5. Journal Page Manager</h1>
        <p class="text-muted small mb-0">Manage journal hero copy, articles list, default reader book, newsletter band, and final CTA on the Journal page (/journal).</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.blog.defaultBook') }}" class="btn btn-outline-primary btn-sm fw-bold">
            <i class="bi bi-book-half me-1"></i> Default Reader Book
        </a>
        <a href="{{ route('admin.blog.create') }}" class="btn btn-primary shadow-sm" style="background-color: var(--primary-active); border-color: var(--primary-active);">
            <i class="bi bi-plus-lg me-1"></i> Write New Article
        </a>
    </div>
</div>

<!-- Journal Header, Newsletter & Final CTA Settings Card -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="card-title mb-0 font-weight-bold text-dark"><i class="bi bi-fonts me-2 text-primary"></i> Journal Page Hero Header, Newsletter &amp; Final CTA Controls</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.blog.settings') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- 1. Hero Header Section -->
            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-layout-text-window me-1 text-primary"></i> 1. Journal Hero Intro Header:</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Hero Eyebrow</label>
                    <input type="text" name="journal_hero_eyebrow" class="form-control form-control-sm" value="{{ setting('journal_hero_eyebrow', 'The Storyloom Journal') }}">
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-bold">Hero Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                    <input type="text" name="journal_hero_heading" class="form-control form-control-sm" value="{{ setting('journal_hero_heading', 'Notes on giving <em>better.</em>') }}">
                    <div class="form-text">Use <code>&lt;em&gt;text&lt;/em&gt;</code> for the custom script font accent.</div>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold">Hero Description / Lede</label>
                    <textarea name="journal_hero_lede" class="form-control form-control-sm" rows="2">{{ setting('journal_hero_lede', 'Gift ideas that aren\'t a scented candle, real stories from the families we\'ve made books for, and what actually happens at the loom. Short reads, mostly.') }}</textarea>
                </div>
            </div>

            <hr class="my-4">

            <!-- 2. Newsletter Band Controls -->
            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-envelope-paper me-1 text-primary"></i> 2. "The Loom Letter" Newsletter Band:</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Newsletter Eyebrow</label>
                    <input type="text" name="newsletter_eyebrow" class="form-control form-control-sm" value="{{ setting('newsletter_eyebrow', 'The Loom Letter') }}">
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-bold">Newsletter Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                    <input type="text" name="newsletter_heading" class="form-control form-control-sm" value="{{ setting('newsletter_heading', 'One good gift idea, <em>once a month.</em>') }}">
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-bold">Newsletter Sub-description</label>
                    <textarea name="newsletter_desc" class="form-control form-control-sm" rows="2">{{ setting('newsletter_desc', 'No sale blasts. Just one thoughtful idea, one real family story, and a heads-up before the occasions that sneak up on everyone.') }}</textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Subscribe Button Label</label>
                    <input type="text" name="newsletter_btn" class="form-control form-control-sm" value="{{ setting('newsletter_btn', 'Send it to me') }}">
                    <label class="form-label fw-bold mt-2">Privacy Disclaimer Note</label>
                    <input type="text" name="newsletter_note" class="form-control form-control-sm" value="{{ setting('newsletter_note', 'Unsubscribe in one click. We never share your email.') }}">
                </div>
            </div>

            <hr class="my-4">

            <!-- 3. Final CTA Banner Controls -->
            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-megaphone me-1 text-danger"></i> 3. Journal Page Final CTA Banner:</h6>
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label fw-bold">CTA Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                    <input type="text" name="journal_cta_heading" class="form-control form-control-sm" value="{{ setting('journal_cta_heading', 'Reading about it is nice. <em style="color:#E88B52;">Holding it</em> is better.') }}">
                    <div class="form-text">Supports HTML formatting tags like <code>&lt;em style="..."&gt;word&lt;/em&gt;</code> for brand terracotta italic script.</div>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold">CTA Description</label>
                    <textarea name="journal_cta_desc" class="form-control form-control-sm" rows="2">{{ setting('journal_cta_desc', 'Every book in our library started with someone who wasn\'t sure where to begin. One memory is enough to start.') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Primary Button Text &amp; Link</label>
                    <div class="input-group input-group-sm">
                        <input type="text" name="journal_cta_btn1_text" class="form-control" value="{{ setting('journal_cta_btn1_text', 'BEGIN YOUR STORY') }}">
                        <input type="text" name="journal_cta_btn1_link" class="form-control" value="{{ setting('journal_cta_btn1_link', route('begin')) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Secondary Button Text &amp; Link</label>
                    <div class="input-group input-group-sm">
                        <input type="text" name="journal_cta_btn2_text" class="form-control" value="{{ setting('journal_cta_btn2_text', 'Read a Storyloom') }}">
                        <input type="text" name="journal_cta_btn2_link" class="form-control" value="{{ setting('journal_cta_btn2_link', route('library')) }}">
                    </div>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold"><i class="bi bi-image me-1 text-primary"></i> Background Artwork Image</label>
                    <div class="row g-3 align-items-center">
                        <div class="col-auto">
                            <img id="journal_cta_bg_preview" src="{{ asset(setting('journal_cta_bg_image', 'assets/img/spread-under-stars.webp')) }}" alt="Background Preview" width="120" height="60" class="rounded border object-fit-cover shadow-sm">
                        </div>
                        <div class="col">
                            <input type="file" class="form-control form-control-sm mb-1" name="journal_cta_bg_image_file" accept="image/*" onchange="previewImg(this, 'journal_cta_bg_preview')">
                            <input type="text" class="form-control form-control-sm" name="journal_cta_bg_image" value="{{ setting('journal_cta_bg_image', 'assets/img/spread-under-stars.webp') }}">
                            <div class="form-text" style="font-size: 0.74rem;"><span class="badge bg-secondary">Recommended</span> 1920&times;1080 px &bull; WEBP or JPG &bull; Max 3 MB</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-sm btn-primary fw-bold px-4">
                    <i class="bi bi-save me-1"></i> Save Journal Page Settings &amp; CTA
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Articles Table -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 font-weight-bold text-dark"><i class="bi bi-journal-text me-2 text-primary"></i> Journal Articles</h5>
        <span class="badge bg-primary rounded-pill px-3 py-1.5">{{ count($blogs) }} Articles</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-3" style="width: 90px;">Cover</th>
                        <th>Article Title / Slug</th>
                        <th>Topic / Category</th>
                        <th>Short Description</th>
                        <th>Status</th>
                        <th class="text-end pe-3" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blogs as $blog)
                        <tr>
                            <td class="ps-3">
                                <div class="border rounded bg-white overflow-hidden text-center" style="width: 60px; height: 45px;">
                                    @php $cover = $blog->featured_image ?: 'assets/img/spread-bench-dusk.webp'; @endphp
                                    <img src="{{ (str_starts_with($cover, 'data:') || str_starts_with($cover, 'http')) ? $cover : asset($cover) }}" alt="{{ $blog->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $blog->title }}</div>
                                <code style="font-size: 0.78rem;">{{ $blog->slug }}</code>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $blog->category_label }}</span>
                            </td>
                            <td class="text-muted small">{{ Str::limit($blog->short_description ?: strip_tags($blog->dek), 60) }}</td>
                            <td>
                                <span class="badge rounded-pill bg-{{ $blog->status === 'published' ? 'success' : 'secondary' }} py-1 px-2.5">
                                    {{ ucfirst($blog->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.blog.edit', $blog) }}" class="btn btn-sm btn-outline-secondary me-1" title="Edit Article">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.blog.destroy', $blog) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this article?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Article">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No journal articles found. Click "Write New Article" to create one.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($blogs->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $blogs->links() }}
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
