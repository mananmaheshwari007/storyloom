@extends('layouts.app')

@section('content')
  <!-- ================= HERO ================= -->
  <section class="section section-tint grain" style="padding-top: clamp(120px, 15vh, 180px); padding-bottom: clamp(60px, 8vh, 100px);">
    <div class="container-narrow">
      <div class="section-head center" style="margin-bottom: 0;">
        <p class="eyebrow eyebrow-center">{{ setting('faq_hero_eyebrow', 'Good questions') }}</p>
        <h1>{!! setting('faq_hero_heading', 'Frequently Asked <em>Questions.</em>') !!}</h1>
        <p class="lede">{{ setting('faq_hero_lede', 'Answers to questions about writing guides, references, drawing processes, proof prints, and shipping details.') }}</p>
      </div>
    </div>
  </section>

  <!-- ================= ACCORDION ================= -->
  <section class="section">
    <div class="container-narrow">
      <div class="faq-list">
        @forelse($faqs as $index => $faq)
          <div class="faq-item">
            <button class="faq-q" aria-expanded="false">
              <span>{{ $faq->question }}</span>
              <span class="faq-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M12 4v16M4 12h16"/></svg></span>
            </button>
            <div class="faq-a">
              <div>
                <p style="white-space: pre-wrap;">{{ $faq->answer }}</p>
              </div>
            </div>
          </div>
        @empty
          <div class="text-center py-5 text-muted">
            No questions found.
          </div>
        @endforelse
      </div>
    </div>
  </section>
@endsection
