@extends('layouts.app')

@section('seo')
  <x-seo-tags 
    title="Good Questions — FAQ | Storyloom"
    description="Answers to questions about writing, image references, international shipping, print proof reviews, and pricing packages."
    keywords="storyloom FAQ, custom book questions, shipping info, memory reference photos"
    ogImage="assets/img/spread-street-morning.webp"
  />
@endsection

@section('content')

  <section class="page-hero container">
    <p class="eyebrow eyebrow-center" data-reveal>Questions &amp; answers</p>
    <h1 data-reveal>Ask us <em>anything.</em></h1>
    <p class="lede" data-reveal>The honest answers to everything families ask before they begin. If yours isn't here, <a href="{{ route('begin') }}" style="color:var(--terra-deep); text-decoration:underline;">write to us</a> — a real person replies.</p>
  </section>

  @php
    $faqs = \App\Models\Faq::where('status', true)->orderBy('display_order')->get();
    $generalFaqs = $faqs->where('category', 'general');
    $shippingFaqs = $faqs->where('category', 'shipping');
    $refundsFaqs = $faqs->where('category', 'refunds');
  @endphp

  <!-- The story -->
  <section class="section grain" style="padding-top: clamp(16px, 3vh, 40px);">
    <div class="container-narrow">
      <div class="section-head" data-reveal>
        <p class="eyebrow">The story</p>
        <h2 style="font-size:clamp(1.7rem,3vw,2.3rem);">Writing &amp; illustrating</h2>
      </div>
      <div class="faq-list" data-reveal>
        @foreach($generalFaqs as $faq)
          <div class="faq-item">
            <button class="faq-q"><span>{{ $faq->question }}</span>
              <span class="faq-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M12 4v16M4 12h16"/></svg></span></button>
            <div class="faq-a"><div><p>{{ $faq->answer }}</p></div></div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Shipping -->
  <section class="section section-tint grain" id="shipping">
    <div class="container-narrow">
      <div class="section-head" data-reveal>
        <p class="eyebrow">Shipping</p>
        <h2 style="font-size:clamp(1.7rem,3vw,2.3rem);">Delivery &amp; timelines</h2>
      </div>
      <div class="faq-list" data-reveal>
        @foreach($shippingFaqs as $faq)
          <div class="faq-item">
            <button class="faq-q"><span>{{ $faq->question }}</span>
              <span class="faq-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M12 4v16M4 12h16"/></svg></span></button>
            <div class="faq-a"><div><p>{{ $faq->answer }}</p></div></div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Refunds -->
  <section class="section grain" id="refunds">
    <div class="container-narrow">
      <div class="section-head" data-reveal>
        <p class="eyebrow">Refunds</p>
        <h2 style="font-size:clamp(1.7rem,3vw,2.3rem);">Cancellations &amp; corrections</h2>
      </div>
      <div class="faq-list" data-reveal>
        @foreach($refundsFaqs as $faq)
          <div class="faq-item">
            <button class="faq-q"><span>{{ $faq->question }}</span>
              <span class="faq-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M12 4v16M4 12h16"/></svg></span></button>
            <div class="faq-a"><div><p>{{ $faq->answer }}</p></div></div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <section class="final-cta">
    <div class="bg" style="background-image:url('{{ asset('assets/img/spread-night-farewell.webp') }}')" role="img"
         aria-label="Illustration of a street lamp at night"></div>
    <div class="container inner">
      <h2 data-reveal>Every book begins with one <em>question.</em></h2>
      <p data-reveal>Ask yours tonight. We'll tell you how we work, when we could deliver, and what it would cost.</p>
      <div class="btn-row" style="justify-content:center;" data-reveal>
        <a class="btn btn-primary" href="{{ route('begin') }}">Begin Your Story
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
        </a>
      </div>
    </div>
  </section>

@endsection
