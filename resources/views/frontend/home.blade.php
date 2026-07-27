@extends('layouts.app')

@section('content')

  <!-- ================= HERO (scroll-morph loom) ================= -->
  <section class="loom-hero" aria-label="Storyloom introduction">
    <div class="loom-stage">
      <div class="loom-bg" aria-hidden="true">
        <img src="{{ asset($hero->bg_image ?? 'assets/img/spread-bench-dusk.webp') }}" alt="" loading="eager" decoding="async">
      </div>
      <div class="loom-cards" aria-hidden="true"></div>
      <div class="loom-copy">
        <p class="eyebrow eyebrow-center">{{ $hero->subheading ?? 'Personalised keepsake storybooks' }}</p>
        <h1>{!! $hero->heading ?? 'The story only <em>you</em> could give.' !!}</h1>
        <p class="loom-hint">Scroll to open the book<span class="hint-line" aria-hidden="true"></span></p>
        <div class="loom-sub">
          <p class="sub">{{ $hero->description ?? 'We transform your memories into a beautifully illustrated keepsake book — every page painted around your people, your places, and the moments that made you a family.' }}</p>
          <div class="btn-row">
            <a class="btn btn-primary" href="{{ $hero->button_link ?? route('begin') }}">{{ $hero->button_text ?? 'Begin Your Story' }}
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
            </a>
            <a class="btn btn-ghost" href="{{ route('library') }}">Read a Storyloom</a>
          </div>
          <p class="hero-note">
            <span class="stars" aria-hidden="true">
              @for($i = 0; $i < 5; $i++)
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.5l2.9 6.2 6.6.8-4.9 4.6 1.3 6.6L12 17.4l-5.9 3.3 1.3-6.6L2.5 9.5l6.6-.8z"/></svg>
              @endfor
            </span>
            Illustrated by hand &nbsp;·&nbsp; Crafted in India &nbsp;·&nbsp; Delivered worldwide
          </p>
        </div>
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
          <span class="word">{{ setting('problem_gift_1_word', 'Flowers') }}</span>
          <span class="fate">{{ setting('problem_gift_1_fate', 'fade in a week') }}</span>
        </div>
        <div class="fading-gift" data-reveal style="--stagger:1">
          <span class="word">{{ setting('problem_gift_2_word', 'Chocolates') }}</span>
          <span class="fate">{{ setting('problem_gift_2_fate', 'disappear in a day') }}</span>
        </div>
        <div class="fading-gift" data-reveal style="--stagger:2">
          <span class="word">{{ setting('problem_gift_3_word', 'Gadgets') }}</span>
          <span class="fate">{{ setting('problem_gift_3_fate', 'are replaced next year') }}</span>
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
        <p class="eyebrow eyebrow-center">Introducing Storyloom</p>
        <h2>Your memories, woven into a <em>storybook.</em></h2>
        <p class="lede">A completely personalised, hand-illustrated book created from your memories — an original story where every detail belongs to your family alone.</p>
      </div>
      <div class="weave-gallery">
        <figure class="plate hoverable" data-reveal style="--stagger:0">
          <img src="{{ asset('assets/img/spread-home-morning.webp') }}" width="1600" height="900" loading="lazy"
               alt="Illustrated spread of a sunlit living room with an open book and a cup of tea on the table">
          <figcaption class="caption">the flat where it all began</figcaption>
        </figure>
        <figure class="plate hoverable" data-reveal style="--stagger:1">
          <img src="{{ asset('assets/img/spread-flower-street.webp') }}" width="1100" height="1469" loading="lazy"
               alt="Illustration of a couple walking down a flowering street at golden hour">
          <figcaption class="caption">the evening walk, every single day</figcaption>
        </figure>
        <figure class="plate hoverable" data-reveal style="--stagger:2">
          <img src="{{ asset('assets/img/spread-shared-fries.webp') }}" width="1100" height="1469" loading="lazy"
               alt="Close-up illustration of two hands sharing a plate of fries at a café table">
          <figcaption class="caption">one plate, two forks — always</figcaption>
        </figure>
      </div>
      <div style="text-align:center; margin-top: clamp(40px, 6vh, 64px)" data-reveal>
        <a class="text-link" href="{{ route('library') }}">Read a complete Storyloom
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
        @foreach($projects as $index => $project)
          <a class="story-card" href="{{ route('library') }}" data-reveal style="--stagger:{{ $index % 3 }}">
            <span class="img-wrap"><img src="{{ asset($project->image) }}" width="1400" height="788" loading="lazy" alt="{{ $project->title }}"></span>
            <span class="story-label">
              <span class="for">{{ $project->title }}</span>
              <span class="hint">{{ $project->category }}</span>
            </span>
          </a>
        @endforeach
        
        @if($projects->isEmpty())
          <!-- Fallback dynamic cards if no seeded projects -->
          <a class="story-card" href="{{ route('occasions') }}" data-reveal style="--stagger:0">
            <span class="img-wrap"><img src="{{ asset('assets/img/spread-bench-sunset.webp') }}" width="1400" height="788" loading="lazy" alt=""></span>
            <span class="story-label"><span class="for">For Your Wife</span><span class="hint">anniversaries · birthdays</span></span>
          </a>
          <a class="story-card" href="{{ route('occasions') }}" data-reveal style="--stagger:1">
            <span class="img-wrap"><img src="{{ asset('assets/img/spread-cafe-window.webp') }}" width="1100" height="1469" loading="lazy" alt=""></span>
            <span class="story-label"><span class="for">For Your Husband</span><span class="hint">anniversaries · milestones</span></span>
          </a>
          <a class="story-card" href="{{ route('occasions') }}" data-reveal style="--stagger:2">
            <span class="img-wrap"><img src="{{ asset('assets/img/spread-street-morning.webp') }}" width="1400" height="788" loading="lazy" alt=""></span>
            <span class="story-label"><span class="for">For Mom</span><span class="hint">Mother\'s Day · birthdays</span></span>
          </a>
        @endif
      </div>
    </div>
  </section>

  <!-- ================= PROCESS ================= -->
  <section class="section">
    <div class="container">
      <div class="section-head center" data-reveal>
        <p class="eyebrow eyebrow-center">The plan</p>
        <h2>Three steps to a story they'll <em>never forget.</em></h2>
      </div>
      <div class="process-grid">
        <div class="process-step" data-reveal style="--stagger:0">
          <div class="step-no">I</div>
          <h3>Share Your Story</h3>
          <p>Tell us about them — the memories, the inside jokes, the places, the photographs. A gentle conversation, not a form. Whatever you have is enough.</p>
          <span class="process-line" aria-hidden="true"></span>
        </div>
        <div class="process-step" data-reveal style="--stagger:1">
          <div class="step-no">II</div>
          <h3>Refine It Together</h3>
          <p>Our writers shape your memories into a story; our illustrators paint your world into its pages. You review everything and we refine it until it feels exactly right.</p>
          <span class="process-line" aria-hidden="true"></span>
        </div>
        <div class="process-step" data-reveal style="--stagger:2">
          <div class="step-no">III</div>
          <h3>Receive Your Storyloom</h3>
          <p>A hardbound, archival-quality book arrives at your door — wrapped, sealed, and ready for the moment they open it.</p>
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
        <p class="eyebrow">Why Storyloom</p>
        <h2>Not a product. A <em>moment.</em></h2>
      </div>
      <div class="occasion-grid" style="grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));">
        <div class="card" data-reveal style="--stagger:0">
          <h3 style="font-size:1.3rem; margin-bottom:10px;">A story, not a spec</h3>
          <p style="font-size:.95rem; color:var(--ink-soft);">Not “32 pages” — a complete story they\'ll return to again and again, with a beginning, a middle, and your ending.</p>
        </div>
        <div class="card" data-reveal style="--stagger:1">
          <h3 style="font-size:1.3rem; margin-bottom:10px;">Made to be handed down</h3>
          <p style="font-size:.95rem; color:var(--ink-soft);">Not “premium paper” — a book crafted to survive decades of bedtime readings, and still be there for the grandchildren.</p>
        </div>
        <div class="card" data-reveal style="--stagger:2">
          <h3 style="font-size:1.3rem; margin-bottom:10px;">Unmistakably them</h3>
          <p style="font-size:.95rem; color:var(--ink-soft);">Their likeness, their street, their chai stall. A Storyloom could never belong to any other family — every detail on the page belongs to this one.</p>
        </div>
        <div class="card" data-reveal style="--stagger:3">
          <h3 style="font-size:1.3rem; margin-bottom:10px;">Painterly, calm, classic</h3>
          <p style="font-size:.95rem; color:var(--ink-soft);">Closer to fine illustration than bright cartoon templates — art that belongs on a shelf, and in a will.</p>
        </div>
      </div>

      <div style="padding-top: clamp(56px, 9vh, 88px)">
        <div class="transform-stage">
          <div class="transform-quote before" data-reveal="left">
            “I don't know what to gift them…”
            <span class="who">Every year, before</span>
          </div>
          <img class="transform-mark" src="{{ asset('assets/img/logo-emblem.png') }}" alt="" width="92" height="91" data-reveal>
          <div class="transform-quote after" data-reveal="right">
            “I can't believe you made this.”
            <span class="who">The moment they open it</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ================= TESTIMONIALS ================= -->
  <section class="section section-dark" aria-label="What families say">
    <div class="container">
      <div class="section-head center" data-reveal>
        <p class="eyebrow eyebrow-center">The moment it opens</p>
        <h2>Some gifts get a thank-you. <em>These get tears.</em></h2>
      </div>
      <div class="testimonial-stage" data-reveal>
        @foreach($testimonials as $index => $testimonial)
          <div class="testimonial {{ $index === 0 ? 'is-active' : '' }}">
            <blockquote>“{{ $testimonial->review }}”</blockquote>
            <cite>{{ $testimonial->client_name }}, {{ $testimonial->designation }}</cite>
          </div>
        @endforeach
      </div>
      <div class="testimonial-dots" role="tablist" aria-label="Choose testimonial">
        @foreach($testimonials as $index => $testimonial)
          <button aria-current="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Testimonial {{ $index + 1 }}"></button>
        @endforeach
      </div>
    </div>
  </section>

  <!-- ================= OCCASIONS MARQUEE ================= -->
  <section class="section grain" style="padding-bottom: clamp(56px, 8vh, 96px);">
    <div class="container" style="text-align:center;">
      <div class="section-head center" data-reveal>
        <p class="eyebrow eyebrow-center">For every occasion</p>
        <h2>Whenever words aren't <em>enough.</em></h2>
      </div>
    </div>
    <div class="marquee" data-reveal="fade" aria-label="Gifting occasions">
      <div class="marquee-track">
        @php
          $occasions = ['Anniversaries', 'Birthdays', 'Weddings', 'Diwali', 'Raksha Bandhan', 'Mother\'s Day', 'Father\'s Day', 'Valentine\'s Day', 'Proposals', 'Retirement', 'Graduation', 'Baby\'s First Year', 'Farewells'];
        @endphp
        @foreach(array_merge($occasions, $occasions) as $occ)
          <a class="chip" href="{{ route('occasions') }}">{{ $occ }}</a>
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
        @foreach($faqs as $faq)
          <div class="faq-item">
            <button class="faq-q"><span>{{ $faq->question }}</span>
              <span class="faq-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M12 4v16M4 12h16"/></svg></span>
            </button>
            <div class="faq-a"><div><p>{{ $faq->answer }}</p></div></div>
          </div>
        @endforeach
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
    <div class="bg" style="background-image:url('{{ asset('assets/img/spread-under-stars.webp') }}')" role="img"
         aria-label="Illustration of a couple lying on a hillside pointing at the stars above their city"></div>
    <div class="container inner">
      <p class="eyebrow eyebrow-center" data-reveal style="color:#D98A5A">Begin tonight</p>
      <h2 data-reveal>Every relationship has a story worth <em>preserving.</em></h2>
      <p data-reveal>Another occasion will come around soon. This time, give them something that says everything — and stays said, forever.</p>
      <div class="btn-row" style="justify-content:center;" data-reveal>
        <a class="btn btn-primary" href="{{ route('begin') }}">Begin Your Story
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
        </a>
        <a class="btn btn-outline-ghost" href="{{ route('library') }}">READ A STORYLOOM</a>
      </div>
    </div>
  </section>

@endsection

@push('scripts')
  <script src="{{ asset('assets/js/hero-loom.js') }}" defer></script>
@endpush
