@extends('layouts.admin')

@section('title', 'Edit About Section')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit About Section</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">About Section</li>
        </ol>
    </nav>
</div>

<form action="{{ route('admin.about.update') }}" method="POST">
    @csrf
    <div class="row g-4">
        <div class="col-lg-8">
            <!-- About Content -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-file-person me-2 text-primary"></i> About Storyloom</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="heading" class="form-label">Heading (supports HTML tags like &lt;em&gt;)</label>
                        <input type="text" class="form-control" id="heading" name="heading" value="{{ old('heading', $about->heading) }}" required>
                        <small class="text-muted">Use <code>&lt;em&gt;text&lt;/em&gt;</code> for the custom script font styling.</small>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Main Description Paragraphs</label>
                        <textarea class="form-control" id="description" name="description" rows="6" required>{{ old('description', $about->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="experience_years" class="form-label">Years of Experience / Activity</label>
                        <input type="number" class="form-control" id="experience_years" name="experience_years" value="{{ old('experience_years', $about->experience_years) }}">
                    </div>
                </div>
            </div>

            <!-- Stats and Skills -->
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-bar-chart me-2 text-success"></i> Skills & Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label fw-bold d-block">Statistics Counter Cards (3 items)</label>
                        <div class="row g-3">
                            @for($i = 0; $i < 3; $i++)
                                @php
                                    $statVal = isset($about->statistics[$i]) ? $about->statistics[$i] : ['number' => '', 'label' => ''];
                                @endphp
                                <div class="col-md-4">
                                    <div class="p-3 border rounded">
                                        <div class="mb-2">
                                            <label class="form-label small">Stat #{{ $i + 1 }} Number (e.g. 1000+)</label>
                                            <input type="text" class="form-control form-control-sm" name="statistics[{{ $i }}][number]" value="{{ $statVal['number'] }}">
                                        </div>
                                        <div>
                                            <label class="form-label small">Stat #{{ $i + 1 }} Label (e.g. Stories Painted)</label>
                                            <input type="text" class="form-control form-control-sm" name="statistics[{{ $i }}][label]" value="{{ $statVal['label'] }}">
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Company Skills List</label>
                        <div class="row g-2">
                            @for($s = 0; $s < 4; $s++)
                                @php
                                    $skillVal = isset($about->skills[$s]) ? $about->skills[$s] : '';
                                @endphp
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="skills[{{ $s }}]" value="{{ $skillVal }}" placeholder="Skill #{{ $s + 1 }}">
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Image Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-image me-2 text-warning"></i> Image Asset</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="image" class="form-label">Featured Image Path</label>
                        <input type="text" class="form-control mb-2" id="image" name="image" value="{{ old('image', $about->image) }}">
                        @if($about->image)
                            <div class="p-2 border rounded bg-light text-center">
                                <img src="{{ asset($about->image) }}" alt="About Preview" class="img-fluid" style="max-height: 140px;">
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary w-100 py-2.5">
                        <i class="bi bi-save me-2"></i> Save Section Details
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
