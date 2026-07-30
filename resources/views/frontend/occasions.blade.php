@extends('layouts.app')

@section('content')
  <!-- Custom CSS matching screenshot formatting exactly -->
  <style>
    .hero-eyebrow-center {
      font-family: "Cormorant Garamond", Cormorant, Georgia, serif;
      font-style: normal;
      font-weight: 700;
      font-size: 14px;
      line-height: 24px;
      letter-spacing: 0.28em;
      text-transform: uppercase;
      color: rgb(181, 91, 41);
      margin-bottom: 24px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 16px;
    }
    .hero-eyebrow-center::before,
    .hero-eyebrow-center::after {
      content: "";
      display: inline-block;
      width: 36px;
      height: 1px;
      background-color: rgb(181, 91, 41);
      opacity: 0.85;
    }
    .eyebrow-left {
      font-family: "Cormorant Garamond", Cormorant, Georgia, serif;
      font-style: normal;
      font-weight: 700;
      font-size: 14px;
      line-height: 24px;
      letter-spacing: 0.28em;
      text-transform: uppercase;
      color: rgb(181, 91, 41);
      margin-bottom: 16px;
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .eyebrow-left::before {
      content: "";
      display: inline-block;
      width: 36px;
      height: 1px;
      background-color: rgb(181, 91, 41);
      opacity: 0.85;
    }
    .section-head-left {
      text-align: left;
      margin-bottom: clamp(36px, 5vh, 56px);
    }
    .section-head-left h2 {
      font-family: var(--font-display);
      font-size: clamp(2.2rem, 3.8vw, 3.2rem);
      line-height: 1.18;
      color: #1C222B;
      margin: 0;
      font-weight: 600;
    }
    .section-head-left h2 em {
      font-family: "Cormorant Garamond", Cormorant, Georgia, serif;
      font-style: italic;
      font-weight: 500;
      color: rgb(181, 91, 41);
    }

    /* 4-column card grid */
    .occasions-grid-4 {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: clamp(20px, 2.2vw, 30px);
    }

    /* Outline only — these cards don't link anywhere, so they get no fill, no
       lift and no shadow. The one hover response is a gentle zoom on the art
       (see .img-container img below): enough to feel alive, not enough to read
       as "click me". */
    .fest-card {
      background: transparent;
      border: 1px solid #DCD5C8;
      border-radius: 4px;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      height: 100%;
      cursor: default;
    }
    .fest-card .img-container {
      position: relative;
      width: 100%;
      padding-top: 68%; /* aspect ratio matching screenshot */
      overflow: hidden;
      background: #F3EFEA;
    }
    .fest-card .img-container img {
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      object-fit: cover;
      transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .fest-card:hover .img-container img {
      transform: scale(1.06);
    }
    @media (prefers-reduced-motion: reduce) {
      .fest-card .img-container img,
      .fest-card:hover .img-container img {
        transition: none;
        transform: none;
      }
    }
    .fest-card .card-content {
      padding: 16px 20px 24px;
      display: flex;
      flex-direction: column;
      flex-grow: 1;
    }
    .fest-card .pill-badge {
      display: inline-block;
      align-self: flex-start;
      font-size: 0.65rem;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      color: #7A756C;
      border: 1px solid #D8D2C7;
      border-radius: 999px;
      padding: 3px 14px;
      margin-bottom: 10px;
      font-weight: 500;
      background: transparent;
    }
    .fest-card h3 {
      font-family: var(--font-display);
      font-size: 1.25rem;
      font-weight: 600;
      color: #1C222B;
      margin: 0 0 8px 0;
      line-height: 1.3;
    }
    .fest-card p {
      font-size: 0.88rem;
      line-height: 1.55;
      color: #7A756C;
      margin: 0;
    }

    /* Relationship chips row */
    .relationship-chips {
      display: flex;
      flex-wrap: wrap;
      justify-content: flex-start;
      gap: 12px;
      margin-top: 28px;
      margin-bottom: 24px;
    }
    .chip-btn {
      display: inline-flex;
      align-items: center;
      padding: 10px 24px;
      border: 1px solid #D8D2C7;
      border-radius: 999px;
      background: #FFFFFF;
      color: #5C564C;
      font-size: 0.92rem;
      text-decoration: none;
      transition: all var(--dur-quick);
    }
    .chip-btn:hover {
      border-color: #C47D5A;
      color: #8C4724;
      background: #FAF2EC;
      transform: translateY(-2px);
    }

    .marquee-close-fade {
      overflow: hidden;
      white-space: nowrap;
      max-width: 1280px;
      margin-inline: auto;
      -webkit-mask-image: linear-gradient(90deg, transparent 0%, #000 18%, #000 82%, transparent 100%);
      mask-image: linear-gradient(90deg, transparent 0%, #000 18%, #000 82%, transparent 100%);
      padding-block: 8px;
    }

    @media (max-width: 1199px) {
      .occasions-grid-4 {
        grid-template-columns: repeat(2, 1fr);
      }
    }
    @media (max-width: 639px) {
      .occasions-grid-4 {
        grid-template-columns: 1fr;
      }
    }
  </style>

  <!-- ================= HERO ================= -->
  <section class="section grain" style="background: #f7f4ed; padding-top: clamp(65px, 7vh, 90px); padding-bottom: clamp(50px, 6vh, 70px);">
    <div class="container-narrow">
      <div class="section-head center" style="margin-bottom: 0;">
        <div class="hero-eyebrow-center">{{ setting('occasions_hero_eyebrow', 'OCCASIONS') }}</div>
        <h1 style="font-family: var(--font-display); font-size: clamp(2.6rem, 5vw, 4.4rem); font-weight: 600; line-height: 1.15; margin-bottom: 24px; color: #1C222B;">
          {!! setting('occasions_hero_heading', 'For the days that<br>deserve more than a <em style="font-family: \'Cormorant Garamond\', Cormorant, Georgia, serif; font-style: italic; font-weight: 500; color: rgb(181, 91, 41);">gift.</em>') !!}
        </h1>
        <p class="lede" style="font-family: 'Libre Caslon Text', 'Adobe Caslon Pro', Georgia, serif; font-style: normal; font-weight: 400; font-size: 18px; line-height: 32px; color: rgba(29, 42, 68, 0.74); max-width: 780px; width: 100%; margin-inline: auto;">
          {{ setting('occasions_hero_lede', 'Some occasions come with easy answers — a cake, a card, a voucher. And some deserve the one gift that could only ever belong to one person. A Storyloom takes three to five weeks to craft, so the best time to begin is now.') }}
        </p>
      </div>
    </div>
  </section>

  <!-- ================= SECTION 1: FESTIVALS & CELEBRATIONS ================= -->
  <section class="section grain" style="padding-top: clamp(60px, 8vh, 100px); padding-bottom: clamp(60px, 8vh, 100px); background: #f4f1eb;">
    <div class="container">
      <div class="section-head-left" data-reveal>
        <div class="eyebrow-left">{{ setting('festivals_eyebrow', 'FESTIVALS & CELEBRATIONS') }}</div>
        <h2>{!! setting('festivals_heading', 'Gifts for the days the<br>whole family <em>gathers.</em>') !!}</h2>
      </div>

      <div class="occasions-grid-4">
        <!-- Card 1: Diwali -->
        <div class="fest-card" data-reveal style="--stagger:0">
          <div class="img-container">
            <img src="{{ asset(setting('fest1_img', 'assets/img/spread-home-evening.webp')) }}" alt="Diwali" loading="lazy">
          </div>
          <div class="card-content">
            <span class="pill-badge">{{ setting('fest1_tag', 'FESTIVAL') }}</span>
            <h3>{{ setting('fest1_title', 'Diwali') }}</h3>
            <p>{!! setting('fest1_desc', 'Your family\'s own festival — opened together, kept forever.') !!}</p>
          </div>
        </div>

        <!-- Card 2: Raksha Bandhan -->
        <div class="fest-card" data-reveal style="--stagger:1">
          <div class="img-container">
            <img src="{{ asset(setting('fest2_img', 'assets/img/book2-spread-pool.webp')) }}" alt="Raksha Bandhan" loading="lazy">
          </div>
          <div class="card-content">
            <span class="pill-badge">{{ setting('fest2_tag', 'FESTIVAL') }}</span>
            <h3>{{ setting('fest2_title', 'Raksha Bandhan') }}</h3>
            <p>{!! setting('fest2_desc', 'The rakhi fades by winter. The story of a brother and sister doesn\'t.') !!}</p>
          </div>
        </div>

        <!-- Card 3: Mother's Day & Father's Day -->
        <div class="fest-card" data-reveal style="--stagger:2">
          <div class="img-container">
            <img src="{{ asset(setting('fest3_img', 'assets/img/spread-street-morning.webp')) }}" alt="Mother's Day & Father's Day" loading="lazy">
          </div>
          <div class="card-content">
            <span class="pill-badge">{{ setting('fest3_tag', 'FESTIVAL') }}</span>
            <h3>{{ setting('fest3_title', 'Mother\'s Day & Father\'s Day') }}</h3>
            <p>{!! setting('fest3_desc', 'Everything never said across the dinner table — said page by page.') !!}</p>
          </div>
        </div>

        <!-- Card 4: Valentine's Day -->
        <div class="fest-card" data-reveal style="--stagger:3">
          <div class="img-container">
            <img src="{{ asset(setting('fest4_img', 'assets/img/spread-alone-bench.webp')) }}" alt="Valentine's Day" loading="lazy">
          </div>
          <div class="card-content">
            <span class="pill-badge">{{ setting('fest4_tag', 'FESTIVAL') }}</span>
            <h3>{{ setting('fest4_title', 'Valentine\'s Day') }}</h3>
            <p>{!! setting('fest4_desc', 'How you actually fell in love — including the parts only you two know.') !!}</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ================= SECTION 2: MILESTONES ================= -->
  <section class="section" style="padding-top: clamp(60px, 8vh, 100px); padding-bottom: clamp(60px, 8vh, 100px); background: #f2ecdf;">
    <div class="container">
      <div class="section-head-left" data-reveal>
        <div class="eyebrow-left">{{ setting('milestones_eyebrow', 'MILESTONES') }}</div>
        <h2>{!! setting('milestones_heading', 'For the chapters that <em>close</em><br>— and the ones that open.') !!}</h2>
      </div>

      <!-- 8 Cards Grid (2 rows of 4) -->
      <div class="occasions-grid-4">
        <!-- Milestone 1: Anniversaries -->
        <div class="fest-card" data-reveal style="--stagger:0">
          <div class="img-container">
            <img src="{{ asset(setting('ms1_img', 'assets/img/spread-bench-sunset.webp')) }}" alt="Anniversaries" loading="lazy">
          </div>
          <div class="card-content">
            <h3>{{ setting('ms1_title', 'Anniversaries') }}</h3>
            <p>{!! setting('ms1_desc', 'Ten years, or fifty — written around the years you built together.') !!}</p>
          </div>
        </div>

        <!-- Milestone 2: Weddings -->
        <div class="fest-card" data-reveal style="--stagger:1">
          <div class="img-container">
            <img src="{{ asset(setting('ms2_img', 'assets/img/spread-flower-street.webp')) }}" alt="Weddings" loading="lazy">
          </div>
          <div class="card-content">
            <h3>{{ setting('ms2_title', 'Weddings') }}</h3>
            <p>{!! setting('ms2_desc', 'The story of how two hand-written paths came to intertwine together.') !!}</p>
          </div>
        </div>

        <!-- Milestone 3: Proposals -->
        <div class="fest-card" data-reveal style="--stagger:2">
          <div class="img-container">
            <img src="{{ asset(setting('ms3_img', 'assets/img/spread-under-stars.webp')) }}" alt="Proposals" loading="lazy">
          </div>
          <div class="card-content">
            <h3>{{ setting('ms3_title', 'Proposals') }}</h3>
            <p>{!! setting('ms3_desc', 'The moment you asked. The initial spark before the question.') !!}</p>
          </div>
        </div>

        <!-- Milestone 4: Birthdays -->
        <div class="fest-card" data-reveal style="--stagger:3">
          <div class="img-container">
            <img src="{{ asset(setting('ms4_img', 'assets/img/spread-shared-fries.webp')) }}" alt="Birthdays" loading="lazy">
          </div>
          <div class="card-content">
            <h3>{{ setting('ms4_title', 'Birthdays') }}</h3>
            <p>{!! setting('ms4_desc', 'Every landmark milestone, bound in one book.') !!}</p>
          </div>
        </div>

        <!-- Milestone 5: Retirement -->
        <div class="fest-card" data-reveal style="--stagger:0">
          <div class="img-container">
            <img src="{{ asset(setting('ms5_img', 'assets/img/spread-alone-bench.webp')) }}" alt="Retirement" loading="lazy">
          </div>
          <div class="card-content">
            <h3>{{ setting('ms5_title', 'Retirement') }}</h3>
            <p>{!! setting('ms5_desc', 'Forty years of work bound into more than a plaque and a pen.') !!}</p>
          </div>
        </div>

        <!-- Milestone 6: Baby's First Year -->
        <div class="fest-card" data-reveal style="--stagger:1">
          <div class="img-container">
            <img src="{{ asset(setting('ms6_img', 'assets/img/spread-home-morning.webp')) }}" alt="Baby's First Year" loading="lazy">
          </div>
          <div class="card-content">
            <h3>{{ setting('ms6_title', 'Baby\'s First Year') }}</h3>
            <p>{!! setting('ms6_desc', 'The small, fleeting moments recorded before they fade.') !!}</p>
          </div>
        </div>

        <!-- Milestone 7: Farewells & Long Distance -->
        <div class="fest-card" data-reveal style="--stagger:2">
          <div class="img-container">
            <img src="{{ asset(setting('ms7_img', 'assets/img/spread-night-farewell.webp')) }}" alt="Farewells & Long Distance" loading="lazy">
          </div>
          <div class="card-content">
            <h3>{{ setting('ms7_title', 'Farewells & Long Distance') }}</h3>
            <p>{!! setting('ms7_desc', 'A piece of home for someone who is moving across oceans.') !!}</p>
          </div>
        </div>

        <!-- Milestone 8: Graduation -->
        <div class="fest-card" data-reveal style="--stagger:3">
          <div class="img-container">
            <img src="{{ asset(setting('ms8_img', 'assets/img/spread-cafe-window.webp')) }}" alt="Graduation" loading="lazy">
          </div>
          <div class="card-content">
            <h3>{{ setting('ms8_title', 'Graduation') }}</h3>
            <p>{!! setting('ms8_desc', 'From first desk to first degree, recorded in a book.') !!}</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ================= SECTION 3: BY RELATIONSHIP ================= -->
  <section class="section grain" style="padding-top: clamp(60px, 8vh, 100px); padding-bottom: clamp(60px, 8vh, 100px); background: #f5f2eb; overflow: hidden;">
    <div class="container">
      <div class="section-head-left" data-reveal>
        <div class="eyebrow-left">{{ setting('rel_eyebrow', 'BY RELATIONSHIP') }}</div>
        <h2>{!! setting('rel_heading', 'Whoever they are to<br>you, there\'s a <em>book</em> in it.') !!}</h2>
      </div>
    </div>

    <!-- Infinite Marquee Ticker Scroll with closer fade -->
    <div class="marquee marquee-close-fade" data-reveal="fade" aria-label="Relationship tags" style="margin-top: 24px; margin-bottom: 24px;">
      <div class="marquee-track">
        @php
          $rawChips = setting('rel_chips', 'For a best friend, For a teacher, For a mentor, For your wife, For your husband, For Mom, For Dad, For your partner');
          $chips = array_map('trim', explode(',', $rawChips));
        @endphp
        @foreach(array_merge($chips, $chips, $chips) as $chip)
          <a class="chip" href="{{ route('begin') }}">{{ $chip }}</a>
        @endforeach
      </div>
    </div>

    <div class="container" style="text-align: center;">
      <p style="font-family: 'Edu SA Hand', 'Segoe Script', cursive; font-style: normal; font-weight: 400; font-size: 18px; line-height: 31px; color: rgb(181, 91, 41); margin-top: 16px; text-align: center;" data-reveal>
        {{ setting('rel_subnote', '...and for relationships that don\'t have a neat name — those often make the best books.') }}
      </p>
    </div>
  </section>

  <!-- ================= SECTION 4: FINAL CTA ================= -->
  <section class="final-cta">
    <div class="bg" style="background-image:url('{{ asset(setting('occasion_cta_bg', 'assets/img/spread-bench-dusk.webp')) }}')" role="img" aria-label="Illustration of a couple watching dusk city lights"></div>
    <div class="container inner">
      <h2 data-reveal>{!! setting('occasion_banner_heading', 'Which occasion is coming <em>next?</em>') !!}</h2>
      <p data-reveal style="max-width: 58ch; margin-inline: auto;">{!! setting('occasion_banner_desc', 'A Storyloom takes three to four weeks to craft. Cover books take 3 weeks from draft... Tell us your story, and return with the perfect custom gift saved in time.') !!}</p>
      <div class="btn-row" style="justify-content:center; margin-top: 28px;" data-reveal>
        <a class="btn btn-primary" href="{{ route('begin') }}">{{ setting('cta_btn1_text', 'BEGIN YOUR STORY') }}
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
        </a>
      </div>
    </div>
  </section>
@endsection
