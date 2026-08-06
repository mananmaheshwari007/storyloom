@extends('layouts.app')

@section('content')
  <!-- ================= HERO ================= -->
  <section class="section section-tint grain" style="padding-top: clamp(120px, 15vh, 180px); padding-bottom: clamp(60px, 8vh, 100px);">
    <div class="container-narrow">
      <div class="section-head center" style="margin-bottom: 0;">
        <p class="eyebrow eyebrow-center" data-reveal>{{ setting('faq_hero_eyebrow', 'Good questions') }}</p>
        <h1 data-reveal>{!! setting('faq_hero_heading', 'Frequently Asked <em>Questions.</em>') !!}</h1>
        <p class="lede" data-reveal>{{ setting('faq_hero_lede', 'Answers to questions about writing guides, references, drawing processes, proof prints, and shipping details.') }}</p>
      </div>
    </div>
  </section>

  <!-- ================= ACCORDION ================= -->
  <section class="section">
    <div class="container-narrow">
      @php $faqGroups = \App\Models\Faq::grouped(); @endphp

      @forelse($faqGroups as $sectionName => $sectionFaqs)
        {{-- A single unnamed group would just be a redundant heading over the
             whole list, so the label only appears once there is more than one. --}}
        <div class="faq-group">
          @if($faqGroups->count() > 1)
            <h2 class="faq-group-title" id="faq-{{ Str::slug($sectionName) }}" data-reveal>{{ $sectionName }}</h2>
          @endif

          <div class="faq-list">
            @foreach($sectionFaqs as $index => $faq)
              <div class="faq-item" data-reveal style="--stagger:{{ $index % 4 }}">
                <button class="faq-q" aria-expanded="false">
                  <span>{!! $faq->question !!}</span>
                  <span class="faq-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M12 4v16M4 12h16"/></svg></span>
                </button>
                <div class="faq-a">
                  <div>
                    <p style="white-space: pre-line;">{!! $faq->answer !!}</p>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @empty
        <div class="text-center py-5 text-muted">
          No questions found.
        </div>
      @endforelse
    </div>
  </section>

  <!-- ================= FINAL CTA ================= -->
  <section class="final-cta">
    <div class="bg" style="background-image:url('{{ asset(setting('faq_cta_bg', 'assets/img/spread-home-evening.webp')) }}')" role="img" aria-label="Illustration of a cozy evening with a Storyloom book"></div>
    <div class="container inner">
      <h2 data-reveal>{!! setting('faq_cta_heading', 'Have a question that\'s <em style="font-family: \'Cormorant Garamond\', Cormorant, Georgia, serif; font-style: italic; font-weight: 500; color: #E88B52;">not here?</em>') !!}</h2>
      <p data-reveal style="max-width: 620px; width: 100%; margin-inline: auto; font-size: 1.05rem; line-height: 1.65; color: rgba(255, 255, 255, 0.78);">
        {!! setting('faq_cta_desc', 'Tell us about your story idea or ask anything directly — we reply personally to every inquiry.') !!}
      </p>
      <div class="btn-row" style="justify-content:center; gap: 16px; margin-top: 28px;" data-reveal>
        <a class="btn btn-primary" href="{{ setting('faq_cta_btn1_link', route('begin')) }}">{{ setting('faq_cta_btn1_text', 'BEGIN YOUR STORY') }}
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
        </a>
      </div>
    </div>
  </section>
@endsection
