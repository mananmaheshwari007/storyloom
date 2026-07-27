<div class="admin-sidebar d-flex flex-column">
  <div class="sidebar-header d-flex align-items-center">
    <img src="{{ asset('assets/img/logo-emblem.png') }}" alt="Storyloom Logo" width="30" height="29" class="me-2">
    <span class="fs-5 fw-bold text-white">Storyloom CMS</span>
  </div>
  
  <div class="flex-grow-1 overflow-auto py-3">
    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <i class="bi bi-speedometer2"></i>Dashboard
    </a>
    
    <div class="px-3 pt-3 pb-2 text-uppercase fs-7 text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.1em;">Settings & Core</div>
    
    <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
      <i class="bi bi-gear"></i>Site Settings
    </a>
    
    <a href="{{ route('admin.hero') }}" class="{{ request()->routeIs('admin.hero*') ? 'active' : '' }}">
      <i class="bi bi-window-sidebar"></i>Hero Section
    </a>
    
    <a href="{{ route('admin.about') }}" class="{{ request()->routeIs('admin.about*') ? 'active' : '' }}">
      <i class="bi bi-file-person"></i>About Section
    </a>
    
    <div class="px-3 pt-3 pb-2 text-uppercase fs-7 text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.1em;">Content Modules</div>
    
    <a href="{{ route('admin.services.index') }}" class="{{ request()->routeIs('admin.services*') ? 'active' : '' }}">
      <i class="bi bi-briefcase"></i>Services
    </a>
    
    <a href="{{ route('admin.projects.index') }}" class="{{ request()->routeIs('admin.projects*') ? 'active' : '' }}">
      <i class="bi bi-journal-bookmark"></i>Projects (Featured)
    </a>
    
    <a href="{{ route('admin.portfolio.index') }}" class="{{ request()->routeIs('admin.portfolio*') ? 'active' : '' }}">
      <i class="bi bi-book"></i>Portfolio (Shelf)
    </a>
    
    <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products*') ? 'active' : '' }}">
      <i class="bi bi-cart3"></i>Products (Editions)
    </a>
    
    <a href="{{ route('admin.pricing.index') }}" class="{{ request()->routeIs('admin.pricing*') ? 'active' : '' }}">
      <i class="bi bi-tags"></i>Pricing Plans
    </a>
    
    <a href="{{ route('admin.faqs.index') }}" class="{{ request()->routeIs('admin.faqs*') ? 'active' : '' }}">
      <i class="bi bi-question-circle"></i>FAQs
    </a>
    
    <a href="{{ route('admin.testimonials.index') }}" class="{{ request()->routeIs('admin.testimonials*') ? 'active' : '' }}">
      <i class="bi bi-chat-quote"></i>Testimonials
    </a>
    
    <a href="{{ route('admin.team.index') }}" class="{{ request()->routeIs('admin.team*') ? 'active' : '' }}">
      <i class="bi bi-people"></i>Team Members
    </a>
    
    <a href="{{ route('admin.blog.index') }}" class="{{ request()->routeIs('admin.blog*') ? 'active' : '' }}">
      <i class="bi bi-newspaper"></i>Blog Posts
    </a>
    
    <div class="px-3 pt-3 pb-2 text-uppercase fs-7 text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.1em;">Leads & Media</div>
    
    <a href="{{ route('admin.messages.index') }}" class="{{ request()->routeIs('admin.messages*') ? 'active' : '' }}">
      <i class="bi bi-envelope"></i>Inquiries 
      @php
        $unreadCount = 0;
        try {
            if (class_exists(\App\Models\ContactMessage::class)) {
                $unreadCount = \App\Models\ContactMessage::where('is_read', false)->count();
            }
        } catch (\Exception $e) {}
      @endphp
      @if($unreadCount > 0)
        <span class="badge bg-danger float-end rounded-pill mt-1" style="font-size: 0.7rem;">{{ $unreadCount }}</span>
      @endif
    </a>
    
    <a href="{{ route('admin.subscribers.index') }}" class="{{ request()->routeIs('admin.subscribers*') ? 'active' : '' }}">
      <i class="bi bi-envelope-check"></i>Newsletter Subs
    </a>
    
    <a href="{{ route('admin.media') }}" class="{{ request()->routeIs('admin.media*') ? 'active' : '' }}">
      <i class="bi bi-images"></i>Media Manager
    </a>
  </div>
  
  <div class="p-3 bg-dark text-secondary text-center" style="font-size: 0.8rem; border-top: 1px solid rgba(255,255,255,0.05);">
    v12.0 · PHP 8.3
  </div>
</div>
