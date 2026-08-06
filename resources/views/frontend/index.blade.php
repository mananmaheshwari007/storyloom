@extends('layouts.app')

@section('content')
  <!-- ================= HERO ARC CAROUSEL ================= -->
  @php
    $rawCards = setting('hero_cards');
    $carouselCards = [];
    if ($rawCards) {
        $carouselCards = is_array($rawCards) ? $rawCards : json_decode($rawCards, true);
    }
    if (empty($carouselCards)) {
        $carouselCards = [
            ['image' => 'assets/img/hero-reading-hilltop.webp', 'title' => '"The First Home"', 'caption' => 'a Storyloom for an anniversary'],
            ['image' => 'assets/img/spread-home-morning.webp', 'title' => '"Sunday Morning Chai"', 'caption' => 'a Storyloom for Dad'],
            ['image' => 'assets/img/spread-flower-street.webp', 'title' => '"The Evening Walk"', 'caption' => 'a Storyloom for Mom'],
            ['image' => 'assets/img/spread-shared-fries.webp', 'title' => '"One Plate, Two Forks"', 'caption' => 'a Storyloom for a sister'],
            ['image' => 'assets/img/spread-under-stars.webp', 'title' => '"Under the Stars"', 'caption' => 'a Storyloom for a proposal'],
        ];
    }
  @endphp
  <section class="hero hero-arc-carousel" aria-label="Storyloom introduction">

    <!-- ===== MOBILE HERO (≤ 767px) ===== -->
    @php
      $rawMobileCards = setting('mobile_hero_cards');
      $mobileSlides = [];
      if ($rawMobileCards) {
          $mobileSlides = is_array($rawMobileCards) ? $rawMobileCards : json_decode($rawMobileCards, true);
      }
      if (empty($mobileSlides)) {
          $mobileSlides = $carouselCards ?? [
              ['image' => 'assets/img/hero-reading-hilltop.webp'],
              ['image' => 'assets/img/spread-home-morning.webp'],
              ['image' => 'assets/img/spread-flower-street.webp'],
              ['image' => 'assets/img/spread-shared-fries.webp'],
              ['image' => 'assets/img/spread-under-stars.webp'],
          ];
      }
    @endphp
    <div class="hero-mobile" id="heroMobile" data-slide-speed="{{ setting('mobile_hero_slide_speed', '4') }}">
      <div class="hero-mobile-slides">
        @foreach($mobileSlides as $si => $slide)
          <div class="hero-mobile-slide {{ $si === 0 ? 'is-active' : '' }}">
            {{-- Not lazy-loaded: every slide is inside the opening viewport and
                 gets shown within seconds, so lazy risks a blank hero mid-rotation.
                 Low priority keeps them behind the first slide, which is the LCP. --}}
            <img src="{{ asset($slide['image'] ?? 'assets/img/hero-reading-hilltop.webp') }}"
                 alt="" width="750" height="1000" decoding="async"
                 @if($si === 0) fetchpriority="high" @else fetchpriority="low" @endif>
          </div>
        @endforeach
      </div>
      <div class="hero-mobile-overlay"></div>
      <div class="hero-mobile-copy">
        <div class="hero-mobile-top">
          <h1 data-hero="1">{!! setting('mobile_hero_heading', 'The story only <em>you</em> could give.') !!}</h1>
          <p class="hero-mobile-body" data-hero="2">{!! setting('mobile_hero_description', 'We transform your memories into a beautifully illustrated keepsake book — every page painted around your people, your places, and the moments that made you a family.') !!}</p>
        </div>
        <div class="hero-mobile-bottom">
          <a class="btn btn-primary hero-mobile-btn" href="{{ setting('mobile_hero_btn_link', '/begin') }}" data-hero="3">
            {{ setting('mobile_hero_btn_text', 'BEGIN YOUR STORY') }}
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
          </a>
          @if(count($mobileSlides) > 1)
            <div class="hero-mobile-dots" id="heroMobileDots">
              @foreach($mobileSlides as $si => $slide)
                <button type="button"
                        class="hero-mobile-dot {{ $si === 0 ? 'is-active' : '' }}"
                        data-slide="{{ $si }}"
                        aria-label="Show slide {{ $si + 1 }} of {{ count($mobileSlides) }}"
                        aria-current="{{ $si === 0 ? 'true' : 'false' }}"></button>
              @endforeach
            </div>
          @endif
        </div>
      </div>
    </div>

    <!-- ===== DESKTOP HERO (≥ 768px) ===== -->
    <div class="hero-desktop">
      <div class="container hero-arc-container">
      
      <!-- Arc Carousel Stage -->
      <div class="arc-carousel-stage" id="heroArcCarousel" data-speed="{{ setting('hero_carousel_speed', '3.5') }}">
        <div class="arc-track">
          @foreach($carouselCards as $index => $card)
            @php
              // Mirror updatePositions() in main.js for the opening frame, so the arc
              // is laid out by CSS on first paint. Without this every card stacks in
              // one spot until the deferred script runs and then slides into place,
              // which was pushing the LCP image's render out by ~1.7s.
              $arcTotal = count($carouselCards);
              $arcDiff  = $index;
              if ($arcDiff > $arcTotal / 2)  { $arcDiff -= $arcTotal; }
              if ($arcDiff < -$arcTotal / 2) { $arcDiff += $arcTotal; }
              $arcPos = abs($arcDiff) <= 2
                  ? (string) $arcDiff
                  : ($arcDiff < -2 ? 'hidden-left' : 'hidden-right');
            @endphp
            <div class="arc-card" data-index="{{ $index }}" data-pos="{{ $arcPos }}">
              <div class="arc-card-inner">
                {{-- Card 0 opens in the centre slot, so it is the LCP element on
                     mobile — let the browser fetch it ahead of the other art. --}}
                <img src="{{ asset($card['image'] ?? 'assets/img/hero-reading-hilltop.webp') }}"
                     alt="{{ $card['title'] ?? '' }}"
                     width="400" height="520" decoding="async"
                     @if($index === 0) fetchpriority="high" @else loading="lazy" @endif>
                <div class="arc-card-caption">
                  <strong>{{ $card['title'] ?? '' }}</strong>
                  <span>{{ $card['caption'] ?? '' }}</span>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <!-- Carousel Navigation Controls -->
        <button class="arc-nav arc-prev" aria-label="Previous story card">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button class="arc-nav arc-next" aria-label="Next story card">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M9 5l7 7-7 7"/></svg>
        </button>
      </div>

      <!-- Hero Copy Centered -->
      <div class="hero-copy hero-copy-centered">
        <p class="eyebrow eyebrow-center" data-hero="1">{{ $hero?->subheading ?? setting('hero_subheading', 'PERSONALISED KEEPSAKE STORYBOOKS') }}</p>
        <h1 data-hero="2">{!! $hero?->heading ?? setting('hero_heading', 'The story only <em>you</em> could give.') !!}</h1>
        <p class="sub" data-hero="3">{!! $hero?->description ?? setting('hero_description', 'We transform your memories into a beautifully illustrated keepsake book — every page painted around your people, your places, and the moments that made you a family.') !!}</p>
        <div class="btn-row btn-row-center" data-hero="4">
          <a class="btn btn-primary" href="{{ $hero?->button_link ?? setting('hero_btn1_link', route('begin')) }}">
            {{ $hero?->button_text ?? setting('hero_btn1_text', 'BEGIN YOUR STORY') }}
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
          </a>
          <a class="btn btn-ghost" href="{{ setting('hero_btn2_link', route('library')) }}">{{ setting('hero_btn2_text', 'READ A STORYLOOM') }}</a>
        </div>
        <p class="hero-note hero-note-center" data-hero="5">
          <span class="stars" aria-hidden="true">
            @for($i = 0; $i < 5; $i++)
              <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.5l2.9 6.2 6.6.8-4.9 4.6 1.3 6.6L12 17.4l-5.9 3.3 1.3-6.6L2.5 9.5l6.6-.8z"/></svg>
            @endfor
          </span>
          <span>{{ setting('hero_note', 'Illustrated by hand · Crafted in India · Delivered worldwide') }}</span>
        </p>
      </div>

      </div>
    </div>
  </section>

  <!-- ================= PROBLEM ================= -->
  @if(\App\Support\Sections::enabled('problem'))
  <section class="section {{ \App\Support\Sections::tint() }}">
    <div class="container">
      <div class="section-head center" data-reveal>
        <p class="eyebrow eyebrow-center">{!! setting('problem_eyebrow', 'The trouble with gifts') !!}</p>
        @php
          // A separate mobile heading, same pattern as the hero: leave the
          // Homepage Editor field blank and the desktop heading is used on
          // every screen.
          $problemHeading       = setting('problem_heading', 'Most gifts are <em>forgotten.</em>');
          $problemHeadingMobile = setting('problem_heading_mobile', '');
        @endphp
        @if(trim($problemHeadingMobile) !== '')
          <h2 class="only-desktop">{!! $problemHeading !!}</h2>
          <h2 class="only-mobile">{!! $problemHeadingMobile !!}</h2>
        @else
          <h2>{!! $problemHeading !!}</h2>
        @endif
      </div>
      <div class="fading-gifts">
        <div class="fading-gift" data-reveal style="--stagger:0">
          @if(setting('problem_gift1_icon'))
            <img class="section-icon" src="{{ asset(setting('problem_gift1_icon')) }}" alt="" width="72" height="72" loading="lazy" decoding="async">
          @endif
          <span class="word">{!! setting('problem_gift1_word', 'Flowers') !!}</span>
          <span class="fate">{!! setting('problem_gift1_fate', 'fade in a week') !!}</span>
        </div>
        <div class="fading-gift" data-reveal style="--stagger:1">
          @if(setting('problem_gift2_icon'))
            <img class="section-icon" src="{{ asset(setting('problem_gift2_icon')) }}" alt="" width="72" height="72" loading="lazy" decoding="async">
          @endif
          <span class="word">{!! setting('problem_gift2_word', 'Chocolates') !!}</span>
          <span class="fate">{!! setting('problem_gift2_fate', 'disappear in a day') !!}</span>
        </div>
        <div class="fading-gift" data-reveal style="--stagger:2">
          @if(setting('problem_gift3_icon'))
            <img class="section-icon" src="{{ asset(setting('problem_gift3_icon')) }}" alt="" width="72" height="72" loading="lazy" decoding="async">
          @endif
          <span class="word">{!! setting('problem_gift3_word', 'Gadgets') !!}</span>
          <span class="fate">{!! setting('problem_gift3_fate', 'are replaced next year') !!}</span>
        </div>
      </div>
      <div class="section-head center" data-reveal style="margin-bottom:0">
        <p class="lede">{!! setting('problem_lede', 'The people who shaped your life deserve something that says exactly what they mean to you — and keeps saying it, for years.') !!}</p>
      </div>
    </div>
  </section>
  @endif

  <!-- ================= REVEAL (FULL-BLEED BACKGROUND ARTWORK IMAGE) ================= -->
  @if(\App\Support\Sections::enabled('reveal'))
  <section class="section reveal-split-section" style="position: relative; overflow: hidden; min-height: clamp(640px, 82vh, 920px); display: flex; align-items: center; padding: 0;">
    <!-- Full-Bleed Background Artwork Image Across Whole Section (No Opacity Mask) -->
    <div class="reveal-right-img" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; width: 100%; height: 100%; background-image: url('{{ asset(setting('reveal_book_spread_image', 'assets/img/spread-home-morning.webp')) }}'); background-size: cover; background-position: center; pointer-events: none;"></div>

    <div class="reveal-container" style="max-width: 1380px; width: 100%; margin: 0 auto; padding: clamp(60px, 9.5vh, 110px) clamp(24px, 4.5vw, 64px); position: relative; z-index: 2;">
      <div class="row align-items-stretch">
        <!-- Left Text Column: Pulled left with explicit flex layout (no data-reveal on parent to avoid display:block override) -->
        <div class="col-lg-5 col-md-6 text-start" style="display: flex !important; flex-direction: column !important; justify-content: space-between !important; min-height: clamp(480px, 62vh, 700px);">
          <!-- Top Text Content Block -->
          <div class="reveal-text-top" data-reveal>
            <p class="eyebrow" style="text-align: left; margin-bottom: 18px; letter-spacing: 0.12em; color: #B55B29; font-weight: 600;">{{ setting('reveal_eyebrow', 'INTRODUCING STORYLOOM') }}</p>
            <h2 style="text-align: left; font-family: var(--font-display); font-size: clamp(2.5rem, 4.4vw, 4.0rem); font-weight: 500; line-height: 1.15; color: #1C222B; margin-bottom: 24px;">
              {!! setting('reveal_heading', 'Your story,<br>woven into a <em style="font-family: \'Cormorant Garamond\', Cormorant, Georgia, serif; font-style: italic; color: #B55B29;">book.</em>') !!}
            </h2>
            <p class="sub" style="text-align: left; font-family: 'Libre Caslon Text', Georgia, serif; font-size: clamp(1.05rem, 1.35vw, 1.18rem); line-height: 1.72; color: rgba(28, 34, 43, 0.88); max-width: 480px; margin-bottom: 0;">
              {{ setting('reveal_lede', 'A completely personalised, hand-illustrated book created from your memories — an original story where every detail belongs to your family alone.') }}
            </p>
          </div>

          <!-- Bottom Button Block Anchored at Section Bottom -->
          <div class="reveal-btn-bottom mt-auto" data-reveal style="padding-top: 60px;">
            <a class="btn btn-primary" href="{{ setting('reveal_btn_link', route('library')) }}" style="padding: 16px 36px; font-weight: 600; font-size: 0.95rem;">
              {{ setting('reveal_btn_text', 'READ A STORYLOOM') }}
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true" style="width: 18px; height: 18px; margin-left: 6px;"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  @php \App\Support\Sections::breakTint(); @endphp
  @endif

  <!-- ================= STORY EXAMPLES ================= -->
  @php
    $rawStoryCards = setting('story_for_cards');
    $storyForCards = [];
    if ($rawStoryCards) {
        $storyForCards = is_array($rawStoryCards) ? $rawStoryCards : json_decode($rawStoryCards, true);
    }
    if (empty($storyForCards)) {
        // Eight cards fill two even rows of four. Overridden entirely once
        // Homepage Editor → "Who is your story for?" has been saved.
        $storyForCards = [
            ['image' => 'assets/img/spread-under-stars.webp', 'title' => 'Partner', 'hint' => 'anniversaries · proposals', 'link' => route('occasions')],
            ['image' => 'assets/img/spread-home-morning.webp', 'title' => 'Mom & Dad', 'hint' => 'parents 50th · retirement', 'link' => route('occasions')],
            ['image' => 'assets/img/spread-shared-fries.webp', 'title' => 'Sister / Brother', 'hint' => 'rakhi · milestone birthdays', 'link' => route('occasions')],
            ['image' => 'assets/img/spread-cafe-window.webp', 'title' => 'Best Friend', 'hint' => 'farewells · long distance', 'link' => route('occasions')],
            ['image' => 'assets/img/spread-street-morning.webp', 'title' => 'Grandparents', 'hint' => 'birthdays · anniversaries', 'link' => route('occasions')],
            ['image' => 'assets/img/spread-home-evening.webp', 'title' => 'Children', 'hint' => "baby's first year · graduation", 'link' => route('occasions')],
            ['image' => 'assets/img/spread-bench-sunset.webp', 'title' => 'Teacher / Mentor', 'hint' => 'thank-yous · farewells', 'link' => route('occasions')],
            ['image' => 'assets/img/spread-walk-together.webp', 'title' => 'The Whole Family', 'hint' => 'reunions · festivals', 'link' => route('occasions')],
        ];
    }
  @endphp
  @if(\App\Support\Sections::enabled('story'))
  <section class="section {{ \App\Support\Sections::tint() }}">
    <div class="container">
      <div class="section-head" data-reveal>
        <p class="eyebrow">{{ setting('story_for_eyebrow', 'Who is your story for?') }}</p>
        <h2>{!! setting('story_for_heading', 'Every relationship has its own <em>book.</em>') !!}</h2>
      </div>
      <div class="story-grid">
        @foreach($storyForCards as $index => $card)
          <a class="story-card" href="{{ $card['link'] ?? route('occasions') }}" data-reveal style="--stagger:{{ $index % 3 }}">
            <span class="img-wrap">
              <img src="{{ asset($card['image'] ?? 'assets/img/spread-bench-sunset.webp') }}" loading="lazy" decoding="async" width="400" height="500" alt="{{ $card['title'] ?? '' }}">
              <span class="card-overlay-gradient"></span>
              <span class="card-hover-content">
                <span class="for-title">{{ $card['title'] ?? '' }}</span>
                <span class="hint-text">{{ $card['hint'] ?? '' }}</span>
                <span class="explore-btn">Explore Stories &rarr;</span>
              </span>
            </span>
            <span class="story-label"><span class="for">{{ $card['title'] ?? '' }}</span><span class="hint">{{ $card['hint'] ?? '' }}</span></span>
          </a>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  <!-- ================= PROCESS ================= -->
  @if(\App\Support\Sections::enabled('process'))
  <section class="section {{ \App\Support\Sections::tint() }}">
    <div class="container">
      <div class="section-head center" data-reveal>
        <p class="eyebrow eyebrow-center">{{ setting('process_eyebrow', 'The plan') }}</p>
        <h2>{!! setting('process_heading', 'Three steps to a story they\'ll <em>never forget.</em>') !!}</h2>
      </div>
      <div class="process-grid">
        <div class="process-step" data-reveal style="--stagger:0">
          @if(setting('process_step1_icon'))
            <img class="section-icon" src="{{ asset(setting('process_step1_icon')) }}" alt="" width="72" height="72" loading="lazy" decoding="async">
          @else
            <div class="step-no">I</div>
          @endif
          <h3>{{ setting('process_step1_title', 'Share Your Story') }}</h3>
          <p>{!! setting('process_step1_desc', 'Tell us about them — the memories, the inside jokes, the places, the photographs. A gentle conversation, not a form. Whatever you have is enough.') !!}</p>
          <span class="process-line" aria-hidden="true"></span>
        </div>
        <div class="process-step" data-reveal style="--stagger:1">
          @if(setting('process_step2_icon'))
            <img class="section-icon" src="{{ asset(setting('process_step2_icon')) }}" alt="" width="72" height="72" loading="lazy" decoding="async">
          @else
            <div class="step-no">II</div>
          @endif
          <h3>{{ setting('process_step2_title', 'Refine It Together') }}</h3>
          <p>{!! setting('process_step2_desc', 'Our writers shape your memories into a story; our illustrators paint your world into its pages. You review everything and we refine it until it feels exactly right.') !!}</p>
          <span class="process-line" aria-hidden="true"></span>
        </div>
        <div class="process-step" data-reveal style="--stagger:2">
          @if(setting('process_step3_icon'))
            <img class="section-icon" src="{{ asset(setting('process_step3_icon')) }}" alt="" width="72" height="72" loading="lazy" decoding="async">
          @else
            <div class="step-no">III</div>
          @endif
          <h3>{{ setting('process_step3_title', 'Receive Your Storyloom') }}</h3>
          <p>{!! setting('process_step3_desc', 'A hardbound, archival-quality book arrives at your door — wrapped, sealed, and ready for the moment they open it.') !!}</p>
        </div>
      </div>
      <div style="text-align:center; margin-top: clamp(40px, 6vh, 60px)" data-reveal>
        <a class="text-link" href="{{ route('how-it-works') }}">See the full journey
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
        </a>
      </div>
    </div>
  </section>
  @endif

  <!-- ================= WHY / TRANSFORMATION ================= -->
  @if(\App\Support\Sections::enabled('why'))
  <section class="section {{ \App\Support\Sections::tint() }}">
    <div class="container">
      <div class="section-head" data-reveal>
        <p class="eyebrow">{{ setting('why_eyebrow', 'Why Storyloom') }}</p>
        <h2>{!! setting('why_heading', 'Not a product. A <em>moment.</em>') !!}</h2>
      </div>
      <div class="occasion-grid" style="grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));">
        <div class="card" data-reveal style="--stagger:0">
          <h3 style="font-size:1.3rem; margin-bottom:10px;">{{ setting('why_card1_title', 'A story, not a spec') }}</h3>
          <p style="font-size:.95rem; color:var(--ink-soft);">{!! setting('why_card1_desc', 'Not “32 pages” — a complete story they\'ll return to again and again, with a beginning, a middle, and your ending.') !!}</p>
        </div>
        <div class="card" data-reveal style="--stagger:1">
          <h3 style="font-size:1.3rem; margin-bottom:10px;">{{ setting('why_card2_title', 'Made to be handed down') }}</h3>
          <p style="font-size:.95rem; color:var(--ink-soft);">{!! setting('why_card2_desc', 'Not “premium paper” — a book crafted to survive decades of bedtime readings, and still be there for the grandchildren.') !!}</p>
        </div>
        <div class="card" data-reveal style="--stagger:2">
          <h3 style="font-size:1.3rem; margin-bottom:10px;">{{ setting('why_card3_title', 'Unmistakably them') }}</h3>
          <p style="font-size:.95rem; color:var(--ink-soft);">{!! setting('why_card3_desc', 'Their likeness, their street, their chai stall. A Storyloom could never belong to any other family — every detail on the page belongs to this one.') !!}</p>
        </div>
        <div class="card" data-reveal style="--stagger:3">
          <h3 style="font-size:1.3rem; margin-bottom:10px;">{{ setting('why_card4_title', 'Painterly, calm, classic') }}</h3>
          <p style="font-size:.95rem; color:var(--ink-soft);">{!! setting('why_card4_desc', 'Closer to fine illustration than bright cartoon templates — art that belongs on a shelf, and in a will.') !!}</p>
        </div>
      </div>

      <div style="padding-top: clamp(56px, 9vh, 88px)">
        <div class="transform-stage">
          <div class="transform-quote before" data-reveal="left">
            {{ setting('transform_before_quote', '“I don\'t know what to gift them…”') }}
            <span class="who">{{ setting('transform_before_who', 'Every year, before') }}</span>
          </div>
          <img class="transform-mark" src="{{ asset(setting('site_emblem', 'assets/img/logo-emblem.png')) }}" alt="" width="92" height="91" data-reveal>
          <div class="transform-quote after" data-reveal="right">
            {{ setting('transform_after_quote', '“I can\'t believe you made this.”') }}
            <span class="who">{{ setting('transform_after_who', 'The moment they open it') }}</span>
          </div>
        </div>
      </div>
    </div>
  </section>
  @endif

  <!-- ================= TESTIMONIALS ================= -->
  {{-- Not a section with padding around it — the band IS the element, running
       edge to edge with no dark margin above or below. --}}
  @if(\App\Support\Sections::enabled('testimonial'))
  <section class="testimonial-section" aria-label="What families say">
    {{-- Heading is off by default: the band speaks for itself. Turn it back on
         from Homepage Editor → Testimonial section if it's ever wanted. --}}
    @if(setting('testimonial_show_head', '0') === '1')
      <div class="container">
        <div class="section-head center testimonial-head" data-reveal>
          <p class="eyebrow eyebrow-center">{!! setting('testimonial_eyebrow', 'The moment it opens') !!}</p>
          <h2>{!! setting('testimonial_heading', 'Some gifts get a thank-you. <em>These get tears.</em>') !!}</h2>
        </div>
      </div>
    @endif
    @php
        $tItems = $testimonials->count() ? $testimonials : collect([(object)[
            'review' => "My mother read it aloud twice, cried both times, and now it lives on her bedside table. Nothing I've ever given her has come close.",
            'client_name' => "A daughter's gift", 'designation' => "for her mother's 60th", 'image' => null,
        ]]);
        $tFallbackImg = 'assets/img/spread-home-morning.webp';
      @endphp
      <div class="testimonial-band" data-reveal>
        {{-- Photo column: crossfades in step with the quote --}}
        <div class="tb-media" aria-hidden="true">
          @foreach($tItems as $index => $test)
            <img class="tb-photo {{ $index === 0 ? 'is-active' : '' }}"
                 src="{{ asset($test->image ?: $tFallbackImg) }}"
                 alt="" width="700" height="440" loading="lazy" decoding="async">
          @endforeach
          <span class="tb-fade"></span>
        </div>

        <div class="tb-body">
          <svg class="tb-quote" viewBox="0 0 32 24" aria-hidden="true" focusable="false">
            <path d="M13 24V13.2C13 5.9 17.4 1.2 25 0l1.5 3.4C22 4.7 19.6 7.2 19.3 11H24v13h-11Zm-13 0V13.2C0 5.9 4.4 1.2 12 0l1.5 3.4C9 4.7 6.6 7.2 6.3 11H11v13H0Z"/>
          </svg>

          <div class="testimonial-stage">
            @foreach($tItems as $index => $test)
              <div class="testimonial {{ $index === 0 ? 'is-active' : '' }}">
                <blockquote>{{ $test->review }}</blockquote>
                <cite>— {{ $test->client_name }}@if($test->designation), {{ $test->designation }}@endif</cite>
              </div>
            @endforeach
          </div>

        </div>

        @if($tItems->count() > 1)
          <div class="testimonial-dots" role="tablist" aria-label="Choose testimonial">
            @foreach($tItems as $index => $test)
              <button type="button" role="tab"
                      aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                      aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                      aria-label="Testimonial {{ $index + 1 }} of {{ $tItems->count() }}"></button>
            @endforeach
          </div>
        @endif
      </div>
  </section>
  @php \App\Support\Sections::breakTint(); @endphp
  @endif

  <!-- ================= OCCASIONS MARQUEE ================= -->
  @if(\App\Support\Sections::enabled('marquee'))
  <section class="section {{ \App\Support\Sections::tint() }}" style="padding-bottom: clamp(56px, 8vh, 96px);">
    <div class="container" style="text-align:center;">
      <div class="section-head center" data-reveal>
        <p class="eyebrow eyebrow-center">{{ setting('marquee_eyebrow', 'For every occasion') }}</p>
        <h2>{!! setting('marquee_heading', 'Whenever words aren\'t <em>enough.</em>') !!}</h2>
      </div>
    </div>
    <div class="marquee" data-reveal="fade" aria-label="Gifting occasions">
      <div class="marquee-track">
        @php
          $rawChips = setting('marquee_chips', 'Anniversaries, Birthdays, Weddings, Diwali, Raksha Bandhan, Mother\'s Day, Father\'s Day, Valentine\'s Day, Proposals, Retirement, Graduation, Baby\'s First Year, Farewells');
          $chips = array_map('trim', explode(',', $rawChips));
        @endphp
        @foreach(array_merge($chips, $chips) as $chip)
          <a class="chip" href="{{ route('occasions') }}">{{ $chip }}</a>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  <!-- ================= FAQ TEASER ================= -->
  @if(\App\Support\Sections::enabled('faqteaser'))
  <section class="section {{ \App\Support\Sections::tint() }}">
    <div class="container-narrow">
      <div class="section-head center" data-reveal>
        <p class="eyebrow eyebrow-center">Good questions</p>
        <h2>Everything you're <em>wondering.</em></h2>
      </div>
      <div class="faq-list" data-reveal>
        @forelse($faqs as $faq)
          <div class="faq-item">
            <button class="faq-q"><span>{{ $faq->question }}</span>
              <span class="faq-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M12 4v16M4 12h16"/></svg></span>
            </button>
            <div class="faq-a"><div><p>{{ $faq->answer }}</p></div></div>
          </div>
        @empty
          <div class="faq-item">
            <button class="faq-q"><span>What if I'm not a writer?</span>
              <span class="faq-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M12 4v16M4 12h16"/></svg></span>
            </button>
            <div class="faq-a"><div><p>You don't need to be. You share memories the way you'd tell them to a friend...</p></div></div>
          </div>
        @endforelse
      </div>
      <div style="text-align:center; margin-top: 40px;" data-reveal>
        <a class="text-link" href="{{ route('faq') }}">Read all questions
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
        </a>
      </div>
    </div>
  </section>
  @endif

  <!-- ================= FINAL CTA ================= -->
  @if(\App\Support\Sections::enabled('cta'))
  <section class="final-cta">
    <div class="bg" style="background-image:url('{{ asset(setting('cta_bg_image', 'assets/img/spread-under-stars.webp')) }}')" role="img" aria-label="Illustration of a couple lying on a hillside pointing at the stars above their city"></div>
    <div class="container inner">
      <p class="eyebrow eyebrow-center" data-reveal>{{ setting('cta_eyebrow', 'BEGIN TONIGHT') }}</p>
      <h2 data-reveal>{!! setting('cta_heading', 'Every relationship has a story worth <em>preserving.</em>') !!}</h2>
      <p data-reveal>{!! setting('cta_desc', 'Another occasion will come around soon. This time, give them something that says everything — and stays said, forever.') !!}</p>
      <div class="btn-row" data-reveal>
        <a class="btn btn-primary" href="{{ setting('cta_btn1_link', route('begin')) }}">
          {{ setting('cta_btn1_text', 'BEGIN YOUR STORY') }}
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
        </a>
        <a class="btn btn-ghost-light" href="{{ setting('cta_btn2_link', route('library')) }}">{{ setting('cta_btn2_text', 'READ A STORYLOOM') }}</a>
      </div>
      <p class="subnote" data-reveal>{{ setting('cta_subnote_text', 'We’ll guide you through every step') }}</p>
    </div>
  </section>
  @php \App\Support\Sections::breakTint(); @endphp
  @endif
@endsection
