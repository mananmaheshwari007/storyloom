@extends('layouts.app')

@section('content')
  <!-- ============ HERO & DISPLAY STACK ============ -->
  <section class="container library-hero">
    <div class="page-hero" data-reveal="left">
      <p class="eyebrow eyebrow-center">{{ setting('library_hero_eyebrow', 'THE STORYLOOM LIBRARY') }}</p>
      <h1>{!! setting('library_hero_heading', 'Read one. Then<br>imagine <em>yours.</em>') !!}</h1>
      <p class="lede">{{ setting('library_hero_lede', 'Real books, made for real families, shared with their blessing. Take your time — this room is quiet.') }}</p>
    </div>
    <div class="display-stack-wrap" data-reveal="right">
      <div class="display-stack">
        <a class="display-card" href="#shelf">
          <span class="dc-cover placeholder"><img src="{{ asset('assets/img/logo-emblem-light.png') }}" alt=""></span>
          <span class="dc-body">
            <span class="dc-title">The Moon Protector</span>
            <span class="dc-desc">For a daughter — on the loom</span>
            <span class="dc-meta">New stories join every month</span>
          </span>
        </a>
        @if(isset($featuredBooks) && count($featuredBooks) > 1)
          @php $b2 = $featuredBooks[1]; @endphp
          <button class="display-card" data-open-book="#open-book-{{ $b2->id }}" type="button">
            <span class="dc-cover"><img src="{{ asset($b2->cover_image) }}" alt="Front cover of {{ $b2->title }}"></span>
            <span class="dc-body">
              <span class="dc-title">{{ $b2->title }}</span>
              <span class="dc-desc">{{ $b2->subtitle ?: $b2->relation_tag }}</span>
              <span class="dc-meta">{{ $b2->spreads_count ?: '17 spreads' }} · {{ $b2->read_time ?: '9 min read' }} · tap to open</span>
            </span>
          </button>
        @endif
        @if(isset($featuredBooks) && count($featuredBooks) > 0)
          @php $b1 = $featuredBooks[0]; @endphp
          <button class="display-card" data-open-book="#open-book-{{ $b1->id }}" type="button">
            <span class="dc-cover"><img src="{{ asset($b1->cover_image) }}" alt="Front cover of {{ $b1->title }}"></span>
            <span class="dc-body">
              <span class="dc-title">{{ $b1->title }}</span>
              <span class="dc-desc">{{ $b1->subtitle ?: $b1->relation_tag }}</span>
              <span class="dc-meta">{{ $b1->spreads_count ?: '15 spreads' }} · {{ $b1->read_time ?: '8 min read' }} · tap to open</span>
            </span>
          </button>
        @endif
      </div>
    </div>
  </section>

  <!-- ============ FEATURED BOOKS LOOP ============ -->
  @if(isset($featuredBooks) && count($featuredBooks) > 0)
    @foreach($featuredBooks as $index => $book)
      @php
        $pagesJson = is_array($book->pages_json) ? json_encode($book->pages_json) : '[]';
      @endphp
      <section class="section @if($index % 2 === 0) section-tint grain @endif" id="book-{{ $book->id }}">
        <div class="container book-feature @if($index % 2 !== 0) flip @endif">
          <figure class="plate hoverable" data-reveal="@if($index % 2 === 0) left @else right @endif" data-open-book="#open-book-{{ $book->id }}" style="max-width: 400px; justify-self: center; width: 100%; cursor: pointer;" title="Click to read {{ $book->title }}">
            <img src="{{ asset($book->cover_image) }}" width="900" height="1273" loading="lazy" alt="Front cover of {{ $book->title }}">
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
                data-book-cover="{{ asset($book->cover_image) }}"
                data-book-back="{{ asset($book->back_image ?: $book->cover_image) }}"
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
            <div class="shelf-card" data-reveal @if(isset($featuredBooks[0])) data-open-book="#open-book-{{ $featuredBooks[0]->id }}" @endif style="--stagger:{{ $sIndex % 4 }}; cursor:pointer;" tabindex="0" title="Click to read book">
              <span class="sc-bg" style="background-image:url('{{ asset($sBook->cover_image) }}')" role="img" aria-label="{{ $sBook->title }}"></span>
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
