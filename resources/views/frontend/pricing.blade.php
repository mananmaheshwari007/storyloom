@extends('layouts.app')

@section('seo')
  <x-seo-tags 
    title="Pricing & Book Formats — Storyloom"
    description="Compare our Keepsake and Heirloom custom book editions. Clear pricing for handbound, illustrated storytelling."
    keywords="storyloom pricing, custom book cost, keepsake book editions, heirloom book packages"
    ogImage="assets/img/spread-shared-fries.webp"
  />
@endsection

@section('content')

  <section class="page-hero container">
    <p class="eyebrow eyebrow-center" data-reveal>Pricing</p>
    <h1 data-reveal>What a one-of-one book <em>includes.</em></h1>
    <p class="lede" data-reveal>Every Storyloom — whichever edition — is written from scratch, illustrated from scratch, and reviewed by you before printing. You're not buying a book off a shelf; you're commissioning the only copy that will ever exist.</p>
  </section>

  <section class="section grain" style="padding-top: clamp(16px, 3vh, 40px);">
    <div class="container">
      <div class="stats-strip" data-reveal style="margin-bottom: clamp(48px, 8vh, 80px);">
        <div class="stat"><div class="num">60+</div><div class="lbl">hours of writing &amp; illustration</div></div>
        <div class="stat"><div class="num">100%</div><div class="lbl">original story &amp; art — no templates</div></div>
        <div class="stat"><div class="num">∞</div><div class="lbl">times it will be read aloud</div></div>
      </div>

      <div class="pricing-grid">
        @foreach($plans as $plan)
          <div class="card price-card {{ $plan->popular ? 'featured' : '' }}" data-reveal style="--stagger:{{ $loop->index }}">
            <span class="tier-tag">{{ $plan->popular ? 'Most loved' : ($plan->name === 'Heirloom Edition' ? 'The Heirloom' : 'The Storyloom') }}</span>
            <h3>{{ str_replace(' Edition', '', $plan->name) }}</h3>
            <p style="color:var(--ink-soft); font-size:.95rem;">
              @if($plan->name === 'Classic Edition')
                The complete Storyloom experience.
              @elseif($plan->name === 'Deluxe Edition')
                A longer story, a richer world.
              @else
                Made to be handed down.
              @endif
            </p>
            <div class="price">₹{{ number_format($plan->price, 0) }}<small> {{ $plan->duration ?? 'onwards' }}</small></div>
            <ul style="list-style:none; padding:0;">
              @foreach($plan->features as $feature)
                <li style="display:flex; gap:10px; align-items:flex-start; margin-bottom:8px;">
                  <svg style="flex:none; width:16px; height:16px; margin-top:5px; color:var(--grove);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12.5l5 5L20 6.5"/></svg>
                  <span>{{ $feature }}</span>
                </li>
              @endforeach
            </ul>
          </div>
        @endforeach
      </div>

      <div style="text-align:center; margin-top: clamp(40px, 6vh, 56px);" data-reveal>
        <a class="btn btn-primary" href="{{ route('begin') }}">Begin Your Story
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
        </a>
      </div>
      <p style="text-align:center; margin-top: 24px; font-size: .9rem; color: var(--ink-faint);" data-reveal>
        Working towards a specific date or budget? Tell us when you begin — every book is planned personally.
      </p>
    </div>
  </section>

  <section class="section section-tint">
    <div class="container-narrow">
      <div class="section-head center" data-reveal>
        <p class="eyebrow eyebrow-center">A note on price</p>
        <h2>Why a book can cost more than a <em>phone cover.</em></h2>
      </div>
      <div class="prose" data-reveal style="color:var(--ink-soft); max-width:60ch; margin-inline:auto;">
        <p class="drop">A Storyloom is not printed-on-demand merchandise. It is a commission — weeks of a writer's and an illustrator's full attention on one family's story. Every spread is composed for you: your faces, your streets, your weather, your light.</p>
        <p>Divide the price by the years it will sit on a bedside table, be read at bedtimes, survive house moves, and eventually be handed to someone not yet born — and it becomes the least expensive thing you'll ever give.</p>
      </div>
    </div>
  </section>

  <section class="final-cta">
    <div class="bg" style="background-image:url('{{ asset('assets/img/spread-under-stars.webp') }}')" role="img"
         aria-label="Illustration of a couple beneath a starry night sky"></div>
    <div class="container inner">
      <h2 data-reveal>Begin with a conversation, not a <em>payment.</em></h2>
      <p data-reveal>Tell us your story first. You'll get a plan, a timeline, and a quote — and you decide only when you can already picture the book.</p>
      <div class="btn-row" style="justify-content:center;" data-reveal>
        <a class="btn btn-primary" href="{{ route('begin') }}">Begin Your Story
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
        </a>
      </div>
    </div>
  </section>

@endsection
