<a href="{{ route('how-it-works') }}" class="{{ request()->routeIs('how-it-works') ? 'active' : '' }}">How It Works</a>
<a href="{{ route('library') }}" class="{{ request()->routeIs('library') ? 'active' : '' }}">Read a Storyloom</a>
<a href="{{ route('occasions') }}" class="{{ request()->routeIs('occasions') ? 'active' : '' }}">Occasions</a>
<a href="{{ route('blog.index') }}" class="{{ request()->routeIs('blog.*') ? 'active' : '' }}">Journal</a>
<a href="{{ route('pricing') }}" class="{{ request()->routeIs('pricing') ? 'active' : '' }}">Pricing</a>
<a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a>
<a href="{{ route('faq') }}" class="{{ request()->routeIs('faq') ? 'active' : '' }}">FAQ</a>
