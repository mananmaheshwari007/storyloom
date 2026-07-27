@extends('layouts.app')

@section('content')

  <section class="page-hero container">
    <p class="eyebrow eyebrow-center" data-reveal>How it works</p>
    <h1 data-reveal>From a conversation to a <em>keepsake.</em></h1>
    <p class="lede" data-reveal>You bring the memories. We bring the writers, the illustrators, and the patience. Here is exactly what happens between “I'd like to make one” and the moment they open it.</p>
  </section>

  <section class="section grain" style="padding-top: clamp(24px, 4vh, 48px);">
    <div class="container" style="max-width: 900px;">
      <div class="timeline">
        <div class="timeline-item" data-reveal>
          <span class="week">Week 1 · Days 1–3</span>
          <h3>The Consultation</h3>
          <p>A relaxed conversation — call, WhatsApp, voice notes. Whatever you have is enough.</p>
        </div>
        <div class="timeline-item" data-reveal>
          <span class="week">Week 1–2</span>
          <h3>The Story Takes Shape</h3>
          <p>Our writers shape your memories into a story, and you refine every line with us.</p>
        </div>
        <div class="timeline-item" data-reveal>
          <span class="week">Week 2–4</span>
          <h3>The Illustrations Are Painted</h3>
          <p>Your real places and real faces, painted spread by spread in our house style.</p>
        </div>
        <div class="timeline-item" data-reveal>
          <span class="week">Week 4</span>
          <h3>Layout &amp; Your Final Review</h3>
          <p>You review the complete book. Nothing prints until you say it's perfect.</p>
        </div>
        <div class="timeline-item" data-reveal>
          <span class="week">Week 4–5</span>
          <h3>Printing &amp; Binding</h3>
          <p>Archival paper, casebound hardcover — built for decades of bedtime readings.</p>
        </div>
        <div class="timeline-item" data-reveal>
          <span class="week">Week 5</span>
          <h3>Wrapped, Sealed, Delivered</h3>
          <p>Wrapped, ribbon-tied, sealed — delivered anywhere in India, and worldwide.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="section section-tint">
    <div class="container">
      <div class="stats-strip" data-reveal>
        <div class="stat"><div class="num">3–5</div><div class="lbl">weeks, start to doorstep</div></div>
        <div class="stat"><div class="num">2</div><div class="lbl">review rounds included, more if needed</div></div>
        <div class="stat"><div class="num">1</div><div class="lbl">book like it, anywhere — yours</div></div>
      </div>
    </div>
  </section>

  <section class="section grain">
    <div class="container book-feature">
      <div class="book-meta" data-reveal="left">
        <p class="eyebrow">Built to be handed down</p>
        <h2>Quality you can feel in the <em>first page-turn.</em></h2>
        <p class="synopsis">A keepsake is a promise about time. So we obsess over the things you'll only notice years from now:</p>
        <ul style="display:grid; gap:14px; color:var(--ink-soft); font-size:.98rem; list-style:none; padding:0;">
          <li style="display:flex; gap:12px;"><svg style="flex:none; width:17px; height:17px; margin-top:6px; color:var(--grove);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12.5l5 5L20 6.5"/></svg>
            Heavyweight archival art paper that won't yellow or turn brittle</li>
          <li style="display:flex; gap:12px;"><svg style="flex:none; width:17px; height:17px; margin-top:6px; color:var(--grove);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12.5l5 5L20 6.5"/></svg>
            Casebound hardcover with reinforced binding that opens flat</li>
          <li style="display:flex; gap:12px;"><svg style="flex:none; width:17px; height:17px; margin-top:6px; color:var(--grove);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12.5l5 5L20 6.5"/></svg>
            Colour-calibrated printing that stays true to every painted spread</li>
          <li style="display:flex; gap:12px;"><svg style="flex:none; width:17px; height:17px; margin-top:6px; color:var(--grove);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12.5l5 5L20 6.5"/></svg>
            A keepsake box strong enough to become the book's forever home</li>
        </ul>
      </div>
      <figure class="plate hoverable" data-reveal="right">
        <img src="{{ asset('assets/img/spread-home-morning.webp') }}" width="1600" height="900" loading="lazy"
             alt="Illustrated spread showing warm morning light across a family living room">
        <figcaption class="caption">every spread, printed exactly as painted</figcaption>
      </figure>
    </div>
  </section>

  <section class="final-cta">
    <div class="bg" style="background-image:url('{{ asset('assets/img/spread-night-farewell.webp') }}')" role="img"
         aria-label="Illustration of a lamplit street at night"></div>
    <div class="container inner">
      <h2 data-reveal>The first step is one <em>conversation.</em></h2>
      <p data-reveal>Tell us who the story is for. We'll tell you exactly how we'd bring it to life — no commitment until you've seen the plan.</p>
      <div class="btn-row" style="justify-content:center;" data-reveal>
        <a class="btn btn-primary" href="{{ route('begin') }}">Begin Your Story
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
        </a>
        <a class="btn btn-ghost-light" href="{{ route('pricing') }}">See Pricing</a>
      </div>
    </div>
  </section>

@endsection
