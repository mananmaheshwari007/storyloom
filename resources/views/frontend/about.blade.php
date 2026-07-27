@extends('layouts.app')

@section('content')

  <section class="page-hero container">
    <p class="eyebrow eyebrow-center" data-reveal>About Storyloom</p>
    <h1 data-reveal>{!! setting('about_hero_title', 'We exist because memories deserve better than a <em>camera roll.</em>') !!}</h1>
  </section>

  <section class="section grain" style="padding-top: clamp(16px, 3vh, 40px);">
    <div class="container book-feature">
      <div class="prose" data-reveal="left">
        <p class="drop">Families capture more of their lives than ever — and revisit almost none of it.</p>
        <p>{!! nl2br(e($about->description)) !!}</p>
        
        @if(!empty($about->skills))
          <div style="margin-top: 40px;">
            <h4 style="margin-bottom: 15px; text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.8rem; color: var(--ink-faint);">Our Craftsmanship</h4>
            <ul style="display: flex; flex-direction: column; gap: 12px; padding: 0; list-style: none;">
              @foreach($about->skills as $skill)
                <li style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--hairline); padding-bottom: 6px; font-size: 0.95rem;">
                  <span style="font-family: var(--font-display); font-weight: 600; color: var(--ink);">{{ is_array($skill) ? ($skill['name'] ?? $skill['title'] ?? '') : $skill }}</span>
                  @if(is_array($skill) && !empty($skill['percentage']))
                    <span style="color: var(--terra); font-weight: 700;">{{ $skill['percentage'] }}%</span>
                  @endif
                </li>
              @endforeach
            </ul>
          </div>
        @endif
      </div>
      <figure class="plate hoverable" data-reveal="right">
        <img src="{{ asset($about->image ?? 'assets/img/spread-walk-together.webp') }}" width="1100" height="1469" loading="lazy"
             alt="Illustration of a couple walking through their neighbourhood, deep in conversation">
        <figcaption class="caption">ordinary moments — the ones that turn out to matter</figcaption>
      </figure>
    </div>
  </section>

  @if(!empty($about->statistics))
    <section class="section section-tint grain" style="border-top: 1px solid var(--hairline); border-bottom: 1px solid var(--hairline);">
      <div class="container">
        <div class="section-head center" data-reveal>
          <p class="eyebrow eyebrow-center">Storyloom by the numbers</p>
          <h2>Weaving stories at <em>scale</em></h2>
        </div>
        <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: clamp(24px, 4vw, 64px); margin-top: 20px;">
          @foreach($about->statistics as $stat)
            <div style="flex: 1; min-width: 200px; text-align: center; padding: 20px; background: rgba(255,253,248,0.4); border-radius: 4px; box-shadow: var(--shadow-soft);" data-reveal>
              <h2 style="font-size: clamp(2.5rem, 5vw, 3.5rem); color: var(--terra); line-height: 1; margin-bottom: 8px;">{{ is_array($stat) ? ($stat['value'] ?? $stat['number'] ?? '') : $stat }}</h2>
              @if(is_array($stat) && !empty($stat['label']))
                <p style="font-family: var(--font-display); font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.15em; color: var(--ink-soft); font-weight: 600;">{{ $stat['label'] }}</p>
              @endif
            </div>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  <section class="section">
    <div class="container">
      <div class="section-head center" data-reveal>
        <p class="eyebrow eyebrow-center">What we stand for</p>
        <h2>Craftsmanship over speed. Specificity over <em>sentiment.</em></h2>
      </div>
      <div class="occasion-grid" style="grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));">
        <div class="card occasion-card" data-reveal style="--stagger:0">
          <h3>Every detail belongs to you</h3>
          <p>If the page shows a balcony, it's your balcony — down to the plants.</p>
        </div>
        <div class="card occasion-card" data-reveal style="--stagger:1">
          <h3>The book is the argument</h3>
          <p>Everyone sees a finished book before a brief. The book is the argument.</p>
        </div>
        <div class="card occasion-card" data-reveal style="--stagger:2">
          <h3>Painterly, not plastic</h3>
          <p>Hand-painterly, calm, classic — never flat, bright cartoon.</p>
        </div>
        <div class="card occasion-card" data-reveal style="--stagger:3">
          <h3>Made to be handed down</h3>
          <p>Archival everything — built to be kept for a very long time.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="section grain">
    <div class="container book-feature flip">
      <div class="prose" data-reveal="right">
        <p class="eyebrow">The mark we make</p>
        <h2 style="margin-bottom: 22px;">An heirloom mark, not a <em>startup logo.</em></h2>
        <p>Look closely at our emblem. At the top, a loom — vertical posts with threads strung between them: a family's scattered moments, still unformed. Below, those same threads fall and open into the pages of a book. One becomes the other.</p>
        <p>The double ring borrows from seals and crests — marks that have always signified craftsmanship and things made to be handed down. It only reveals itself on a second look. So do our books.</p>
      </div>
      <div style="display:grid; place-items:center;" data-reveal="left">
        <img src="{{ asset('assets/img/logo-primary.png') }}" alt="The Storyloom emblem — a loom whose threads become the pages of an open book, inside a double-ring seal"
             width="360" height="353" loading="lazy" style="width:min(360px, 70%);">
      </div>
    </div>
  </section>

  @if($team->isNotEmpty())
    <section class="section section-tint grain" style="border-top: 1px solid var(--hairline);">
      <div class="container">
        <div class="section-head center" data-reveal>
          <p class="eyebrow eyebrow-center">The team</p>
          <h2>The people at the <em>loom.</em></h2>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px; margin-top: 30px;">
          @foreach($team as $index => $member)
            <div class="card" style="padding: 24px; text-align: center; background: #fff;" data-reveal style="--stagger:{{ $index % 3 }}">
              <div class="rounded-circle overflow-hidden mx-auto mb-3" style="width: 120px; height: 120px; border: 2px solid var(--parchment-2);">
                <img src="{{ asset($member->photo ?? 'assets/img/logo-emblem.png') }}" alt="{{ $member->name }}" style="width:100%; height:100%; object-fit:cover;">
              </div>
              <h3 style="font-size: 1.4rem; margin-bottom: 4px;">{{ $member->name }}</h3>
              <p style="font-family: var(--font-display); font-size: 0.9rem; text-transform: uppercase; color: var(--terra); letter-spacing: 0.1em; margin-bottom: 12px;">{{ $member->designation }}</p>
              <p style="font-size: 0.9rem; color: var(--ink-soft); line-height: 1.6;">{{ $member->description }}</p>
              
              @if(!empty($member->social_links))
                <div style="display: flex; justify-content: center; gap: 12px; margin-top: 16px;">
                  @foreach($member->social_links as $platform => $url)
                    <a href="{{ $url }}" target="_blank" rel="noopener" style="color: var(--ink-faint); font-size: 1.1rem;"><i class="bi bi-{{ $platform }}"></i></a>
                  @endforeach
                </div>
              @endif
            </div>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  <section class="final-cta">
    <div class="bg" style="background-image:url('{{ asset('assets/img/spread-bench-dusk.webp') }}')" role="img"
         aria-label="Illustration of a couple on a bench at dusk"></div>
    <div class="container inner">
      <h2 data-reveal>Your family's chapter is <em>ready</em> to be written.</h2>
      <p data-reveal>Somewhere in your camera roll and your memory is a book waiting to be woven. Let's find it together.</p>
      <div class="btn-row" style="justify-content:center;" data-reveal>
        <a class="btn btn-primary" href="{{ route('begin') }}">Begin Your Story
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
        </a>
        <a class="btn btn-ghost-light" href="{{ route('library') }}">Read a Storyloom</a>
      </div>
    </div>
  </section>

@endsection
