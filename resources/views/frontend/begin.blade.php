@extends('layouts.app')

@section('content')
  <!-- Custom Styles for Begin Page -->
  <style>
    .begin-grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1.2fr); gap: clamp(40px, 6vw, 88px); align-items: start; }
    .channel-choice { display: flex; gap: 14px; flex-wrap: wrap; }
    .channel-choice label {
      display: inline-flex; align-items: center; gap: 10px;
      border: 1px solid var(--hairline-strong); border-radius: 999px;
      padding: 11px 20px; cursor: pointer;
      font-size: 0.95rem; color: var(--ink-soft);
      transition: border-color var(--dur-quick), background var(--dur-quick), color var(--dur-quick);
    }
    .channel-choice input { accent-color: var(--terra); width: 16px; height: 16px; }
    .channel-choice label:has(input:checked) {
      border-color: var(--terra); background: var(--terra-soft); color: var(--terra-deep);
    }
    .direct-card { position: sticky; top: 110px; }
    .direct-card ul { display: grid; gap: 18px; margin-top: 24px; }
    .direct-card li { display: flex; gap: 14px; align-items: flex-start; }
    .direct-card li svg { width: 20px; height: 20px; flex: none; margin-top: 4px; color: var(--terra); }
    .direct-card li a { color: var(--terra-deep); text-decoration: underline; text-underline-offset: 3px; }
    .direct-card li .lbl { display:block; font-size: 0.78rem; letter-spacing: 0.2em; text-transform: uppercase; color: var(--ink-faint); margin-bottom: 2px; }
    #begin-success {
      margin-top: 22px; padding: 18px 20px;
      background: rgba(63, 78, 58, 0.08); border: 1px solid rgba(63, 78, 58, 0.3);
      color: var(--grove); font-size: 0.95rem;
    }
    @media (max-width: 859px) { .begin-grid { grid-template-columns: 1fr; } .direct-card { position: static; } }
  </style>

  <section class="page-hero container">
    <p class="eyebrow eyebrow-center" data-reveal>{{ setting('begin_hero_eyebrow', 'Begin your story') }}</p>
    <h1 data-reveal>{!! setting('begin_hero_heading', 'Start with one <em>memory.</em>') !!}</h1>
    <p class="lede" data-reveal>{{ setting('begin_hero_lede', 'That\'s genuinely all it takes. Tell us who the book is for and one moment you never want forgotten. We\'ll reply within a day — with questions, a plan, and a timeline. No payment, no commitment, just the beginning.') }}</p>
  </section>

  <section class="section grain" style="padding-top: clamp(16px, 3vh, 40px);">
    <div class="container begin-grid">

      <div class="direct-card card" data-reveal="left">
        <p class="eyebrow">{{ setting('begin_box_eyebrow', 'Prefer to just talk?') }}</p>
        <h2 style="font-size:clamp(1.5rem,2.6vw,2rem); margin-bottom: 6px;">{{ setting('begin_box_heading', 'We\'re one message away.') }}</h2>
        <p style="color:var(--ink-soft); font-size:.95rem;">{{ setting('begin_box_subtext', 'Most Storylooms begin as a WhatsApp message that starts with “this might be a strange request…” It never is.') }}</p>
        <ul>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M12 3a9 9 0 0 0-7.8 13.5L3 21l4.7-1.2A9 9 0 1 0 12 3Z"/><path d="M9 9.5c.5 2.5 3 5 5.5 5.5l1-1.5 2 1c-.5 1.5-1.5 2-3 2-3.5-.5-6.5-3.5-7-7 0-1.5.5-2.5 2-3l1 2-1.5 1Z" fill="currentColor" stroke="none"/></svg>
            <span><span class="lbl">WhatsApp</span><a href="https://wa.me/{{ setting('contact_whatsapp', '919999999999') }}" target="_blank" rel="noopener">Message us directly</a></span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M4 6h16v12H4zM4 7l8 6 8-6"/></svg>
            <span><span class="lbl">Email</span><a href="mailto:{{ setting('contact_email', 'hello@storyloom.in') }}">{{ setting('contact_email', 'hello@storyloom.in') }}</a></span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="3.5" y="3.5" width="17" height="17" rx="4.5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r="1" fill="currentColor" stroke="none"/></svg>
            <span><span class="lbl">Instagram</span><a href="{{ setting('social_instagram', 'https://instagram.com/storyloom.in') }}" target="_blank" rel="noopener">@{{ setting('instagram_username', 'storyloom.in') }}</a></span>
          </li>
        </ul>
        <p class="hand-note" style="margin-top: 26px;">{{ setting('begin_box_note', 'voice notes welcome. rambling encouraged.') }}</p>
      </div>

      <form id="laravel-begin-form" class="form-grid" data-reveal="right" novalidate>
        @csrf
        <div class="form-row">
          <div class="field">
            <label for="f-name">Your name <span class="req" aria-hidden="true">*</span></label>
            <input id="f-name" name="name" type="text" autocomplete="name" required>
            <div class="error-msg text-danger small mt-1" id="err-name" style="display:none;"></div>
          </div>
          <div class="field">
            <label for="f-for">Who is the story for? <span class="req" aria-hidden="true">*</span></label>
            <input id="f-for" name="for" type="text" placeholder="e.g. my mother, my best friend" required>
            <div class="error-msg text-danger small mt-1" id="err-for" style="display:none;"></div>
          </div>
        </div>
        
        <div class="form-row">
          <div class="field">
            <label for="f-email">Your Email Address</label>
            <input id="f-email" name="email" type="email" autocomplete="email">
            <div class="error-msg text-danger small mt-1" id="err-email" style="display:none;"></div>
          </div>
          <div class="field">
            <label for="f-phone">Your Phone Number</label>
            <input id="f-phone" name="phone" type="text">
            <div class="error-msg text-danger small mt-1" id="err-phone" style="display:none;"></div>
          </div>
        </div>

        <div class="form-row">
          <div class="field">
            <label for="f-occasion">The occasion</label>
            <select id="f-occasion" name="occasion">
              <option value="">Choose one (or don't)</option>
              <option>Anniversary</option>
              <option>Birthday</option>
              <option>Wedding</option>
              <option>Diwali</option>
              <option>Raksha Bandhan</option>
              <option>Mother's Day</option>
              <option>Father's Day</option>
              <option>Farewell / Moving</option>
              <option>Just Because</option>
            </select>
          </div>
          <div class="field">
            <label for="f-timeline">Your timeline</label>
            <select id="f-timeline" name="timeline">
              <option value="">When do you need it?</option>
              <option>Within 4 weeks (Priority)</option>
              <option>Within 6-8 weeks</option>
              <option>No hurry, flexible</option>
            </select>
          </div>
        </div>

        <div class="field">
          <label for="f-story">Tell us one memory <span class="req" aria-hidden="true">*</span></label>
          <textarea id="f-story" name="story" rows="4" placeholder="Don't worry about writing well — bullet points, half-remembered details, or a single story are plenty." required></textarea>
          <div class="error-msg text-danger small mt-1" id="err-story" style="display:none;"></div>
        </div>

        <div class="field">
          <label>Where should we reply?</label>
          <div class="channel-choice">
            <label><input type="radio" name="channel" value="whatsapp" checked> WhatsApp</label>
            <label><input type="radio" name="channel" value="email"> Email</label>
          </div>
        </div>

        <div>
          <button class="btn btn-primary btn-lg" type="submit" id="btn-submit-story" style="width: 100%; justify-content: center;">
            <span id="btn-text">Send Memory &amp; Begin</span>
            <span id="btn-spinner" class="spinner-border spinner-border-sm ms-2" style="display:none;" role="status" aria-hidden="true"></span>
          </button>
        </div>

        <div id="begin-success" style="display:none;"></div>
      </form>

    </div>
  </section>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const form = document.getElementById('laravel-begin-form');
      if (!form) return;

      form.addEventListener('submit', function (e) {
        e.preventDefault();
        
        // Hide previous errors
        document.querySelectorAll('.error-msg').forEach(el => el.style.display = 'none');
        document.getElementById('begin-success').style.display = 'none';

        const btnSubmit = document.getElementById('btn-submit-story');
        const btnText = document.getElementById('btn-text');
        const btnSpinner = document.getElementById('btn-spinner');

        btnSubmit.disabled = true;
        btnText.textContent = 'Sending...';
        btnSpinner.style.display = 'inline-block';

        const formData = new FormData(form);

        fetch("{{ route('contact.submit') }}", {
          method: "POST",
          headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json"
          },
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          btnSubmit.disabled = false;
          btnText.textContent = 'Send Memory & Begin';
          btnSpinner.style.display = 'none';

          if (data.errors) {
            Object.keys(data.errors).forEach(key => {
              const errEl = document.getElementById('err-' + key);
              if (errEl) {
                errEl.textContent = data.errors[key][0];
                errEl.style.display = 'block';
              }
            });
          } else if (data.success) {
            const successEl = document.getElementById('begin-success');
            successEl.innerHTML = '<strong>' + data.message + '</strong><br>We have received your details and will get in touch shortly.';
            successEl.style.display = 'block';
            form.reset();
          }
        })
        .catch(error => {
          btnSubmit.disabled = false;
          btnText.textContent = 'Send Memory & Begin';
          btnSpinner.style.display = 'none';
          alert('An unexpected error occurred. Please try again.');
        });
      });
    });
  </script>
@endsection
