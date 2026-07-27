<footer class="site-footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <img src="{{ asset(setting('site_logo_light', 'assets/img/logo-primary-light.png')) }}" alt="{{ setting('site_name', 'Storyloom') }}" width="120" height="118">
        <p>{{ setting('site_description', "Personalised, hand-illustrated keepsake storybooks. Your memories, woven into a book your family will treasure for generations. Crafted in India, delivered worldwide.") }}</p>
      </div>
      <div class="footer-col">
        <h4>Explore</h4>
        <ul>
          <li><a href="{{ route('how-it-works') }}">How It Works</a></li>
          <li><a href="{{ route('library') }}">Read a Storyloom</a></li>
          <li><a href="{{ route('occasions') }}">Occasions</a></li>
          <li><a href="{{ route('blog.index') }}">Journal</a></li>
          <li><a href="{{ route('pricing') }}">Pricing</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Storyloom</h4>
        <ul>
          <li><a href="{{ route('about') }}">Our Story</a></li>
          <li><a href="{{ route('faq') }}">FAQ</a></li>
          <li><a href="{{ route('faq') }}#shipping">Shipping &amp; Delivery</a></li>
          <li><a href="{{ route('begin') }}">Begin Your Story</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Newsletter</h4>
        <p style="font-size: 0.85rem; color: var(--cream-soft-on-dark); margin-bottom: 12px;">Subscribe for new stories &amp; updates.</p>
        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="newsletter-form" style="display: flex; gap: 8px;">
          @csrf
          <input type="email" name="email" placeholder="Your email address" required style="flex: 1; padding: 8px 12px; border: 1px solid var(--hairline-on-dark); background: rgba(255,255,255,0.05); color: #FFF; border-radius: 4px; font-size: 0.9rem;">
          <button type="submit" class="btn btn-primary" style="padding: 8px 16px; font-size: 0.9rem; min-height: unset; height: auto;">Subscribe</button>
        </form>
        @if(session('newsletter_success'))
          <p style="color: #68D391; font-size: 0.8rem; margin-top: 6px;">{{ session('newsletter_success') }}</p>
        @endif
        @if($errors->has('email'))
          <p style="color: #FC8181; font-size: 0.8rem; margin-top: 6px;">{{ $errors->first('email') }}</p>
        @endif

        <h4 style="margin-top: 24px;">Say hello</h4>
        <ul class="footer-contact">
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M4 6h16v12H4zM4 7l8 6 8-6"/></svg>
            <a href="mailto:{{ setting('contact_email', 'hello@storyloom.in') }}">{{ setting('contact_email', 'hello@storyloom.in') }}</a>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M12 3a9 9 0 0 0-7.8 13.5L3 21l4.7-1.2A9 9 0 1 0 12 3Z"/><path d="M9 9.5c.5 2.5 3 5 5.5 5.5l1-1.5 2 1c-.5 1.5-1.5 2-3 2-3.5-.5-6.5-3.5-7-7 0-1.5.5-2.5 2-3l1 2-1.5 1Z" fill="currentColor" stroke="none"/></svg>
            <a href="https://wa.me/{{ setting('contact_whatsapp', '919999999999') }}" rel="noopener">WhatsApp us</a>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="3.5" y="3.5" width="17" height="17" rx="4.5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r="1" fill="currentColor" stroke="none"/></svg>
            <a href="{{ setting('social_instagram', 'https://www.instagram.com/storyloombooks/') }}" rel="noopener" target="_blank">&#64;{{ setting('instagram_username', 'storyloombooks') }}</a>
          </li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© <span data-year>{{ date('Y') }}</span> {{ setting('copyright_text', 'Storyloom. Every story belongs to its family.') }}</span>
      <span class="legal-links">
        <a href="{{ route('faq') }}#shipping">Shipping</a>
        <a href="{{ route('faq') }}#refunds">Refunds</a>
        <a href="{{ route('faq') }}">Privacy</a>
      </span>
    </div>
  </div>
</footer>
