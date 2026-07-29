@extends('layouts.app')

@section('content')
  <!-- ================= HERO ================= -->
  <section class="section grain" style="background: #f7f4ed; padding-top: clamp(70px, 8vh, 100px); padding-bottom: clamp(45px, 5vh, 65px);">
    <div class="container-narrow">
      <div class="section-head center" style="margin-bottom: 0;">
        <div class="hero-eyebrow-center" data-reveal>{{ setting('library_hero_eyebrow', 'THE STORYLOOM LIBRARY') }}</div>
        <h1 data-reveal style="font-family: var(--font-display); font-size: clamp(2.6rem, 5vw, 4.4rem); font-weight: 600; line-height: 1.15; margin-bottom: 24px; color: #1C222B;">
          {!! setting('library_hero_heading', 'Read one. Then<br>imagine <em style="font-family: \'Cormorant Garamond\', Cormorant, Georgia, serif; font-style: italic; font-weight: 500; color: rgb(181, 91, 41);">yours.</em>') !!}
        </h1>
        <p class="lede" data-reveal style="font-family: 'Libre Caslon Text', 'Adobe Caslon Pro', Georgia, serif; font-style: normal; font-weight: 400; font-size: 18px; line-height: 32px; color: rgba(29, 42, 68, 0.74); max-width: 780px; width: 100%; margin-inline: auto;">
          {{ setting('library_hero_lede', 'Real books, made for real families, shared with their blessing. Take your time — this room is quiet.') }}
        </p>
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
            <h2>{!! str_contains($book->title, '<') ? $book->title : preg_replace('/(\w+)$/', '<em>$1</em>', e($book->title)) !!}</h2>
            <div class="book-tags">
              @if($book->relation_tag)<span class="book-tag">{{ $book->relation_tag }}</span>@endif
              @if($book->occasion_tag)<span class="book-tag">{{ $book->occasion_tag }}</span>@endif
              @if($book->spreads_count)<span class="book-tag">{{ $book->spreads_count }}</span>@endif
              @if($book->read_time)<span class="book-tag">{{ $book->read_time }}</span>@endif
            </div>
            <p class="synopsis">{{ $book->synopsis }}</p>
            <div class="btn-row">
              <button class="btn btn-primary" id="open-book-{{ $book->id }}"
                data-book-title="{{ strip_tags($book->title) }}"
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
            <div class="shelf-card" data-reveal style="--stagger:{{ $sIndex % 4 }}; cursor: default;">
              <span class="sc-bg" style="background-image:url('{{ $sCover }}')" role="img" aria-label="{{ strip_tags($sBook->title) }}"></span>
              <div class="content">
                <span class="sc-title">{!! $sBook->title !!}</span>
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

