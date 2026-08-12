@extends('layouts.app')

@section('content')
  @if($isPreview ?? false)
    <div style="position:sticky; top:0; z-index:500; background:#1D2A44; color:#EFE8D8; text-align:center; padding:10px 16px; font-size:.9rem;">
      <strong style="color:#D98A5A; letter-spacing:.12em; text-transform:uppercase; font-size:.74rem;">Preview</strong>
      &nbsp; This is how the article will look once published. Nothing has been saved.
    </div>
  @endif
  <article>
    <!-- ============ ARTICLE HERO ============ -->
    <section class="container article-hero">
      <p style="margin-bottom: 18px;">
        <a class="text-link" href="{{ route('blog.index') }}" style="font-size:.86rem;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true" style="transform:rotate(180deg)"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
          The Journal
        </a>
      </p>
      <h1>{!! $article->headline !!}</h1>
      @if($article->short_description)
        <p class="dek">{{ $article->short_description }}</p>
      @endif
      <p class="post-meta">
        <span class="cat">{{ strtoupper($article->category_label ?: ($article->category ?: ($article->keywords ?: 'GIFT GUIDES'))) }}</span>
        <span class="dot" aria-hidden="true"></span>
        <span class="read-time">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/></svg>
          {{ strtoupper(is_numeric($article->read_time) ? $article->read_time . ' MIN READ' : ($article->read_time ?: '6 MIN READ')) }}
        </span>
        <span class="dot" aria-hidden="true"></span>
        <span>{{ strtoupper($article->publish_date_tag ?: 'UPDATED THIS MONTH') }}</span>
      </p>
    </section>

    @if($article->featured_image)
      <section class="container">
        <figure class="article-figure plate" data-reveal>
          <img src="{{ asset($article->featured_image) }}" width="1600" height="900" alt="{{ $article->title }}" fetchpriority="high">
          <figcaption>the gift they remember is rarely the one that cost the most</figcaption>
        </figure>
      </section>
    @endif

    <!-- ============ BODY + STICKY CONVERSION SIDEBAR ============ -->
    <section class="section grain" style="padding-top: clamp(20px, 3vh, 36px);">
      <div class="container article-layout">
        <!-- Main Prose Article Body -->
        <div class="article-body">
          {!! $article->content !!}

          <!-- INLINE CONVERSION CARD -->
          @php
            $promo = $article->promo_card;
            $rawCta = preg_replace('/\.html$/i', '', trim($promo['cta_url'] ?? ''));
            if ($rawCta === '' || $rawCta === 'library' || $rawCta === '/library') {
                $rawCta = 'library?book=1';
            }
            $targetUrl = str_starts_with($rawCta, 'http') ? $rawCta : url($rawCta);
          @endphp
          {{-- Skipped when the writer placed a book card inside the article: the
               body already renders it where they put it, and appending another
               here is what made the card look like it had moved to the end. --}}
          @if(($article->show_promo ?? true) && !empty($promo['heading']) && ! $article->has_inline_promo)
            <aside class="inline-cta" data-reveal>
              <a class="ic-cover" href="{{ $targetUrl }}" style="display:block;" title="Read this book">
                <img src="{{ asset($promo['cover'] ?: 'assets/img/book1/cover.webp') }}" width="900" height="1273" loading="lazy" alt="{{ $promo['heading'] }}" style="cursor:pointer;">
              </a>
              <div>
                <h3>{{ $promo['heading'] }}</h3>
                <p>{{ $promo['body'] }}</p>
                <a class="btn btn-primary" href="{{ $targetUrl }}">{{ $promo['cta_text'] ?: 'Read a real book' }}
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
                </a>
              </div>
            </aside>
          @endif

          <!-- SHARE ROW -->
          <div class="share-row">
            <span class="share-label">Share this</span>
            <a class="share-btn" href="https://wa.me/?text={{ urlencode($article->title . ' ' . request()->fullUrl()) }}" target="_blank" rel="noopener" aria-label="Share on WhatsApp">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M12 3a9 9 0 0 0-7.8 13.5L3 21l4.7-1.2A9 9 0 1 0 12 3Z"/></svg>
            </a>
            <a class="share-btn" href="mailto:?subject={{ urlencode($article->title) }}&body={{ urlencode('Thought of you: ' . request()->fullUrl()) }}" aria-label="Share by email">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M4 6h16v12H4zM4 7l8 6 8-6"/></svg>
            </a>
            <button class="share-btn" onclick="navigator.clipboard.writeText(window.location.href); alert('Link copied to clipboard!');" type="button" aria-label="Copy link">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M10 14a4 4 0 0 0 5.7 0l3-3a4 4 0 1 0-5.7-5.7L11.5 6.8"/><path d="M14 10a4 4 0 0 0-5.7 0l-3 3a4 4 0 1 0 5.7 5.7l1.5-1.5"/></svg>
            </button>
          </div>

          <!-- AUTHOR NOTE BOX -->
          <div class="author-note">
            <img src="{{ asset('assets/img/logo-emblem.png') }}" alt="" width="54" height="53">
            <div>
              <p class="an-name">Written at the loom</p>
              <p>Notes from the Storyloom studio in India, where we spend our days turning other people's ordinary Tuesdays into books they keep forever.</p>
            </div>
          </div>
        </div>

        <!-- STICKY SIDEBAR -->
        <aside class="article-aside">
          @php $toc = ($article->show_toc ?? true) ? $article->table_of_contents : []; @endphp
          @if(count($toc))
            <nav class="toc" aria-label="{{ $article->toc_label ?: 'On this page' }}">
              <p class="toc-label">{{ $article->toc_label ?: 'On this page' }}</p>
              <ul>
                @foreach($toc as $item)
                  {{-- h3 entries are indented as sub-points: a listicle's ten
                       numbered items shouldn't read as ten top-level sections. --}}
                  <li @class(['toc-sub' => ($item['level'] ?? 'h2') === 'h3'])>
                    <a href="#{{ $item['id'] }}">{{ $item['text'] }}</a>
                  </li>
                @endforeach
              </ul>
            </nav>
          @endif

          @php $sidebar = $article->sidebar_card; @endphp
          @if(($sidebar['enabled'] ?? true))
            @php
              $sbUrl = preg_replace('/\.html$/i', '', trim($sidebar['cta_url'] ?? ''));
              if ($sbUrl === '' || $sbUrl === 'library' || $sbUrl === '/library') {
                  $sbUrl = 'library?book=2';
              }
              $sbTargetUrl = str_starts_with($sbUrl, 'http') ? $sbUrl : url($sbUrl);
            @endphp
            <div class="aside-card">
              <a href="{{ $sbTargetUrl }}" style="display:block;" title="Read this book">
                <img class="ac-cover" src="{{ asset($sidebar['cover'] ?: 'assets/img/book2/cover.webp') }}" width="900" height="1273" loading="lazy" alt="{{ $sidebar['heading'] ?? '' }}" style="cursor:pointer;">
              </a>
              <p class="ac-label">{{ $sidebar['label'] ?? 'Give the rare one' }}</p>
              <h4>{{ $sidebar['heading'] ?? 'Their story, illustrated by hand.' }}</h4>
              <p>{{ $sidebar['body'] ?? 'Written from your memories, painted around your people. Three to five weeks, start to doorstep.' }}</p>
              <a class="btn btn-primary" href="{{ $sbTargetUrl }}">{{ $sidebar['cta_text'] ?? 'Read a Storyloom' }}</a>
            </div>
          @endif
        </aside>
      </div>
    </section>
  </article>

  <!-- ============ RELATED ARTICLES ============ -->
  @if(isset($related) && count($related) > 0)
    <section class="section">
      <div class="container">
        <div class="section-head center" data-reveal>
          <p class="eyebrow eyebrow-center">Keep reading</p>
          <h2>More from the <em>Journal.</em></h2>
        </div>
        <div class="related-grid">
          @foreach($related as $rIndex => $rel)
            @php
              $rCatLabel = $rel->category_label;
              $rReadTime = $rel->read_time 
                ? (is_numeric($rel->read_time) ? $rel->read_time . ' min read' : $rel->read_time) 
                : '5 min read';
              $rExcerpt = $rel->dek ?: ($rel->short_description ?: Str::limit(strip_tags($rel->content), 100));
            @endphp
            <a class="post-card" href="{{ route('blog.show', $rel->slug) }}" data-reveal style="--stagger:{{ $rIndex % 3 }}">
              <span class="pc-media">
                <img src="{{ asset($rel->featured_image ?: 'assets/img/spread-home-morning.webp') }}" width="1100" height="1469" loading="lazy" alt="{{ $rel->title }}">
              </span>
              <span class="pc-body">
                <span class="post-meta">
                  <span class="cat">{{ $rCatLabel }}</span>
                  <span class="dot" aria-hidden="true"></span>
                  <span class="read-time">{{ $rReadTime }}</span>
                </span>
                <h3>{!! $rel->headline !!}</h3>
                @if($rExcerpt)
                  <span class="pc-excerpt">{{ $rExcerpt }}</span>
                @endif
                <span class="pc-more">Read
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
                </span>
              </span>
            </a>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  <!-- ============ FINAL CTA ============ -->
  <section class="final-cta">
    <div class="bg" style="background-image:url('{{ asset('assets/img/spread-home-evening.webp') }}')" role="img" aria-label="Illustration of a warm family home in the evening light"></div>
    <div class="container inner">
      <p class="eyebrow eyebrow-center" data-reveal style="color:#D98A5A">Make the rare one</p>
      <h2 data-reveal>You already know the five things. <em style="color:#E88B52;">We'll do the rest.</em></h2>
      <p data-reveal>Tell us one memory you never want forgotten. We'll reply within a day with a plan, a timeline and a quote — no payment, no commitment.</p>
      <div class="btn-row" style="justify-content:center;" data-reveal>
        <a class="btn btn-primary" href="{{ route('begin') }}">Begin Your Story
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
        </a>
        <a class="btn btn-ghost-light" href="{{ route('pricing') }}">See Pricing</a>
      </div>
    </div>
  </section>
@endsection
