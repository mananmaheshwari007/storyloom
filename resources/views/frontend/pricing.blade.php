@extends('layouts.app')

@section('content')
  <!-- ================= HERO ================= -->
  @if(\App\Support\Sections::enabled('pricing_hero'))
  <section class="page-hero container">
    <p class="eyebrow eyebrow-center" data-reveal>{{ setting('pricing_hero_eyebrow', 'Pricing') }}</p>
    <h1 data-reveal>{!! setting('pricing_hero_title', 'What a one-of-one book <em>includes.</em>') !!}</h1>
    <p class="lede" data-reveal>{{ setting('pricing_hero_lede', 'Every Storyloom — whichever edition — is written from scratch, illustrated from scratch, and reviewed by you before printing. You\'re not buying a book off a shelf; you\'re commissioning the only copy that will ever exist.') }}</p>
  </section>
  @endif

  <!-- ================= CARDS & GRID ================= -->
  @if(\App\Support\Sections::enabled('pricing_cards'))
  <section class="section grain" style="padding-top: clamp(16px, 3vh, 40px);">
    <div class="container">
      <div class="stats-strip" data-reveal style="margin-bottom: clamp(48px, 8vh, 80px);">
        <div class="stat"><div class="num">{{ setting('pricing_stat1_num', '60+') }}</div><div class="lbl">{{ setting('pricing_stat1_lbl', 'hours of writing & illustration') }}</div></div>
        <div class="stat"><div class="num">{{ setting('pricing_stat2_num', '100%') }}</div><div class="lbl">{{ setting('pricing_stat2_lbl', 'original story & art — no templates') }}</div></div>
        <div class="stat"><div class="num">{{ setting('pricing_stat3_num', '∞') }}</div><div class="lbl">{{ setting('pricing_stat3_lbl', 'times it will be read aloud') }}</div></div>
      </div>

      <div class="pricing-grid">
        @forelse($plans as $index => $plan)
          @php
            // The "most loved" badge belongs to whichever tier is ticked as
            // popular in the admin — it used to be pinned to the plan *named*
            // Deluxe, so marking another tier moved the highlight but left the
            // badge behind. Exactly one tier carries it.
            $tagline = 'A customized storybook experience.';

            if (Str::lower($plan->plan_name) === 'classic') {
                $tagline = 'The complete Storyloom experience.';
            } elseif (Str::lower($plan->plan_name) === 'deluxe') {
                $tagline = 'A longer story, a richer world.';
            } elseif (Str::lower($plan->plan_name) === 'heirloom') {
                $tagline = 'Made to be handed down.';
            }
          @endphp

          <div class="card price-card @if($plan->popular_plan) featured @endif" data-reveal style="--stagger:{{ $index }}">
            @if($plan->popular_plan)
              <span class="tier-tag">{{ setting('pricing_popular_label', 'Most loved') }}</span>
            @endif
            <h3>{{ $plan->plan_name }}</h3>
            <p style="color:var(--ink-soft); font-size:.95rem;">{{ $tagline }}</p>
            {{-- Amount charged leads; the old price and the saving sit under it. --}}
            <div class="price">₹{{ number_format($plan->price) }}<small> {{ $plan->duration }}</small></div>
            @if($plan->has_discount)
              <p class="price-was">
                <span class="was-amount">₹{{ number_format($plan->compare_price) }}</span>
                @if($plan->discount_badge)
                  <span class="save-badge">{{ $plan->discount_badge }}</span>
                @endif
              </p>
            @endif
            
            @if($plan->features)
              <ul>
                @foreach($plan->features as $feat)
                  <li>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 12.5l5 5L20 6.5"/></svg>
                    {{ $feat }}
                  </li>
                @endforeach
              </ul>
            @endif
          </div>
        @empty
          <div class="text-center py-5 text-muted w-100 col-span-full">No pricing plans found.</div>
        @endforelse
      </div>

      <div style="text-align:center; margin-top: clamp(40px, 6vh, 56px);" data-reveal>
        <a class="btn btn-primary" href="{{ route('begin') }}">Begin Your Story
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
        </a>
      </div>
      <p style="text-align:center; margin-top: 24px; font-size: .9rem; color: var(--ink-faint);" data-reveal>
        {{ setting('pricing_grid_subnote', 'Working towards a specific date or budget? Tell us when you begin — every book is planned personally.') }}
      </p>
    </div>
  </section>
  @endif

  <!-- ================= A NOTE ON PRICE ================= -->
  @if(\App\Support\Sections::enabled('pricing_note'))
  <section class="section section-tint">
    <div class="container-narrow">
      <div class="section-head center" data-reveal>
        <p class="eyebrow eyebrow-center">{{ setting('price_note_eyebrow', 'A note on price') }}</p>
        <h2>{!! setting('price_note_heading', 'Why a book can cost more than a <em>phone cover.</em>') !!}</h2>
      </div>
      <div class="prose" data-reveal style="color:var(--ink-soft); max-width:60ch; margin-inline:auto;">
        <p class="drop">{{ setting('price_note_p1', 'A Storyloom is not printed-on-demand merchandise. It is a commission — weeks of a writer\'s and an illustrator\'s full attention on one family\'s story. Every spread is composed for you: your faces, your streets, your weather, your light.') }}</p>
        <p>{{ setting('price_note_p2', 'Divide the price by the years it will sit on a bedside table, be read at bedtimes, survive house moves, and eventually be handed to someone not yet born — and it becomes the least expensive thing you\'ll ever give.') }}</p>
      </div>
    </div>
  </section>
  @endif

  <!-- ================= FINAL CTA ================= -->
  @if(\App\Support\Sections::enabled('pricing_cta'))
  <section class="final-cta">
    <div class="bg" style="background-image:url('{{ asset(setting('pricing_cta_bg', 'assets/img/spread-under-stars.webp')) }}')" role="img" aria-label="Illustration of a couple beneath a starry night sky"></div>
    <div class="container inner">
      <h2 data-reveal>{!! setting('pricing_cta_heading', 'Begin with a conversation, not a <em style="font-family: \'Cormorant Garamond\', Cormorant, Georgia, serif; font-style: italic; font-weight: 500; color: #E88B52;">payment.</em>') !!}</h2>
      <p data-reveal style="max-width: 620px; width: 100%; margin-inline: auto; font-size: 1.05rem; line-height: 1.65; color: rgba(255, 255, 255, 0.78);">{!! setting('pricing_cta_desc', 'Tell us your story first. You\'ll get a plan, a timeline, and a quote — and you decide only when you can already picture the book.') !!}</p>
      <div class="btn-row" style="justify-content:center;" data-reveal>
        <a class="btn btn-primary" href="{{ setting('pricing_cta_btn1_link', route('begin')) }}">{{ setting('pricing_cta_btn1_text', 'BEGIN YOUR STORY') }}
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
        </a>
      </div>
    </div>
  </section>
  @endif
@endsection
