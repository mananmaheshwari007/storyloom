@extends('layouts.admin')

@section('title', 'SEO Manager')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="page-title h3 mb-1"><i class="bi bi-search me-2 text-primary"></i> SEO Manager</h1>
        <p class="text-muted small mb-0">Search result titles, descriptions and share images for every page.</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">SEO</li>
        </ol>
    </nav>
</div>

<form action="{{ route('admin.seo.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card shadow-sm border-0 mb-4 bg-white sticky-top" style="top: 80px; z-index: 100;">
        <div class="card-body py-2 px-3 d-flex align-items-center justify-content-between">
            <span class="fw-bold text-dark small"><i class="bi bi-sliders me-1 text-primary"></i> Page SEO</span>
            <button type="submit" class="btn btn-sm btn-primary fw-bold px-4 py-1"><i class="bi bi-save me-1"></i> Save SEO</button>
        </div>
    </div>

    <div class="alert alert-light border small">
        <i class="bi bi-info-circle me-1 text-primary"></i>
        Leave a field as it is and the page keeps the wording it already has. Aim for roughly
        <strong>60 characters</strong> in a title and <strong>155</strong> in a description — Google truncates beyond that.
        Journal articles have their own SEO fields inside each article.
    </div>

    @foreach(\App\Support\Seo::PAGES as $key => $page)
        @php
            $title = setting("seo_{$key}_title", $page['title']);
            $desc  = setting("seo_{$key}_description", $page['description']);
            $kw    = setting("seo_{$key}_keywords", $page['keywords']);
            $img   = setting("seo_{$key}_image", '');
        @endphp
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0 py-3 d-flex align-items-center justify-content-between">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-file-earmark-text me-2 text-primary"></i> {{ $page['label'] }}</h5>
                <a href="{{ route($page['route']) }}" target="_blank" rel="noopener" class="small text-decoration-none">
                    View page <i class="bi bi-box-arrow-up-right ms-1"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Meta Title</label>
                            <input type="text" name="seo_{{ $key }}_title" class="form-control form-control-sm js-count" data-limit="60" value="{{ $title }}">
                            <div class="form-text js-count-out">{{ mb_strlen($title) }} characters</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Meta Description</label>
                            <textarea name="seo_{{ $key }}_description" rows="3" class="form-control form-control-sm js-count" data-limit="155">{{ $desc }}</textarea>
                            <div class="form-text js-count-out">{{ mb_strlen($desc) }} characters</div>
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-bold">Keywords</label>
                            <input type="text" name="seo_{{ $key }}_keywords" class="form-control form-control-sm" value="{{ $kw }}">
                            <div class="form-text">Comma separated. Carries little weight with Google these days, but harmless.</div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="p-3 border rounded bg-light h-100">
                            <label class="form-label fw-bold text-dark mb-1"><i class="bi bi-image me-1 text-primary"></i> Share Image</label>
                            <div class="mb-2 text-center">
                                <img src="{{ asset($img ?: setting('site_share_image', 'assets/img/spread-bench-dusk.webp')) }}"
                                     class="rounded border shadow-sm" style="max-height: 110px; width: 100%; object-fit: cover;" alt="">
                            </div>
                            <input type="file" name="seo_{{ $key }}_image_file" class="form-control form-control-sm mb-2" accept="image/*">
                            <input type="text" name="seo_{{ $key }}_image" class="form-control form-control-sm" value="{{ $img }}" placeholder="Blank = site default">
                            <div class="form-text">Shown when the page is shared on WhatsApp or social. 1200×630 works best.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</form>
@endsection

@section('scripts')
<script>
    /* Live character counts, so the limits above are actionable while typing. */
    document.querySelectorAll('.js-count').forEach(function (field) {
        var out = field.parentElement.querySelector('.js-count-out');
        var limit = parseInt(field.dataset.limit, 10);
        var render = function () {
            var n = field.value.length;
            out.textContent = n + ' characters' + (n > limit ? ' — over the ' + limit + ' Google shows' : '');
            out.classList.toggle('text-danger', n > limit);
        };
        field.addEventListener('input', render);
        render();
    });
</script>
@endsection
