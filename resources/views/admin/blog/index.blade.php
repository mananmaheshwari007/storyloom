@extends('layouts.admin')

@section('title', '5. Journal Page Manager')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="page-title h3 mb-1"><i class="bi bi-journal-text me-2 text-primary"></i> 5. Journal Page Manager</h1>
        <p class="text-muted small mb-0">Manage journal hero copy, articles list, default reader book, and newsletter CTA band on the Journal page (/journal).</p>
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

<!-- Journal Header & Newsletter CTA Settings Card -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="card-title mb-0 font-weight-bold text-dark"><i class="bi bi-fonts me-2 text-primary"></i> Journal Page Hero Header &amp; Newsletter CTA Band</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.blog.settings') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Hero Eyebrow</label>
                    <input type="text" name="blog_hero_eyebrow" class="form-control form-control-sm" value="{{ setting('blog_hero_eyebrow', 'STORYLOOM JOURNAL') }}">
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-bold">Hero Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                    <input type="text" name="blog_hero_heading" class="form-control form-control-sm" value="{{ setting('blog_hero_heading', 'Stories, essays &amp; <em>notes</em> on memory.') }}">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold">Hero Description / Lede</label>
                    <textarea name="blog_hero_lede" class="form-control form-control-sm" rows="2">{{ setting('blog_hero_lede', 'Reflections on gift-giving, preserving family histories, and making things that outlast us.') }}</textarea>
                </div>
            </div>

            <hr class="my-4">

            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-envelope-paper me-1 text-primary"></i> Article Newsletter / CTA Band Controls:</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Newsletter Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                    <input type="text" name="blog_newsletter_heading" class="form-control form-control-sm" value="{{ setting('blog_newsletter_heading', 'Get new notes in your <em>inbox.</em>') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Subscribe Button Text</label>
                    <input type="text" name="blog_newsletter_btn" class="form-control form-control-sm" value="{{ setting('blog_newsletter_btn', 'SUBSCRIBE') }}">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold">Newsletter Sub-description</label>
                    <textarea name="blog_newsletter_sub" class="form-control form-control-sm" rows="2">{{ setting('blog_newsletter_sub', 'Short reflections on memory, gifts, and family — sent twice a month. No spam ever.') }}</textarea>
                </div>
            </div>

            <div class="mt-3 text-end">
                <button type="submit" class="btn btn-sm btn-primary fw-bold px-4">
                    <i class="bi bi-save me-1"></i> Save Journal Header &amp; CTA Settings
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
                                    @if($blog->featured_image)
                                        <img src="{{ asset($blog->featured_image) }}" alt="Featured" style="max-height: 100%; max-width: 100%; object-fit: cover;">
                                    @else
                                        <i class="bi bi-image text-muted fs-4"></i>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $blog->title }}</div>
                                <code style="font-size: 0.78rem;">{{ $blog->slug }}</code>
                            </td>
                            <td class="text-muted small">{{ Str::limit($blog->short_description, 60) }}</td>
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
                            <td colspan="5" class="text-center py-4 text-muted">No journal articles found. Click "Write New Article" to create one.</td>
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
