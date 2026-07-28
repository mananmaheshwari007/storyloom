@extends('layouts.app')

@section('content')
  <!-- ============ HERO SECTION ============ -->
  <section class="container library-hero">
    <div class="page-hero" data-reveal>
      <p class="eyebrow eyebrow-center">{{ setting('library_hero_eyebrow', 'THE STORYLOOM LIBRARY') }}</p>
      <h1>{!! setting('library_hero_heading', 'Read one. Then imagine <em>yours.</em>') !!}</h1>
      <p class="lede">{{ setting('library_hero_lede', 'Real books, made for real families, shared with their blessing. Take your time — this room is quiet.') }}</p>

      <div class="hero-library-badges" data-reveal>
        <span class="hl-badge">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
          Full Spreads Available
        </span>
        <span class="hl-dot" aria-hidden="true"></span>
        <span class="hl-badge">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          Tap Any Book To Open
        </span>
        <span class="hl-dot" aria-hidden="true"></span>
        <span class="hl-badge">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
          Shared With Permission
        </span>
      </div>
    </div>
  </section>

  <!-- ============ FEATURED BOOKS LOOP ============ -->
  @if(isset($featuredBooks) && count($featuredBooks) > 0)
    @foreach($featuredBooks as $index => $book)
      @php
        $rawPages = is_array($book->pages_json) ? $book->pages_json : (is_string($book->pages_json) ? json_decode($book->pages_json, true) : []);
        $formattedPages = array_map(function($p) {
            if (is_array($p) && isset($p['src'])) {
                $src = $p['src'];
                if (!str_starts_with($src, 'http://') && !str_starts_with($src, 'https://') && !str_starts_with($src, '/')) {
                    $p['src'] = asset($src);
                }
            }
            return $p;
        }, $rawPages);
        $pagesJson = json_encode($formattedPages, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $coverUrl = $book->cover_image ? asset($book->cover_image) : asset('assets/img/logo-emblem-light.png');
        $backUrl = $book->back_image ? asset($book->back_image) : $coverUrl;
      @endphp
      <section class="section @if($index % 2 === 0) section-tint grain @endif" id="book-{{ $book->id }}">
        <div class="container book-feature @if($index % 2 !== 0) flip @endif">
          <figure class="plate hoverable" data-reveal="@if($index % 2 === 0) left @else right @endif" data-open-book="#open-book-{{ $book->id }}" style="max-width: 400px; justify-self: center; width: 100%; cursor: pointer;" title="Click to read {{ $book->title }}">
            <img src="{{ $coverUrl }}" width="900" height="1273" loading="lazy" alt="Front cover of {{ $book->title }}">
            <figcaption class="caption">{{ $book->caption ?: 'the actual cover — printed, bound, gifted (tap to read)' }}</figcaption>
          </figure>
          <div class="book-meta" data-reveal="@if($index % 2 === 0) right @else left @endif">
            <p class="eyebrow">Featured Storyloom</p>
            <h2>{!! preg_replace('/(\w+)$/', '<em>$1</em>', e($book->title)) !!}</h2>
            <div class="book-tags">
              @if($book->relation_tag)<span class="book-tag">{{ $book->relation_tag }}</span>@endif
              @if($book->occasion_tag)<span class="book-tag">{{ $book->occasion_tag }}</span>@endif
              @if($book->spreads_count)<span class="book-tag">{{ $book->spreads_count }}</span>@endif
              @if($book->read_time)<span class="book-tag">{{ $book->read_time }}</span>@endif
            </div>
            <p class="synopsis">{{ $book->synopsis }}</p>
            <div class="btn-row">
              <button class="btn btn-primary" id="open-book-{{ $book->id }}"
                data-book-title="{{ $book->title }}"
                data-book-sub="{{ $book->subtitle }}"
                data-book-cover="{{ $coverUrl }}"
                data-book-back="{{ $backUrl }}"
                data-book-pages='{{ $pagesJson }}'>
                Read this book
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
              </button>
              <a class="btn btn-ghost" href="{{ route('begin') }}">Begin one like it</a>
            </div>
          </div>
        </div>
      </section>
    @endforeach
  @endif

  <!-- ============ THE SHELF ============ -->
  <section class="section section-tint grain" id="shelf">
    <div class="container">
      <div class="section-head center" data-reveal>
        <p class="eyebrow eyebrow-center">{{ setting('shelf_eyebrow', 'ON THE SHELF') }}</p>
        <h2>{!! setting('shelf_heading', 'Stories currently on the <em>loom.</em>') !!}</h2>
      </div>
      <div class="shelf">
        @if(isset($shelfBooks) && count($shelfBooks) > 0)
          @foreach($shelfBooks as $sIndex => $sBook)
            @php
              $sCover = $sBook->cover_image ? asset($sBook->cover_image) : asset('assets/img/spread-under-stars.webp');
              $sPages = is_array($sBook->pages_json) ? $sBook->pages_json : (is_string($sBook->pages_json) ? json_decode($sBook->pages_json, true) : []);
              $sFormattedPages = array_map(function($p) {
                  if (is_array($p) && isset($p['src'])) {
                      $src = $p['src'];
                      if (!str_starts_with($src, 'http://') && !str_starts_with($src, 'https://') && !str_starts_with($src, '/')) {
                          $p['src'] = asset($src);
                      }
                  }
                  return $p;
              }, $sPages);
              $sPagesJson = json_encode($sFormattedPages, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            @endphp
            <div class="shelf-card" data-reveal
                 @if(count($sFormattedPages) > 0)
                   data-book-pages='{{ $sPagesJson }}'
                   data-book-title="{{ $sBook->title }}"
                   data-book-sub="{{ $sBook->subtitle }}"
                   data-book-cover="{{ $sCover }}"
                   data-book-back="{{ $sBook->back_image ? asset($sBook->back_image) : $sCover }}"
                 @elseif(isset($featuredBooks[0]))
                   data-open-book="#open-book-{{ $featuredBooks[0]->id }}"
                 @endif
                 style="--stagger:{{ $sIndex % 4 }}; cursor:pointer;" tabindex="0" title="Click to read {{ $sBook->title }}">
              <span class="sc-bg" style="background-image:url('{{ $sCover }}')" role="img" aria-label="{{ $sBook->title }}"></span>
              <div class="content">
                <span class="sc-title">{{ $sBook->title }}</span>
                <span class="sc-copy">{{ $sBook->synopsis }}</span>
                <span class="sc-tag">{{ $sBook->relation_tag ?: $sBook->subtitle }}</span>
              </div>
            </div>
          @endforeach
        @endif
      </div>
      <p style="text-align:center; margin-top: 44px;" class="hand-note" data-reveal>
        {{ setting('shelf_handnote', '…the next one could be about your family.') }}
      </p>
    </div>
  </section>

  <!-- ============ FINAL CTA ============ -->
  <section class="final-cta">
    <div class="bg" style="background-image:url('{{ asset(setting('library_cta_bg', 'assets/img/spread-bench-dusk.webp')) }}')" role="img"
         aria-label="Illustration of a couple on a bench at dusk, city lights below"></div>
    <div class="container inner">
      <h2 data-reveal>{!! setting('library_cta_heading', 'Imagine your story <em style="color:#E88B52;">here.</em>') !!}</h2>
      <p data-reveal>{{ setting('library_cta_desc', 'Every book in this library began with someone saying “I don\'t know where to start.” Start there. We\'ll take it from that sentence.') }}</p>
      <div class="btn-row" style="justify-content:center;" data-reveal>
        <a class="btn btn-primary" href="{{ route('begin') }}">{{ setting('library_cta_btn', 'BEGIN YOUR STORY') }}
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
        </a>
      </div>
    </div>
  </section>
@endsection

