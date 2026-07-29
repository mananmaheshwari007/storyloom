@extends('layouts.admin')

@section('title', 'Default Book')

@section('content')
<div class="page-header">
    <h1 class="page-title">Default Book</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.blog.index') }}">Journal</a></li>
            <li class="breadcrumb-item active" aria-current="page">Default Book</li>
        </ol>
    </nav>
</div>

<div class="alert alert-light border d-flex gap-3 align-items-start">
    <i class="bi bi-info-circle text-primary fs-5"></i>
    <div>
        <strong>This is the book promoted on every article by default.</strong>
        <div class="text-muted small">
            Any article can override it in the editor. Changing it here updates every article
            that hasn't set its own — including ones already published.
        </div>
    </div>
</div>

<form action="{{ route('admin.blog.defaultBook.update') }}" method="POST">
    @csrf
    <div class="row g-4">

        {{-- In-article card --}}
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-book me-2 text-primary"></i> In-article book card</h5>
                    <div class="text-muted small mt-1">Sits inside the article body, after the story's turning point.</div>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-3 mb-3">
                        <img src="{{ str_starts_with($promo['cover'], 'http') ? $promo['cover'] : '/storyloom/' . ltrim($promo['cover'], '/') }}"
                             alt="" style="width:76px; aspect-ratio:3/4; object-fit:cover; border:1px solid #e4e7ec; border-radius:5px;">
                        <div class="flex-grow-1">
                            <label class="form-label">Cover image</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="promo[cover]" id="promoCover" value="{{ $promo['cover'] }}">
                                <button type="button" class="btn btn-outline-secondary" data-upload-for="promoCover"><i class="bi bi-upload"></i></button>
                            </div>
                            <div class="form-text">Max file size: <strong>5 MB</strong>. Recommended dimensions: <strong>900 × 1273 px</strong>.</div>
                        </div>
                    </div>

                    <label class="form-label">Heading</label>
                    <input type="text" class="form-control mb-3" name="promo[heading]" value="{{ $promo['heading'] }}">

                    <label class="form-label">Body text</label>
                    <textarea class="form-control mb-3" name="promo[body]" rows="4">{{ $promo['body'] }}</textarea>

                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label">Button text</label>
                            <input type="text" class="form-control" name="promo[cta_text]" value="{{ $promo['cta_text'] }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Button link</label>
                            <input type="text" class="form-control" name="promo[cta_url]" value="{{ $promo['cta_url'] }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar card --}}
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-bookmark-star me-2 text-warning"></i> Sidebar book card</h5>
                    <div class="text-muted small mt-1">The sticky card beside the article as people read.</div>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-3 mb-3">
                        <img src="{{ str_starts_with($sidebar['cover'], 'http') ? $sidebar['cover'] : '/storyloom/' . ltrim($sidebar['cover'], '/') }}"
                             alt="" style="width:76px; aspect-ratio:3/4; object-fit:cover; border:1px solid #e4e7ec; border-radius:5px;">
                        <div class="flex-grow-1">
                            <label class="form-label">Cover image</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="sidebar[cover]" id="sidebarCover" value="{{ $sidebar['cover'] }}">
                                <button type="button" class="btn btn-outline-secondary" data-upload-for="sidebarCover"><i class="bi bi-upload"></i></button>
                            </div>
                            <div class="form-text">Max file size: <strong>5 MB</strong>. Recommended dimensions: <strong>900 × 1273 px</strong>.</div>
                        </div>
                    </div>

                    <label class="form-label">Small label</label>
                    <input type="text" class="form-control mb-3" name="sidebar[label]" value="{{ $sidebar['label'] }}">

                    <label class="form-label">Heading</label>
                    <input type="text" class="form-control mb-3" name="sidebar[heading]" value="{{ $sidebar['heading'] }}">

                    <label class="form-label">Body text</label>
                    <textarea class="form-control mb-3" name="sidebar[body]" rows="3">{{ $sidebar['body'] }}</textarea>

                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label">Button text</label>
                            <input type="text" class="form-control" name="sidebar[cta_text]" value="{{ $sidebar['cta_text'] }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Button link</label>
                            <input type="text" class="form-control" name="sidebar[cta_url]" value="{{ $sidebar['cta_url'] }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i> Save default book</button>
            <button type="submit" name="restore" value="1" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-counterclockwise me-1"></i> Restore Storyloom original
            </button>
            <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary ms-auto">Back to Journal</a>
        </div>
    </div>
</form>

<input type="file" id="jwUploader" accept="image/*" hidden>
@endsection

@section('scripts')
<script>
(function () {
    var uploader = document.getElementById("jwUploader");
    var target = null;
    document.querySelectorAll("[data-upload-for]").forEach(function (btn) {
        btn.addEventListener("click", function () {
            target = document.getElementById(btn.getAttribute("data-upload-for"));
            uploader.value = "";
            uploader.click();
        });
    });
    uploader.addEventListener("change", function () {
        var file = uploader.files && uploader.files[0];
        if (!file || !target) return;
        var fd = new FormData();
        fd.append("file", file);
        var token = document.querySelector('meta[name="csrf-token"]')
            ? document.querySelector('meta[name="csrf-token"]').content
            : (document.querySelector('input[name="_token"]') || {}).value;
        fd.append("_token", token);
        fetch("{{ route('admin.blog.upload') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": token
            },
            body: fd
        })
            .then(function (r) { return r.json(); })
            .then(function (d) { if (d && d.url) { target.value = d.url; } else { alert("Upload failed."); } })
            .catch(function () { alert("Upload failed."); });
    });
})();
</script>
@endsection
