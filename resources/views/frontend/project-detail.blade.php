@extends('layouts.app')

@section('seo')
  <x-seo-tags 
    :title="$project->title . ' | Storyloom Portfolio'"
    :description="$project->description ? \Illuminate\Support\Str::limit(strip_tags($project->description), 160) : $project->title"
    :ogImage="$project->image ?: 'assets/img/spread-bench-dusk.webp'"
    ogType="article"
  />
@endsection

@section('content')
  <section class="page-hero container">
    <p class="eyebrow eyebrow-center" data-reveal><a href="{{ route('library') }}">Library</a> · Keepsake Book</p>
    <h1 data-reveal>{{ $project->title }}</h1>
    <p class="lede" data-reveal style="font-size: 1rem; margin-top: 10px; color: var(--ink-faint);">{{ $project->category }}</p>
  </section>

  <section class="section grain" style="padding-top: clamp(16px, 3vh, 40px);">
    <div class="container" style="max-width: 900px;" data-reveal>
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; align-items: center; margin-bottom: 40px;">
        <div>
          <img src="{{ asset($project->image) }}" style="width: 100%; border-radius: 4px; box-shadow: var(--shadow-lift);" alt="{{ $project->title }}">
        </div>
        <div>
          <h2 style="font-size: 2rem; margin-bottom: 15px;">Project Details</h2>
          <p style="color: var(--ink-soft); line-height: 1.6; margin-bottom: 20px;">{{ $project->description }}</p>
          
          <ul style="list-style: none; padding: 0; display: grid; gap: 10px; font-size: 0.95rem;">
            <li><strong>Client Name:</strong> {{ $project->client_name ?: '—' }}</li>
            @if($project->completion_date)
              <li><strong>Completion Date:</strong> {{ $project->completion_date->format('F d, Y') }}</li>
            @endif
            @if($project->project_url)
              <li><strong>Project Link:</strong> <a href="{{ $project->project_url }}" target="_blank" style="color: var(--terra); text-decoration: underline;">Visit Project</a></li>
            @endif
            @if(!empty($project->technologies_used))
              <li><strong>Medium &amp; Craft:</strong> {{ implode(', ', $project->technologies_used) }}</li>
            @endif
          </ul>
        </div>
      </div>
    </div>
  </section>
@endsection
