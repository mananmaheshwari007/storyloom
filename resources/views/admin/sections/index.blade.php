@extends('layouts.admin')

@section('title', 'Page Sections')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="page-title h3 mb-1"><i class="bi bi-eye me-2 text-primary"></i> Page Sections</h1>
        <p class="text-muted small mb-0">Switch any section of any page on or off.</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Page Sections</li>
        </ol>
    </nav>
</div>

<form action="{{ route('admin.sections.update') }}" method="POST">
    @csrf

    <div class="card shadow-sm border-0 mb-4 bg-white sticky-top" style="top: 80px; z-index: 100;">
        <div class="card-body py-2 px-3 d-flex align-items-center justify-content-between">
            <span class="fw-bold text-dark small"><i class="bi bi-sliders me-1 text-primary"></i> Section Visibility</span>
            <button type="submit" class="btn btn-sm btn-primary fw-bold px-4 py-1"><i class="bi bi-save me-1"></i> Save Visibility</button>
        </div>
    </div>

    <div class="alert alert-light border small">
        <i class="bi bi-info-circle me-1 text-primary"></i>
        Everything is on by default. Switch a section off and it disappears from the page — the sections around it
        close up, and on the homepage the background shading re-orders itself so no two tinted bands end up touching.
        Page headers, the navigation and the footer are always shown.
    </div>

    <div class="row g-4">
        @foreach(\App\Support\Sections::PAGES as $pageKey => $page)
            @php
                $total = count($page['sections']);
                $hidden = collect(array_keys($page['sections']))
                    ->filter(fn ($k) => ! \App\Support\Sections::enabled($k))
                    ->count();
            @endphp
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-0 py-3 d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="bi bi-file-earmark me-2 text-primary"></i>{{ $page['label'] }}
                            @if($hidden)
                                <span class="badge bg-warning text-dark ms-2">{{ $hidden }} of {{ $total }} hidden</span>
                            @endif
                        </h5>
                        <a href="{{ route($page['route']) }}" target="_blank" rel="noopener" class="small text-decoration-none">
                            View <i class="bi bi-box-arrow-up-right ms-1"></i>
                        </a>
                    </div>
                    <div class="card-body pt-0">
                        @foreach($page['sections'] as $key => $label)
                            @php
                                $on = \App\Support\Sections::enabled($key);
                                $critical = in_array($key, \App\Support\Sections::CRITICAL, true);
                            @endphp
                            <div class="form-check form-switch border-bottom py-2 ps-5">
                                <input type="hidden" name="section_{{ $key }}" value="0">
                                <input class="form-check-input" type="checkbox" role="switch"
                                       id="sec_{{ $key }}" name="section_{{ $key }}" value="1" {{ $on ? 'checked' : '' }}>
                                <label class="form-check-label small fw-semibold" for="sec_{{ $key }}">
                                    {{ $label }}
                                    @if($critical)
                                        <i class="bi bi-exclamation-triangle-fill text-warning ms-1"
                                           title="This is the main content of the page — hiding it leaves the page nearly empty."></i>
                                    @endif
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</form>
@endsection
