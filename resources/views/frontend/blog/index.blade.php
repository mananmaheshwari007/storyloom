@extends('layouts.app')

@section('content')
  @php
    // The newest article is promoted to the "start here" slot, so the grid holds
    // everything after it — otherwise the same piece appeared twice on the page.
    $all      = collect($articles->items() ?? $articles);
    $featured = $all->first();
    $rest     = $all->slice(1)->values();

    // Only offer topics that actually have something published under them. A
    // pill that filters down to nothing is worse than no pill.
    $topics = $all
        ->groupBy(fn ($a) => strtolower($a->category ?: 'gifts'))
        ->map->count();
  @endphp

  <!-- ============ HERO ============ -->
  <section class="container journal-hero">
    <p class="eyebrow eyebrow-center" data-reveal>{{ setting('journal_hero_eyebrow', 'The Storyloom Journal') }}</p>
    <h1 data-reveal>{!! setting('journal_hero_heading', 'Notes on giving <em>better.</em>') !!}</h1>
    <p class="lede" data-reveal>{!! setting('journal_hero_lede', 'Gift ideas that aren\'t a scented candle, real stories from the families we\'ve made books for, and what actually happens at the loom. Short reads, mostly.') !!}</p>

    @if($topics->count() > 1)
      <div class="filter-row" role="group" aria-label="Filter articles by topic" data-reveal>
        <button class="filter-pill" data-filter="all" aria-pressed="true">Everything</button>
        @foreach($topics as $key => $count)
          <button class="filter-pill" data-filter="{{ $key }}" aria-pressed="false">
            {{ \App\Models\Blog::CATEGORIES[$key] ?? Str::title(str_replace(['-', '_'], ' ', $key)) }}
          </button>
        @endforeach
      </div>
    @endif
  </section>

  <!-- ============ FEATURED POST + ARTICLE GRID ============ -->
  <section class="section grain journal-body">
    <div class="container">
      @if($featured)
        <a class="featured-post" href="{{ route('blog.show', $featured->slug) }}"
           data-cat="{{ strtolower($featured->category ?: 'gifts') }}" data-reveal>
          <div class="fp-media">
            <span class="fp-badge">Start here</span>
            <img src="{{ asset($featured->featured_image ?: 'assets/img/spread-bench-dusk.webp') }}" width="1600" height="900" loading="eager" alt="{{ $featured->title }}">
          </div>
          <div class="fp-copy">
            <p class="post-meta">
              <span class="cat">{{ $featured->category_label }}</span>
              <span class="dot" aria-hidden="true"></span>
              <span class="read-time">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/></svg>
                {{ is_numeric($featured->read_time) ? $featured->read_time . ' min read' : ($featured->read_time ?: '6 min read') }}
              </span>
            </p>
            <h2>{!! $featured->headline !!}</h2>
            <p class="fp-excerpt">{{ $featured->dek ?: ($featured->short_description ?: Str::limit(strip_tags($featured->content), 140)) }}</p>
            <span class="text-link">Read the guide
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
            </span>
          </div>
        </a>
      @endif

      @if($rest->count())
        <p class="filter-count" id="filter-count" aria-live="polite"></p>
        <div class="post-grid" id="post-grid">
          @foreach($rest as $index => $article)
            <a class="post-card" href="{{ route('blog.show', $article->slug) }}"
               data-cat="{{ strtolower($article->category ?: 'gifts') }}"
               data-reveal style="--stagger:{{ $index % 3 }}">
              <span class="pc-media">
                <img src="{{ asset($article->featured_image ?: 'assets/img/spread-home-morning.webp') }}" width="1100" height="1469" loading="lazy" alt="{{ $article->title }}">
              </span>
              <span class="pc-body">
                <span class="post-meta">
                  <span class="cat">{{ $article->category_label }}</span>
                  <span class="dot" aria-hidden="true"></span>
                  <span class="read-time">{{ is_numeric($article->read_time) ? $article->read_time . ' min read' : ($article->read_time ?: '5 min read') }}</span>
                </span>
                <h3>{!! $article->headline !!}</h3>
                <span class="pc-excerpt">{{ $article->dek ?: ($article->short_description ?: Str::limit(strip_tags($article->content), 110)) }}</span>
                <span class="pc-more">Read
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
                </span>
              </span>
            </a>
          @endforeach
        </div>

        <p id="no-results" class="filter-count" hidden style="margin-top: 40px; font-size: 1rem;">
          Nothing here yet — try another topic.
        </p>
      @elseif(!$featured)
        <p class="filter-count" style="padding: 40px 0; font-size: 1.05rem;">
          The first entry is being written. Check back soon.
        </p>
      @endif

      @if($articles instanceof \Illuminate\Contracts\Pagination\Paginator && $articles->hasPages())
        <div class="journal-pagination">{{ $articles->links() }}</div>
      @endif
    </div>
  </section>

  <!-- ============ NEWSLETTER ============ -->
  <section class="section section-dark grain">
    <div class="container-narrow newsletter-band">
      <p class="eyebrow eyebrow-center" data-reveal>{{ setting('newsletter_eyebrow', 'The Loom Letter') }}</p>
      <h2 data-reveal>{!! setting('newsletter_heading', 'One good gift idea, <em>once a month.</em>') !!}</h2>
      <p data-reveal>{!! setting('newsletter_desc', 'No sale blasts. Just one thoughtful idea, one real family story, and a heads-up before the occasions that sneak up on everyone.') !!}</p>
      <form class="newsletter-form" action="{{ route('newsletter.subscribe') }}" method="POST" data-reveal>
        @csrf
        <label class="skip-link" for="news-email">Your email address</label>
        <input id="news-email" name="email" type="email" inputmode="email" autocomplete="email" placeholder="you@example.com" required>
        <button class="btn btn-primary" type="submit">{{ setting('newsletter_btn', 'Send it to me') }}
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
        </button>
      </form>
      @if(session('newsletter_success'))
        <p style="color: #68D391; font-size: 0.9rem; margin-top: 10px;">{{ session('newsletter_success') }}</p>
      @endif
      <p class="newsletter-note" data-reveal>{{ setting('newsletter_note', 'Unsubscribe in one click. We never share your email.') }}</p>
    </div>
  </section>

  <!-- ============ FINAL CTA ============ -->
  <section class="final-cta">
    <div class="bg" style="background-image:url('{{ asset(setting('journal_cta_bg_image', 'assets/img/spread-under-stars.webp')) }}')" role="img" aria-label="Illustration of a starry night sky over the city"></div>
    <div class="container inner">
      <h2 data-reveal>{!! setting('journal_cta_heading', 'Reading about it is nice. <em style="color:#E88B52;">Holding it</em> is better.') !!}</h2>
      <p data-reveal>{!! setting('journal_cta_desc', 'Every book in our library started with someone who wasn\'t sure where to begin. One memory is enough to start.') !!}</p>
      <div class="btn-row" style="justify-content:center;" data-reveal>
        <a class="btn btn-primary" href="{{ setting('journal_cta_btn1_link', route('begin')) }}">{{ setting('journal_cta_btn1_text', 'BEGIN YOUR STORY') }}
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
        </a>
        <a class="btn btn-ghost-light" href="{{ setting('journal_cta_btn2_link', route('library')) }}">{{ setting('journal_cta_btn2_text', 'Read a Storyloom') }}</a>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
  <script src="{{ asset('assets/js/journal.js') }}"></script>
@endpush
