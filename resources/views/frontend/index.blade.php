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
        <p class="eyebrow eyebrow-center" data-hero="1">{{ $hero->subheading ?? setting('hero_subheading', 'PERSONALISED KEEPSAKE STORYBOOKS') }}</p>
        <h1 data-hero="2">{!! $hero->heading ?? setting('hero_heading', 'The story only <em>you</em> could give.') !!}</h1>
        <p class="sub" data-hero="3">{{ $hero->description ?? setting('hero_description', 'We transform your memories into a beautifully illustrated keepsake book — every page painted around your people, your places, and the moments that made you a family.') }}</p>
        <div class="btn-row btn-row-center" data-hero="4">
          <a class="btn btn-primary" href="{{ $hero->button_link ?? setting('hero_btn1_link', route('begin')) }}">
            {{ $hero->button_text ?? setting('hero_btn1_text', 'BEGIN YOUR STORY') }}
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
  </section>

  <!-- ================= PROBLEM ================= -->
  <section class="section section-tint grain">
    <div class="container">
      <div class="section-head center" data-reveal>
        <p class="eyebrow eyebrow-center">{{ setting('problem_eyebrow', 'The trouble with gifts') }}</p>
        <h2>{!! setting('problem_heading', 'Most gifts are <em>forgotten.</em>') !!}</h2>
      </div>
      <div class="fading-gifts">
        <div class="fading-gift" data-reveal style="--stagger:0">
          <span class="word">{{ setting('problem_gift1_word', 'Flowers') }}</span>
          <span class="fate">{{ setting('problem_gift1_fate', 'fade in a week') }}</span>
        </div>
        <div class="fading-gift" data-reveal style="--stagger:1">
          <span class="word">{{ setting('problem_gift2_word', 'Chocolates') }}</span>
          <span class="fate">{{ setting('problem_gift2_fate', 'disappear in a day') }}</span>
        </div>
        <div class="fading-gift" data-reveal style="--stagger:2">
          <span class="word">{{ setting('problem_gift3_word', 'Gadgets') }}</span>
          <span class="fate">{{ setting('problem_gift3_fate', 'are replaced next year') }}</span>
        </div>
      </div>
      <div class="section-head center" data-reveal style="margin-bottom:0">
        <p class="lede">{{ setting('problem_lede', 'The people who shaped your life deserve something that says exactly what they mean to you — and keeps saying it, for years.') }}</p>
      </div>
    </div>
  </section>

  <!-- ================= REVEAL ================= -->
  <section class="section">
    <div class="container">
      <div class="section-head center" data-reveal>
        <p class="eyebrow eyebrow-center">{{ setting('reveal_eyebrow', 'Introducing Storyloom') }}</p>
        <h2>{!! setting('reveal_heading', 'Your memories, woven into a <em>storybook.</em>') !!}</h2>
        <p class="lede">{{ setting('reveal_lede', 'A completely personalised, hand-illustrated book created from your memories — an original story where every detail belongs to your family alone.') }}</p>
      </div>
      <div class="weave-gallery">
        @forelse($projects->where('featured', true)->take(3) as $index => $project)
          <figure class="plate hoverable" data-reveal style="--stagger:{{ $index }}">
            @if($project->images && count($project->images) > 0)
              <img src="{{ asset($project->images[0]) }}" loading="lazy" decoding="async" width="600" height="400" alt="{{ $project->title }}">
            @endif
            <figcaption class="caption">{{ $project->title }}</figcaption>
          </figure>
        @empty
          <!-- Fallback plates if database empty -->
          <figure class="plate hoverable" data-reveal style="--stagger:0">
            <img src="{{ asset('assets/img/spread-home-morning.webp') }}" loading="lazy" decoding="async" width="600" height="338" alt="Illustrated living room">
            <figcaption class="caption">the flat where it all began</figcaption>
          </figure>
          <figure class="plate hoverable" data-reveal style="--stagger:1">
            <img src="{{ asset('assets/img/spread-flower-street.webp') }}" loading="lazy" decoding="async" width="600" height="801" alt="Walking at sunset">
            <figcaption class="caption">the evening walk, every single day</figcaption>
          </figure>
          <figure class="plate hoverable" data-reveal style="--stagger:2">
            <img src="{{ asset('assets/img/spread-shared-fries.webp') }}" loading="lazy" decoding="async" width="600" height="801" alt="Sharing fries">
            <figcaption class="caption">one plate, two forks — always</figcaption>
          </figure>
        @endforelse
      </div>
      <div style="text-align:center; margin-top: clamp(40px, 6vh, 64px)" data-reveal>
        <a class="text-link" href="{{ route('library') }}">Read a Storyloom
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
        </a>
      </div>
    </div>
  </section>

  <!-- ================= STORY EXAMPLES ================= -->
  <section class="section section-tint grain">
    <div class="container">
      <div class="section-head" data-reveal>
        <p class="eyebrow">Who is your story for?</p>
        <h2>Every relationship has its own <em>book.</em></h2>
      </div>
      <div class="story-grid">
        @forelse($portfolios as $index => $port)
          <a class="story-card" href="{{ route('occasions') }}" data-reveal style="--stagger:{{ $index % 3 }}">
            <span class="img-wrap"><img src="{{ asset($port->thumbnail) }}" loading="lazy" decoding="async" width="400" height="300" alt="{{ $port->title }}"></span>
            <span class="story-label"><span class="for">{{ $port->title }}</span><span class="hint">{{ $port->category }}</span></span>
          </a>
        @empty
          <a class="story-card" href="{{ route('occasions') }}" data-reveal style="--stagger:0">
            <span class="img-wrap"><img src="{{ asset('assets/img/spread-bench-sunset.webp') }}" loading="lazy" decoding="async" width="400" height="300" alt="Sunset couple"></span>
            <span class="story-label"><span class="for">For Your Wife</span><span class="hint">anniversaries · birthdays</span></span>
          </a>
        @endforelse
      </div>
    </div>
  </section>

  <!-- ================= PROCESS ================= -->
  <section class="section">
    <div class="container">
      <div class="section-head center" data-reveal>
        <p class="eyebrow eyebrow-center">{{ setting('process_eyebrow', 'The plan') }}</p>
        <h2>{!! setting('process_heading', 'Three steps to a story they\'ll <em>never forget.</em>') !!}</h2>
      </div>
      <div class="process-grid">
        <div class="process-step" data-reveal style="--stagger:0">
          <div class="step-no">I</div>
          <h3>{{ setting('process_step1_title', 'Share Your Story') }}</h3>
          <p>{{ setting('process_step1_desc', 'Tell us about them — the memories, the inside jokes, the places, the photographs. A gentle conversation, not a form. Whatever you have is enough.') }}</p>
          <span class="process-line" aria-hidden="true"></span>
        </div>
        <div class="process-step" data-reveal style="--stagger:1">
          <div class="step-no">II</div>
          <h3>{{ setting('process_step2_title', 'Refine It Together') }}</h3>
          <p>{{ setting('process_step2_desc', 'Our writers shape your memories into a story; our illustrators paint your world into its pages. You review everything and we refine it until it feels exactly right.') }}</p>
          <span class="process-line" aria-hidden="true"></span>
        </div>
        <div class="process-step" data-reveal style="--stagger:2">
          <div class="step-no">III</div>
          <h3>{{ setting('process_step3_title', 'Receive Your Storyloom') }}</h3>
          <p>{{ setting('process_step3_desc', 'A hardbound, archival-quality book arrives at your door — wrapped, sealed, and ready for the moment they open it.') }}</p>
        </div>
      </div>
      <div style="text-align:center; margin-top: clamp(40px, 6vh, 60px)" data-reveal>
        <a class="text-link" href="{{ route('how-it-works') }}">See the full journey
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
        </a>
      </div>
    </div>
  </section>

  <!-- ================= WHY / TRANSFORMATION ================= -->
  <section class="section section-tint grain">
    <div class="container">
      <div class="section-head" data-reveal>
        <p class="eyebrow">{{ setting('why_eyebrow', 'Why Storyloom') }}</p>
        <h2>{!! setting('why_heading', 'Not a product. A <em>moment.</em>') !!}</h2>
      </div>
      <div class="occasion-grid" style="grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));">
        <div class="card" data-reveal style="--stagger:0">
          <h3 style="font-size:1.3rem; margin-bottom:10px;">{{ setting('why_card1_title', 'A story, not a spec') }}</h3>
          <p style="font-size:.95rem; color:var(--ink-soft);">{{ setting('why_card1_desc', 'Not “32 pages” — a complete story they\'ll return to again and again, with a beginning, a middle, and your ending.') }}</p>
        </div>
        <div class="card" data-reveal style="--stagger:1">
          <h3 style="font-size:1.3rem; margin-bottom:10px;">{{ setting('why_card2_title', 'Made to be handed down') }}</h3>
          <p style="font-size:.95rem; color:var(--ink-soft);">{{ setting('why_card2_desc', 'Not “premium paper” — a book crafted to survive decades of bedtime readings, and still be there for the grandchildren.') }}</p>
        </div>
        <div class="card" data-reveal style="--stagger:2">
          <h3 style="font-size:1.3rem; margin-bottom:10px;">{{ setting('why_card3_title', 'Unmistakably them') }}</h3>
          <p style="font-size:.95rem; color:var(--ink-soft);">{{ setting('why_card3_desc', 'Their likeness, their street, their chai stall. A Storyloom could never belong to any other family — every detail on the page belongs to this one.') }}</p>
        </div>
        <div class="card" data-reveal style="--stagger:3">
          <h3 style="font-size:1.3rem; margin-bottom:10px;">{{ setting('why_card4_title', 'Painterly, calm, classic') }}</h3>
          <p style="font-size:.95rem; color:var(--ink-soft);">{{ setting('why_card4_desc', 'Closer to fine illustration than bright cartoon templates — art that belongs on a shelf, and in a will.') }}</p>
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

  <!-- ================= TESTIMONIALS ================= -->
  <section class="section section-dark" aria-label="What families say">
    <div class="container">
      <div class="section-head center" data-reveal>
        <p class="eyebrow eyebrow-center">{{ setting('testimonial_eyebrow', 'The moment it opens') }}</p>
        <h2>{!! setting('testimonial_heading', 'Some gifts get a thank-you. <em>These get tears.</em>') !!}</h2>
      </div>
      <div class="testimonial-stage" data-reveal>
        @forelse($testimonials as $index => $test)
          <div class="testimonial {{ $index === 0 ? 'is-active' : '' }}">
            <blockquote>“{{ $test->review }}”</blockquote>
            <cite>{{ $test->client_name }} @if($test->designation), {{ $test->designation }}@endif</cite>
          </div>
        @empty
          <div class="testimonial is-active">
            <blockquote>“My mother read it aloud twice, cried both times, and now it lives on her bedside table. Nothing I've ever given her has come close.”</blockquote>
            <cite>A daughter's gift, for her mother's 60th</cite>
          </div>
        @endforelse
      </div>
      <div class="testimonial-dots" role="tablist" aria-label="Choose testimonial">
        @foreach($testimonials as $index => $test)
          <button role="tab" aria-selected="{{ $index === 0 ? 'true' : 'false' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Testimonial {{ $index + 1 }}"></button>
        @endforeach
      </div>
    </div>
  </section>

  <!-- ================= OCCASIONS MARQUEE ================= -->
  <section class="section grain" style="padding-bottom: clamp(56px, 8vh, 96px);">
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

  <!-- ================= FAQ TEASER ================= -->
  <section class="section section-tint">
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

  <!-- ================= FINAL CTA ================= -->
  <section class="final-cta">
    <div class="bg" style="background-image:url('{{ asset(setting('cta_bg_image', 'assets/img/spread-under-stars.webp')) }}')" role="img" aria-label="Illustration of a couple lying on a hillside pointing at the stars above their city"></div>
    <div class="container inner">
      <p class="eyebrow eyebrow-center" data-reveal>{{ setting('cta_eyebrow', 'BEGIN TONIGHT') }}</p>
      <h2 data-reveal>{!! setting('cta_heading', 'Every relationship has a story worth <em>preserving.</em>') !!}</h2>
      <p data-reveal>{{ setting('cta_desc', 'Another occasion will come around soon. This time, give them something that says everything — and stays said, forever.') }}</p>
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
@endsection
