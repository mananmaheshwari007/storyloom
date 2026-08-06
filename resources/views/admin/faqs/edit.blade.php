@extends('layouts.admin')

@section('title', 'Edit FAQ')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit FAQ</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.faqs.index') }}">FAQs</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit FAQ</li>
        </ol>
    </nav>
</div>

<div class="card shadow-sm max-w-4xl">
    <div class="card-body">
        <form action="{{ route('admin.faqs.update', $faq) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="question" class="form-label fw-bold">Question <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                <input type="text" class="form-control @error('question') is-invalid @enderror" id="question" name="question" value="{{ old('question', $faq->question) }}" required>
                <div class="form-text">Supports HTML formatting like <code>&lt;em&gt;word&lt;/em&gt;</code> for brand italic style.</div>
                @error('question')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="answer" class="form-label fw-bold">Answer <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                <textarea class="form-control @error('answer') is-invalid @enderror" id="answer" name="answer" rows="6" required>{{ old('answer', $faq->answer) }}</textarea>
                <div class="form-text">Supports HTML tags like <code>&lt;strong&gt;</code>, <code>&lt;a href="..."&gt;</code>, and paragraph line breaks.</div>
                @error('answer')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <datalist id="faq-sections">
                @foreach(\App\Models\Faq::sections() as $s)<option value="{{ $s }}">@endforeach
            </datalist>

            <div class="row g-3 mb-3">
                <div class="col-md-8">
                    <label for="section" class="form-label">Section</label>
                    <input type="text" list="faq-sections" class="form-control @error('section') is-invalid @enderror" id="section" name="section" value="{{ old('section', $faq->section ?: \App\Models\Faq::DEFAULT_SECTION) }}" placeholder="e.g. Shipping &amp; Delivery">
                    <div class="form-text">Pick an existing section or type a new name to create one. Questions sharing a name appear under one heading.</div>
                    @error('section')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="section_order" class="form-label">Section Order</label>
                    <input type="number" class="form-control @error('section_order') is-invalid @enderror" id="section_order" name="section_order" value="{{ old('section_order', $faq->section_order) }}">
                    <div class="form-text">Where this section sits on the page. Lower comes first.</div>
                    @error('section_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="display_order" class="form-label">Display Order <span class="text-muted">— within its section</span></label>
                    <input type="number" class="form-control @error('display_order') is-invalid @enderror" id="display_order" name="display_order" value="{{ old('display_order', $faq->display_order) }}" required>
                    @error('display_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="active" {{ old('status', $faq->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $faq->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary px-4 py-2"><i class="bi bi-save me-1"></i> Update FAQ</button>
            <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary px-4 py-2 ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
