@extends('layouts.admin')

@section('title', 'Edit Blog Article')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Blog Article</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.blog.index') }}">Blog</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Article</li>
        </ol>
    </nav>
</div>

<form action="{{ route('admin.blog.update', $blog) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="row g-4">
        <!-- Main Form Column -->
        <div class="col-lg-8 col-xl-9">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-pencil-square me-2 text-primary"></i> Article Content</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Article Title</label>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="titleEmBtn" title="Emphasise selection">
                                    <em>Em</em>
                                </button>
                                <span class="text-muted" style="font-size:.78rem;">Select a word and press <strong>Em</strong> to give it the terracotta accent.</span>
                            </div>
                            <div id="titleRich" contenteditable="true"
                                 class="form-control @error('title') is-invalid @enderror"
                                 style="min-height:48px; font-family:'Cormorant Garamond',Georgia,serif; font-size:1.35rem; line-height:1.3;">{!! old('title_html', $blog->title_html ?? e($blog->title ?? '')) !!}</div>
                            <input type="hidden" id="title" name="title" value="{{ old('title', $blog->title ?? '') }}">
                            <input type="hidden" id="titleHtmlField" name="title_html" value="{{ old('title_html', $blog->title_html ?? '') }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $blog->slug) }}" required>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="short_description" class="form-label">Short Summary Description</label>
                        <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description" name="short_description" rows="2">{{ old('short_description', $blog->short_description) }}</textarea>
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="category_select" class="form-label">Topic / Category Tag</label>
                            @php
                                $currentCat = old('category', $blog->category ?? 'gifts');
                                $isStandardCat = array_key_exists($currentCat, \App\Models\Blog::CATEGORIES);
                                $selectedOption = $isStandardCat ? $currentCat : ($currentCat ? 'custom' : 'gifts');
                            @endphp
                            <select class="form-select mb-2" id="category_select" onchange="toggleCustomCategory(this)">
                                @foreach(\App\Models\Blog::CATEGORIES as $key => $label)
                                    <option value="{{ $key }}" {{ $selectedOption === $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                                <option value="custom" {{ $selectedOption === 'custom' ? 'selected' : '' }}>Custom / Enter your own...</option>
                            </select>

                            <div id="custom_category_wrapper" class="{{ $selectedOption === 'custom' ? '' : 'd-none' }}">
                                <input type="text" class="form-control" id="custom_category_input" placeholder="Type custom topic (e.g. Special Feature)"
                                       value="{{ !$isStandardCat ? $currentCat : '' }}">
                            </div>

                            <input type="hidden" id="category" name="category" value="{{ $currentCat }}">
                            <div class="form-text">Select a topic category or enter your own custom text.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="read_time" class="form-label">Reading Time Tag</label>
                            <input type="text" class="form-control" id="read_time" name="read_time"
                                   value="{{ old('read_time', $blog->read_time ?? '') }}" placeholder="6 MIN READ">
                            <div class="form-text">e.g. 6 MIN READ (leave blank to calculate automatically).</div>
                        </div>
                        <div class="col-md-12">
                            <label for="dek" class="form-label">Standfirst Sub-headline</label>
                            <input type="text" class="form-control" id="dek" name="dek" value="{{ old('dek', $blog->dek ?? '') }}">
                            <div class="form-text">The dek line directly under the main headline.</div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Article Body</label>
                        @include('admin.blog.partials.editor')
                        @error('blocks')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- SEO Tags Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-search me-2 text-info"></i> SEO Configuration (Optional)</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="meta_title" class="form-label">SEO Title</label>
                        <input type="text" class="form-control" id="meta_title" name="meta_title" value="{{ old('meta_title', $blog->meta_title) }}">
                    </div>
                    <div class="mb-3">
                        <label for="meta_description" class="form-label">SEO Description</label>
                        <textarea class="form-control" id="meta_description" name="meta_description" rows="2">{{ old('meta_description', $blog->meta_description) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="keywords" class="form-label">SEO Keywords</label>
                        <input type="text" class="form-control" id="keywords" name="keywords" value="{{ old('keywords', $blog->keywords) }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Options Column -->
        <div class="col-lg-4 col-xl-3">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-image me-2 text-warning"></i> Cover Media</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="featured_image_file" class="form-label">Upload New Cover Image (Optional)</label>
                        <input type="file" class="form-control mb-2" id="featured_image_file" name="featured_image_file" accept="image/*">
                        <div class="form-text mb-2">Max file size: <strong>3 MB</strong>. Recommended dimensions: <strong>1600 × 900 px</strong> (Landscape 16:9).</div>
                        @if($blog->featured_image)
                            <div class="mt-2 text-muted" style="font-size: 0.85rem;">
                                Current Cover: <code>{{ $blog->featured_image }}</code>
                                <div class="mt-1"><img src="{{ asset($blog->featured_image) }}" alt="Preview" height="80" class="border rounded"></div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-gear me-2 text-secondary"></i> Status</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Publishing Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="draft" {{ old('status', $blog->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $blog->status) === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>
                </div>
            </div>


            <div class="mb-4">
                @include('admin.blog.partials.rail')
            </div>
            <div class="card shadow-sm">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary w-100 py-2.5">
                        <i class="bi bi-save me-2"></i> Update Article
                    </button>
                    <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary w-100 mt-2 py-2.5">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('styles')
@include('admin.blog.partials.editor-styles')
@endsection

@section('scripts')
@include('admin.blog.partials.editor-scripts')
<script>
function toggleCustomCategory(selectElem) {
    const wrapper = document.getElementById('custom_category_wrapper');
    const customInput = document.getElementById('custom_category_input');
    const hiddenInput = document.getElementById('category');

    if (selectElem.value === 'custom') {
        wrapper.classList.remove('d-none');
        customInput.focus();
        hiddenInput.value = customInput.value.trim();
    } else {
        wrapper.classList.add('d-none');
        hiddenInput.value = selectElem.value;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const customInput = document.getElementById('custom_category_input');
    if (customInput) {
        customInput.addEventListener('input', function() {
            const hiddenInput = document.getElementById('category');
            const selectElem = document.getElementById('category_select');
            if (selectElem.value === 'custom') {
                hiddenInput.value = this.value.trim();
            }
        });
    }
});
</script>
@endsection
