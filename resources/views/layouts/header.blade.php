<header class="site-header">
  <div class="container nav-bar">
    <a class="brand" href="{{ route('home') }}" aria-label="Storyloom home">
      <img class="emblem" src="{{ asset(setting('site_emblem', 'assets/img/logo-emblem.png')) }}" alt="" width="46" height="45">
      <img class="wordmark" src="{{ asset(setting('site_wordmark', 'assets/img/logo-wordmark.png')) }}" alt="{{ setting('site_name', 'Storyloom') }}" width="158" height="27">
    </a>
    <nav class="nav-links" aria-label="Primary">
      @include('layouts.navbar')
    </nav>
    <div class="nav-cta">
      <a class="btn btn-primary" href="{{ route('begin') }}">Begin Your Story</a>
    </div>
    <button class="nav-toggle" aria-expanded="false" aria-controls="mobile-menu" aria-label="Open menu">
      <span></span><span></span><span></span>
    </button>
  </div>
</header>

<div class="mobile-menu" id="mobile-menu">
  <nav aria-label="Mobile">
    <a class="menu-link {{ request()->routeIs('how-it-works') ? 'active' : '' }}" href="{{ route('how-it-works') }}"><span>How It Works</span><span class="no">01</span></a>
    <a class="menu-link {{ request()->routeIs('library') ? 'active' : '' }}" href="{{ route('library') }}"><span>Read a Storyloom</span><span class="no">02</span></a>
    <a class="menu-link {{ request()->routeIs('occasions') ? 'active' : '' }}" href="{{ route('occasions') }}"><span>Occasions</span><span class="no">03</span></a>
    <a class="menu-link {{ request()->routeIs('pricing') ? 'active' : '' }}" href="{{ route('pricing') }}"><span>Pricing</span><span class="no">04</span></a>
    <a class="menu-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}"><span>About</span><span class="no">05</span></a>
    <a class="menu-link {{ request()->routeIs('faq') ? 'active' : '' }}" href="{{ route('faq') }}"><span>FAQ</span><span class="no">06</span></a>
  </nav>
  <div class="menu-cta">
    <a class="btn btn-primary" href="{{ route('begin') }}">Begin Your Story</a>
  </div>
</div>
