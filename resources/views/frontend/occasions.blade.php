@extends('layouts.app')

@section('content')

  <section class="page-hero container">
    <p class="eyebrow eyebrow-center" data-reveal>Occasions</p>
    <h1 data-reveal>For the days that deserve more than a <em>gift.</em></h1>
    <p class="lede" data-reveal>Some occasions come with easy answers — a cake, a card, a voucher. And some deserve the one gift that could only ever belong to one person. A Storyloom takes three to five weeks to craft, so the best time to begin is now.</p>
  </section>

  <!-- Festivals -->
  <section class="section grain" style="padding-top: clamp(24px, 4vh, 48px);">
    <div class="container">
      <div class="section-head" data-reveal>
        <p class="eyebrow">Festivals &amp; celebrations</p>
        <h2>Gifts for the days the whole family <em>gathers.</em></h2>
      </div>
      <div class="occasion-grid">
        <div class="card occasion-card visual" data-reveal style="--stagger:0">
          <div class="oc-img"><img src="{{ asset('assets/img/spread-home-evening.webp') }}" width="1400" height="788" loading="lazy" alt="A family home glowing in the evening light"></div>
          <span class="festival-tag">Festival</span>
          <div class="oc-body">
            <h3>Diwali</h3>
            <p>Your family's own festival — opened together, kept forever.</p>
          </div>
        </div>
        <div class="card occasion-card visual" data-reveal style="--stagger:1">
          <div class="oc-img"><img src="{{ asset('assets/img/book2-spread-phones.webp') }}" width="1400" height="601" loading="lazy" alt="A brother and sister talking on landline phones from their rooms"></div>
          <span class="festival-tag">Festival</span>
          <div class="oc-body">
            <h3>Raksha Bandhan</h3>
            <p>The rakhi fades by winter. The story of a brother and sister doesn't.</p>
          </div>
        </div>
        <div class="card occasion-card visual" data-reveal style="--stagger:2">
          <div class="oc-img"><img src="{{ asset('assets/img/spread-street-morning.webp') }}" width="1400" height="788" loading="lazy" alt="A busy Indian street on a bright morning"></div>
          <span class="festival-tag">Festival</span>
          <div class="oc-body">
            <h3>Mother's Day &amp; Father's Day</h3>
            <p>Everything never said across the dinner table — said page by page.</p>
          </div>
        </div>
        <div class="card occasion-card visual" data-reveal style="--stagger:3">
          <div class="oc-img"><img src="{{ asset('assets/img/spread-bench-sunset.webp') }}" width="1400" height="788" loading="lazy" alt="A couple on a bench at sunset above the city"></div>
          <span class="festival-tag">Festival</span>
          <div class="oc-body">
            <h3>Valentine's Day</h3>
            <p>How you actually fell in love — including the parts only you two know.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Milestones -->
  <section class="section">
    <div class="container">
      <div class="section-head center" data-reveal>
        <p class="eyebrow eyebrow-center">Milestones</p>
        <h2>Marking the years that changed <em>everything.</em></h2>
      </div>
      <div class="occasion-grid" style="grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));">
        <div class="card occasion-card" data-reveal style="--stagger:0">
          <h3>Anniversaries</h3>
          <p>Ten years, twenty-five years, or the first. The story of how two people built a life together, in a single bound volume.</p>
        </div>
        <div class="card occasion-card" data-reveal style="--stagger:1">
          <h3>Significant Birthdays</h3>
          <p>30th, 50th, 60th. Gather stories from friends and children and bind them into a single surprise book they'll cry over.</p>
        </div>
        <div class="card occasion-card" data-reveal style="--stagger:2">
          <h3>Weddings</h3>
          <p>Give the couple a keepsake of their beginning, or let the couple gift their parents a book thanking them for the foundations.</p>
        </div>
        <div class="card occasion-card" data-reveal style="--stagger:3">
          <h3>Retirements</h3>
          <p>Forty years of work, summarized not in a watch, but in the stories of the places they built and the people they mentored.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Relationships -->
  <section class="section section-tint grain" style="border-top: 1px solid var(--hairline);">
    <div class="container">
      <div class="section-head" data-reveal>
        <p class="eyebrow">The relationships</p>
        <h2>Because some bonds are built out of <em>shared memories.</em></h2>
      </div>
      <div class="occasion-grid" style="grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));">
        <div class="card occasion-card" data-reveal style="--stagger:0">
          <h3>For Parents</h3>
          <p>The house where you grew up, the routes they took you to school, and the sacrifices that only look like sacrifice now that you are older.</p>
        </div>
        <div class="card occasion-card" data-reveal style="--stagger:1">
          <h3>For Your Spouse</h3>
          <p>The first coffee shop, the travel mishap you still laugh about, the balcony where you talked about the future. Your real life, drawn.</p>
        </div>
        <div class="card occasion-card" data-reveal style="--stagger:2">
          <h3>For Best Friends</h3>
          <p>The shared landline calls, college road trips, and inside jokes that survived two careers, three cities, and a decade of distance.</p>
        </div>
        <div class="card occasion-card" data-reveal style="--stagger:3">
          <h3>For Kids</h3>
          <p>The questions they asked when they were three, the imaginary friend, the bedtime routine. Bound before they grow out of them.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="final-cta">
    <div class="bg" style="background-image:url('{{ asset('assets/img/spread-bench-dusk.webp') }}')" role="img"
         aria-label="Illustration of a couple on a bench at dusk"></div>
    <div class="container inner">
      <h2 data-reveal>The occasion will arrive. Will the <em>gift?</em></h2>
      <p data-reveal>A custom Storyloom book takes 3 to 5 weeks from the first memory conversation to print delivery. Begin tonight to ensure it is in their hands on the day.</p>
      <div class="btn-row" style="justify-content:center;" data-reveal>
        <a class="btn btn-primary" href="{{ route('begin') }}">Begin Your Story
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
        </a>
        <a class="btn btn-ghost-light" href="{{ route('library') }}">Read a Storyloom</a>
      </div>
    </div>
  </section>

@endsection
