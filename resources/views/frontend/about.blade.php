@extends('layouts.app')

@section('content')
  <!-- Custom CSS for About Page matching design screenshot -->
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

    /* Drop Cap for About Prose */
    .about-prose p.drop::first-letter {
      font-family: var(--font-display);
      float: left;
      font-size: 3.6rem;
      line-height: 0.85;
      padding-top: 4px;
      padding-right: 12px;
      padding-bottom: 2px;
      color: rgb(181, 91, 41);
      font-weight: 600;
    }

    .about-prose p {
      font-family: 'Libre Caslon Text', 'Adobe Caslon Pro', Georgia, serif;
      font-style: normal;
      font-weight: 400;
      font-size: 18px;
      line-height: 32px;
      color: rgba(29, 42, 68, 0.74);
      margin-bottom: 20px;
    }

    /* Artwork Polaroid Card */
    .artwork-card {
      background: #FFFFFF;
      padding: 8px 8px 16px;
      border: 1px solid #E8E3DB;
      border-radius: 4px;
      box-shadow: 0 20px 48px rgba(0, 0, 0, 0.08);
      transition: transform var(--dur-quick), box-shadow var(--dur-quick);
    }
    .artwork-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 24px 56px rgba(0, 0, 0, 0.12);
    }
    .artwork-card .img-wrapper {
      position: relative;
      width: 100%;
      padding-top: 132%; /* Taller, grander polaroid ratio */
      overflow: hidden;
      border-radius: 2px;
      background: #F3EFEA;
    }
    .artwork-card .img-wrapper img {
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      object-fit: cover;
    }
    .artwork-card .caption {
      font-family: 'Edu SA Hand', 'Segoe Script', cursive;
      font-style: normal;
      font-weight: 400;
      font-size: 16px;
      line-height: 24px;
      color: #8A857C;
      text-align: center;
      margin-top: 18px;
    }

    /* 4-column card grid */
    .about-grid-4 {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: clamp(20px, 2.2vw, 30px);
    }

    .stand-card {
      background: #FFFFFF;
      border: 1px solid #E8E3DB;
      border-radius: 4px;
      padding: 28px 24px;
      height: 100%;
      transition: transform var(--dur-quick), box-shadow var(--dur-quick);
    }
    .stand-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 28px rgba(0,0,0,0.06);
    }
    .stand-card h3 {
      font-family: var(--font-display);
      font-size: 1.25rem;
      font-weight: 600;
      color: #1C222B;
      margin-0 0 12px 0;
      line-height: 1.3;
    }
    .stand-card p {
      font-size: 0.92rem;
      line-height: 1.6;
      color: #7A756C;
      margin: 0;
    }

    /* Founder Note Banner */
    .founder-banner-eyebrow {
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
    .founder-banner-eyebrow::before,
    .founder-banner-eyebrow::after {
      content: "";
      display: inline-block;
      width: 36px;
      height: 1px;
      background-color: rgb(181, 91, 41);
      opacity: 0.85;
    }

    @media (max-width: 991px) {
      .about-grid-4 {
        grid-template-columns: repeat(2, 1fr);
      }
    }
    @media (max-width: 639px) {
      .about-grid-4 {
        grid-template-columns: 1fr;
      }
      .dual-grid-2 {
        grid-template-columns: 1fr !important;
      }
    }

    .btn-outline-ghost {
      border: 1px solid rgba(255, 255, 255, 0.4);
      background: transparent;
      color: #FFFFFF !important;
      transition: all 0.25s ease;
    }
    .btn-outline-ghost:hover {
      background: #F4F1EB !important;
      color: #1C222B !important;
      border-color: #F4F1EB !important;
    }
  </style>

  <!-- ================= SECTION 1: HERO & STORY PROSE ================= -->
  <section class="section grain" style="background: #f7f4ed; padding-top: clamp(65px, 8vh, 100px); padding-bottom: clamp(75px, 9vh, 115px);">
    <div class="container">
      <div class="section-head center" style="margin-bottom: clamp(48px, 6vh, 75px);">
        <div class="hero-eyebrow-center">{{ setting('about_hero_eyebrow', 'ABOUT STORYLOOM') }}</div>
        <h1 style="font-family: 'Cormorant Garamond', Cormorant, Georgia, serif; font-style: normal; font-weight: 600; font-size: clamp(2.4rem, 4.2vw, 56px); line-height: clamp(2.8rem, 4.8vw, 66px); color: rgb(29, 42, 68); max-width: 960px; width: 100%; margin-inline: auto; text-align: center; letter-spacing: -0.01em;">
          {!! setting('about_hero_heading', 'We exist because memories<br>deserve better than a <em style="font-family: \'Cormorant Garamond\', Cormorant, Georgia, serif; font-style: italic; font-weight: 500; color: rgb(181, 91, 41);">camera roll.</em>') !!}
        </h1>
      </div>

      <div class="dual-grid-2" style="display: grid; grid-template-columns: 0.92fr 1.08fr; gap: clamp(32px, 5vw, 64px); align-items: center;">
        <!-- Left Column: Story Prose -->
        <div class="about-prose" data-reveal="left">
          <p class="drop">{{ setting('about_hero_p1', 'Families have stories. Often hundreds — and most of them die with us.') }}</p>
          <p>{{ setting('about_hero_p2', 'They live in WhatsApp, scattered across hard drives, lost in phones and albums nobody opens. And as time passes, the details start to blur, and memories lose their frame.') }}</p>
          <p>{{ setting('about_hero_p3', 'The story is the most valuable thing a family can leave behind. It deserves better than a screen.') }}</p>
        </div>

        <!-- Right Column: Artwork Polaroid Card -->
        <div data-reveal="right">
          <div class="artwork-card">
            <div class="img-wrapper">
              <img src="{{ asset(setting('about_artwork_img', 'assets/img/spread-street-morning.webp')) }}" alt="An everyday moment captured for a family heirloom" loading="lazy">
            </div>
            <div class="caption">
              {{ setting('about_artwork_caption', 'An everyday moment — captured for a family heirloom.') }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ================= SECTION 2: WHAT WE STAND FOR ================= -->
  <section class="section grain" style="background: #f2ecdf; padding-top: clamp(60px, 8vh, 100px); padding-bottom: clamp(60px, 8vh, 100px);">
    <div class="container">
      <div class="section-head center" data-reveal style="margin-bottom: clamp(40px, 6vh, 64px);">
        <div class="hero-eyebrow-center">{{ setting('stand_eyebrow', 'WHAT WE STAND FOR') }}</div>
        <h2 style="font-family: var(--font-display); font-size: clamp(2.2rem, 3.8vw, 3.2rem); font-weight: 600; line-height: 1.18; color: #1C222B; margin: 0;">
          {!! setting('stand_heading', 'Craftsmanship over speed.<br>Specificity over <em style="font-family: \'Cormorant Garamond\', Cormorant, Georgia, serif; font-style: italic; font-weight: 500; color: rgb(181, 91, 41);">sentiment.</em>') !!}
        </h2>
      </div>

      <!-- 4 Cards Grid -->
      <div class="about-grid-4">
        <!-- Card 1 -->
        <div class="stand-card" data-reveal style="--stagger:0">
          <h3>{{ setting('stand_card1_title', 'Every detail belongs to you') }}</h3>
          <p>{{ setting('stand_card1_desc', 'It\'s not a generic template. Every illustration — every street, corner, face — belongs to your story.') }}</p>
        </div>

        <!-- Card 2 -->
        <div class="stand-card" data-reveal style="--stagger:1">
          <h3>{{ setting('stand_card2_title', 'The book is the monument') }}</h3>
          <p>{{ setting('stand_card2_desc', 'Not a photo album. A custom hardbound book built to last longer than the memories inside it.') }}</p>
        </div>

        <!-- Card 3 -->
        <div class="stand-card" data-reveal style="--stagger:2">
          <h3>{{ setting('stand_card3_title', 'Paper, not plastic') }}</h3>
          <p>{{ setting('stand_card3_desc', 'Archival-quality paper, cloth-bound covers, true hot-stamped foil.') }}</p>
        </div>

        <!-- Card 4 -->
        <div class="stand-card" data-reveal style="--stagger:3">
          <h3>{{ setting('stand_card4_title', 'Made to be handed down') }}</h3>
          <p>{{ setting('stand_card4_desc', 'Built for living rooms — built to be kept for generations.') }}</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ================= SECTION 3: THE MARK WE MAKE ================= -->
  <section class="section grain" style="background: #f5f2eb; padding-top: clamp(65px, 8vh, 105px); padding-bottom: clamp(65px, 8vh, 105px);">
    <div class="container">
      <div class="dual-grid-2" style="display: grid; grid-template-columns: 0.95fr 1.05fr; gap: clamp(40px, 6vw, 80px); align-items: center;">
        <!-- Left Column: Circular Logo Crest -->
        <div style="text-align: center;" data-reveal="left">
          <div style="display: inline-block; width: 360px; max-width: 100%;">
            <img src="{{ asset(setting('site_logo_dark', 'assets/img/logo-primary.png')) }}" alt="Storyloom Emblem Crest" style="width: 360px; height: auto; max-width: 100%; object-fit: contain;">
          </div>
        </div>

        <!-- Right Column: Mark Details -->
        <div data-reveal="right">
          <div class="eyebrow-left">{{ setting('mark_eyebrow', 'THE MARK WE MAKE') }}</div>
          <h2 style="font-family: 'Cormorant Garamond', Cormorant, Georgia, serif; font-size: clamp(2.3rem, 4.2vw, 56px); line-height: clamp(2.7rem, 4.8vw, 66px); font-weight: 600; color: #1C222B; margin-bottom: 24px;">
            {!! setting('mark_heading', 'An heirloom mark,<br>not a <em style="font-family: \'Cormorant Garamond\', Cormorant, Georgia, serif; font-style: italic; font-weight: 500; color: rgb(181, 91, 41);">startup logo.</em>') !!}
          </h2>
          <div class="about-prose">
            <p>{{ setting('mark_p1', 'Look closely at our emblem. At the top, a loom — vertical posts with threads strung between them: a family\'s scattered moments, still unformed. Below, those same threads fall and open into the pages of a book. One becomes the other.') }}</p>
            <p>{{ setting('mark_p2', 'The double ring borrows from seals and crests — marks that have always signified craftsmanship and things made to be handed down. It only reveals itself on a second look. So do our books.') }}</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ================= SECTION 4: A NOTE FROM THE FOUNDER ================= -->
  <section class="section grain" style="background: #f1ece0; padding-top: clamp(80px, 10vh, 120px); padding-bottom: clamp(80px, 10vh, 120px); text-align: center; color: #1C222B;">
    <div class="container-narrow" style="max-width: 940px; margin-inline: auto;">
      <div class="founder-banner-eyebrow" data-reveal style="color: rgb(181, 91, 41); font-family: 'Cormorant Garamond', Cormorant, Georgia, serif; font-size: 14px; font-weight: 700; letter-spacing: 0.28em; text-transform: uppercase; margin-bottom: 0;">
        {{ setting('founder_eyebrow', 'A NOTE FROM THE FOUNDER') }}
      </div>
      
      <p data-reveal style="font-family: 'Cormorant Garamond', Cormorant, Georgia, serif; font-style: italic; font-weight: 500; font-size: clamp(1.5rem, 2.5vw, 32px); line-height: clamp(2.2rem, 3.8vw, 48px); color: #1C222B; max-width: 900px; margin-inline: auto; margin-top: clamp(28px, 4vh, 38px); margin-bottom: clamp(28px, 4vh, 38px);">
        {{ setting('founder_quote', '“I started Storyloom after watching my mother re-read a forty-year-old letter until the folds wore through. We keep almost nothing now. I wanted to build the thing families keep.”') }}
      </p>

      <div data-reveal style="font-family: 'Libre Caslon Text', 'Adobe Caslon Pro', Georgia, serif; font-style: normal; font-weight: 600; font-size: 14px; line-height: 25px; letter-spacing: 0.28em; text-transform: uppercase; color: rgb(181, 91, 41);">
        {{ setting('founder_author', 'MANAN · FOUNDER, STORYLOOM') }}
      </div>
    </div>
  </section>

  <!-- ================= SECTION 5: FINAL CTA ================= -->
  <section class="final-cta">
    <div class="bg" style="background-image:url('{{ asset(setting('about_cta_bg', 'assets/img/spread-alone-bench.webp')) }}')" role="img" aria-label="Illustration of a couple watching dusk city lights"></div>
    <div class="container inner">
      <h2 data-reveal>{!! setting('about_cta_heading', 'Your family\'s chapter<br>is <em style="font-family: \'Cormorant Garamond\', Cormorant, Georgia, serif; font-style: italic; font-weight: 500; color: #E88B52;">ready</em> to be written.') !!}</h2>
      <p data-reveal style="max-width: 620px; width: 100%; margin-inline: auto; font-size: 1.05rem; line-height: 1.65; color: rgba(255, 255, 255, 0.78);">
        {{ setting('about_cta_desc', 'Somewhere a memory is waiting to be told and painted into a book. Tell us your story to begin, or read a storyloom.') }}
      </p>
      <div class="btn-row" style="justify-content:center; gap: 16px; margin-top: 28px;" data-reveal>
        <a class="btn btn-primary" href="{{ route('begin') }}">{{ setting('about_cta_btn1', 'BEGIN YOUR STORY') }}
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
        </a>
        <a class="btn btn-outline-ghost" href="{{ route('library') }}">READ A STORYLOOM</a>
      </div>
    </div>
  </section>
@endsection
