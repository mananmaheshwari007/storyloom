@extends('layouts.admin')

@section('title', 'Begin a Story Page Manager')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="page-title h3 mb-1"><i class="bi bi-rocket-takeoff me-2 text-primary"></i> 9. Begin a Story Page Manager</h1>
        <p class="text-muted small mb-0">Manage copy, step prompts, and settings for the interactive story order builder page (/begin).</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Begin a Story</li>
        </ol>
    </nav>
</div>

<form action="{{ route('admin.begin.update') }}" method="POST">
    @csrf

    <div class="card shadow-sm border-0 mb-4 bg-white sticky-top" style="top: 80px; z-index: 100;">
        <div class="card-body py-2.5 px-3 d-flex align-items-center justify-content-between">
            <span class="fw-bold text-dark small"><i class="bi bi-sliders me-1.5 text-primary"></i> Begin Page CMS Controls</span>
            <button type="submit" class="btn btn-sm btn-primary fw-bold px-4 py-1.5">
                <i class="bi bi-save me-1.5"></i> Save Begin Page Changes
            </button>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Column -->
        <div class="col-lg-8">
            <!-- Hero Header Section -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 font-weight-bold text-dark"><i class="bi bi-fonts me-2 text-primary"></i> Page Hero Header</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Eyebrow / Subheading</label>
                        <input type="text" name="begin_hero_subheading" class="form-control" value="{{ setting('begin_hero_subheading', 'BEGIN YOUR STORYLOOM') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Main Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                        <input type="text" name="begin_hero_heading" class="form-control" value="{{ setting('begin_hero_heading', 'Tell us about the <em>person</em> you want to honor.') }}">
                        <div class="form-text">Supports HTML formatting tags like <code>&lt;em&gt;word&lt;/em&gt;</code> for brand italic accent or <code>&lt;br&gt;</code> for line breaks.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Page Description / Subtext</label>
                        <textarea name="begin_hero_description" class="form-control" rows="3">{{ setting('begin_hero_description', 'Answer a few simple questions or request a custom consultation to get started on your personalized keepsake storybook.') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Steps & Question Prompts -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 font-weight-bold text-dark"><i class="bi bi-list-task me-2 text-primary"></i> Questionnaire Step Titles</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Step 1 Prompt</label>
                        <input type="text" name="begin_step1_title" class="form-control" value="{{ setting('begin_step1_title', 'Who is this story for?') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Step 2 Prompt</label>
                        <input type="text" name="begin_step2_title" class="form-control" value="{{ setting('begin_step2_title', 'What is the occasion?') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Step 3 Prompt</label>
                        <input type="text" name="begin_step3_title" class="form-control" value="{{ setting('begin_step3_title', 'When is the story needed?') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Step 4 Prompt</label>
                        <input type="text" name="begin_step4_title" class="form-control" value="{{ setting('begin_step4_title', 'Your details') }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Options -->
        <div class="col-lg-4">
            <!-- Direct Order Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 font-weight-bold text-dark"><i class="bi bi-box-arrow-up-right me-2 text-primary"></i> Direct Assistance Card</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Card Title <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                        <input type="text" name="begin_direct_title" class="form-control" value="{{ setting('begin_direct_title', 'Prefer to speak with an <em>editor</em> directly?') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Card Subtitle / Hint</label>
                        <textarea name="begin_direct_sub" class="form-control" rows="2">{{ setting('begin_direct_sub', 'WhatsApp our studio or schedule a call with our team.') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contact Note / Studio Hours</label>
                        <textarea name="begin_contact_note" class="form-control" rows="2">{{ setting('begin_contact_note', 'We respond within 2 hours during studio hours (10 AM - 7 PM IST).') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
