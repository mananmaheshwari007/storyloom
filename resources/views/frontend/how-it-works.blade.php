@extends('layouts.app')

@section('content')
  <!-- ============ HERO ============ -->
  <section class="page-hero container">
    <p class="eyebrow eyebrow-center" data-reveal>{{ setting('how_hero_eyebrow', 'How it works') }}</p>
    <h1 data-reveal>{!! setting('how_hero_heading', 'From a conversation to a <em>keepsake.</em>') !!}</h1>
    <p class="lede" data-reveal>{{ setting('how_hero_lede', 'You bring the memories. We bring the writers, the illustrators, and the patience. Here is exactly what happens between “I\'d like to make one” and the moment they open it.') }}</p>
  </section>

  <!-- ============ TIMELINE ============ -->
  <section class="section grain" style="padding-top: clamp(24px, 4vh, 48px);">
    <div class="container" style="max-width: 900px;">
      <div class="timeline">
        <div class="timeline-item" data-reveal>
          <span class="week">{{ setting('how_step1_badge', 'Week 1 · Days 1–3') }}</span>
          <h3>{{ setting('how_step1_title', 'The Consultation') }}</h3>
          <p>{!! setting('how_step1_desc', 'A relaxed conversation — call, WhatsApp, voice notes. Whatever you have is enough.') !!}</p>
        </div>
        <div class="timeline-item" data-reveal>
          <span class="week">{{ setting('how_step2_badge', 'Week 1–2') }}</span>
          <h3>{{ setting('how_step2_title', 'The Story Takes Shape') }}</h3>
          <p>{!! setting('how_step2_desc', 'Our writers shape your memories into a story, and you refine every line with us.') !!}</p>
        </div>
        <div class="timeline-item" data-reveal>
          <span class="week">{{ setting('how_step3_badge', 'Week 2–4') }}</span>
          <h3>{{ setting('how_step3_title', 'The Illustrations Are Painted') }}</h3>
          <p>{!! setting('how_step3_desc', 'Your real places and real faces, painted spread by spread in our house style.') !!}</p>
        </div>
        <div class="timeline-item" data-reveal>
          <span class="week">{{ setting('how_step4_badge', 'Week 4') }}</span>
          <h3>{{ setting('how_step4_title', 'Layout & Your Final Review') }}</h3>
          <p>{!! setting('how_step4_desc', 'You review the complete book. Nothing prints until you say it\'s perfect.') !!}</p>
        </div>
        <div class="timeline-item" data-reveal>
          <span class="week">{{ setting('how_step5_badge', 'Week 4–5') }}</span>
          <h3>{{ setting('how_step5_title', 'Printing & Binding') }}</h3>
          <p>{!! setting('how_step5_desc', 'Archival paper, casebound hardcover — built for decades of bedtime readings.') !!}</p>
        </div>
        <div class="timeline-item" data-reveal>
          <span class="week">{{ setting('how_step6_badge', 'Week 5') }}</span>
          <h3>{{ setting('how_step6_title', 'Wrapped, Sealed, Delivered') }}</h3>
          <p>{!! setting('how_step6_desc', 'Wrapped, ribbon-tied, sealed — delivered anywhere in India, and worldwide.') !!}</p>
        </div>
      </div>
      <p class="timeline-note" data-reveal style="text-align: left; margin-top: clamp(28px, 4vh, 40px); font-size: 0.92rem; color: var(--ink-soft); font-style: italic;">
        {{ setting('how_timeline_note', 'Every Storyloom is created individually. Timelines may vary slightly depending on revisions and illustration complexity.') }}
      </p>
    </div>
  </section>

  <!-- ============ STATS STRIP ============ -->
  <section class="section section-tint">
    <div class="container">
      <div class="stats-strip" data-reveal>
        <div class="stat"><div class="num">{{ setting('how_stat1_num', '3–5') }}</div><div class="lbl">{{ setting('how_stat1_label', 'weeks, start to doorstep') }}</div></div>
        <div class="stat"><div class="num">{{ setting('how_stat2_num', '2') }}</div><div class="lbl">{{ setting('how_stat2_label', 'review rounds included, more if needed') }}</div></div>
        <div class="stat"><div class="num">{{ setting('how_stat3_num', '1') }}</div><div class="lbl">{{ setting('how_stat3_label', 'book like it, anywhere — yours') }}</div></div>
      </div>
    </div>
  </section>

  <!-- ============ CRAFTSMANSHIP / QUALITY YOU CAN FEEL ============ -->
  <section class="section grain">
    <div class="container book-feature">
      <div class="book-meta" data-reveal="left">
        <p class="eyebrow">{{ setting('craft_eyebrow', 'Built to be handed down') }}</p>
        <h2>{!! setting('craft_heading', 'Quality you can feel in the <em>first page-turn.</em>') !!}</h2>
        <p class="synopsis">{{ setting('craft_synopsis', 'A keepsake is a promise about time. So we obsess over the things you\'ll only notice years from now:') }}</p>
        <ul style="display:grid; gap:14px; color:var(--ink-soft); font-size:.98rem;">
          <li style="display:flex; gap:12px;">
            <svg style="flex:none; width:17px; height:17px; margin-top:6px; color:var(--grove);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12.5l5 5L20 6.5"/></svg>
            {{ setting('craft_feature_1', 'Heavyweight archival art paper that won\'t yellow or turn brittle') }}
          </li>
          <li style="display:flex; gap:12px;">
            <svg style="flex:none; width:17px; height:17px; margin-top:6px; color:var(--grove);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12.5l5 5L20 6.5"/></svg>
            {{ setting('craft_feature_2', 'Casebound hardcover with reinforced binding that opens flat') }}
          </li>
          <li style="display:flex; gap:12px;">
            <svg style="flex:none; width:17px; height:17px; margin-top:6px; color:var(--grove);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12.5l5 5L20 6.5"/></svg>
            {{ setting('craft_feature_3', 'Colour-calibrated printing that stays true to every painted spread') }}
          </li>
          <li style="display:flex; gap:12px;">
            <svg style="flex:none; width:17px; height:17px; margin-top:6px; color:var(--grove);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12.5l5 5L20 6.5"/></svg>
            {{ setting('craft_feature_4', 'A keepsake box strong enough to become the book\'s forever home') }}
          </li>
        </ul>
      </div>
      <figure class="plate hoverable" data-reveal="right">
        <img src="{{ asset(setting('craft_artwork_img', 'assets/img/spread-home-morning.webp')) }}" width="1600" height="900" loading="lazy"
             alt="Illustrated spread showing warm morning light across a family living room">
        <figcaption class="caption">{{ setting('craft_artwork_caption', 'every spread, printed exactly as painted') }}</figcaption>
      </figure>
    </div>
  </section>

  <!-- ============ FINAL CTA ============ -->
  <section class="final-cta">
    <div class="bg" style="background-image:url('{{ asset(setting('how_cta_bg', 'assets/img/spread-night-farewell.webp')) }}')" role="img"
         aria-label="Illustration of a lamplit street at night"></div>
    <div class="container inner">
      <h2 data-reveal>{!! setting('how_cta_heading', 'The first step is one <em style="color: #E88B52;">conversation.</em>') !!}</h2>
      <p data-reveal>{!! setting('how_cta_desc', 'Tell us who the story is for. We\'ll tell you exactly how we\'d bring it to life — no commitment until you\'ve seen the plan.') !!}</p>
      <div class="btn-row" style="justify-content:center;" data-reveal>
        <a class="btn btn-primary" href="{{ setting('how_cta_btn1_link', route('begin')) }}">{{ setting('how_cta_btn1', 'BEGIN YOUR STORY') }}
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
        </a>
        <a class="btn btn-ghost-light" href="{{ setting('how_cta_btn2_link', route('pricing')) }}">{{ setting('how_cta_btn2', 'SEE PRICING') }}</a>
      </div>
    </div>
  </section>
@endsection
