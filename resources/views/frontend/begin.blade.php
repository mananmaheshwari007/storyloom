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
    .begin-aside { position: sticky; top: 110px; }
    .begin-privacy {
      display: flex; gap: 10px; align-items: flex-start;
      margin: 18px 2px 0; font-size: 0.82rem; line-height: 1.6;
      color: var(--ink-faint);
    }
    .begin-privacy svg { width: 17px; height: 17px; flex: none; margin-top: 2px; color: var(--grove); }
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
    @media (max-width: 859px) { .begin-grid { grid-template-columns: 1fr; } .begin-aside { position: static; } }
  </style>

  @if(\App\Support\Sections::enabled('begin_hero'))
  <section class="page-hero container">
    <p class="eyebrow eyebrow-center" data-reveal>{{ setting('begin_hero_eyebrow', 'Begin your story') }}</p>
    <h1 data-reveal>{!! setting('begin_hero_heading', 'Start with one <em>memory.</em>') !!}</h1>
    <p class="lede" data-reveal>{{ setting('begin_hero_lede', 'That\'s genuinely all it takes. Tell us who the book is for and one moment you never want forgotten. We\'ll reply within a day — with questions, a plan, and a timeline. No payment, no commitment, just the beginning.') }}</p>
  </section>
  @endif

  @if(\App\Support\Sections::enabled('begin_form'))
  <section class="section grain" style="padding-top: clamp(16px, 3vh, 40px);">
    <div class="container begin-grid">

      {{-- Card and privacy note share the grid's left cell, so the note sits
           directly under the card rather than being placed on a second grid row
           below the (much taller) form. --}}
      <div class="begin-aside">
      <div class="direct-card card" data-reveal="left">
        <p class="eyebrow">{{ setting('begin_box_eyebrow', 'Prefer to just talk?') }}</p>
        <h2 style="font-size:clamp(1.5rem,2.6vw,2rem); margin-bottom: 6px;">{{ setting('begin_box_heading', 'We\'re one message away.') }}</h2>
        <p style="color:var(--ink-soft); font-size:.95rem;">{{ setting('begin_box_subtext', 'Most Storylooms begin as a WhatsApp message that starts with “this might be a strange request…” It never is.') }}</p>
        <ul>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M12 3a9 9 0 0 0-7.8 13.5L3 21l4.7-1.2A9 9 0 1 0 12 3Z"/><path d="M9 9.5c.5 2.5 3 5 5.5 5.5l1-1.5 2 1c-.5 1.5-1.5 2-3 2-3.5-.5-6.5-3.5-7-7 0-1.5.5-2.5 2-3l1 2-1.5 1Z" fill="currentColor" stroke="none"/></svg>
            <span><span class="lbl">{{ setting('begin_channel_whatsapp', 'WhatsApp') }}</span><a href="{{ route('whatsapp') }}" target="_blank" rel="noopener">{{ setting('begin_box_wa_text', 'Message us directly') }}</a></span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M4 6h16v12H4zM4 7l8 6 8-6"/></svg>
            <span><span class="lbl">Email</span><a href="mailto:{{ setting('contact_email', 'hello@storyloom.in') }}">{{ setting('contact_email', 'hello@storyloom.in') }}</a></span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="3.5" y="3.5" width="17" height="17" rx="4.5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r="1" fill="currentColor" stroke="none"/></svg>
            <span><span class="lbl">Instagram</span><a href="{{ setting('social_instagram', 'https://www.instagram.com/storyloombooks/') }}" target="_blank" rel="noopener">&#64;{{ setting('instagram_username', 'storyloombooks') }}</a></span>
          </li>
        </ul>
        <p class="hand-note" style="margin-top: 26px;">{{ setting('begin_box_note', 'voice notes welcome. rambling encouraged.') }}</p>
      </div>

      @php $beginPrivacy = trim(setting('begin_privacy_note', 'Your memories stay between us. We never sell, share or publish anything you send — not your story, not your photographs, not your contact details. Nothing appears on this site without your written permission.')); @endphp
      @if($beginPrivacy !== '')
        <p class="begin-privacy" data-reveal="left">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
            <path d="M12 3l7 3v6c0 4.2-2.9 7.6-7 9-4.1-1.4-7-4.8-7-9V6l7-3Z"/><path d="M9 12.5l2 2 4-4.5"/>
          </svg>
          <span>{!! $beginPrivacy !!}</span>
        </p>
      @endif
      </div>

      <form id="laravel-begin-form" class="form-grid" data-reveal="right" novalidate>
        @csrf
        <div class="form-row">
          <div class="field">
            <label for="f-name">{{ setting('begin_label_name', 'Your name') }} <span class="req" aria-hidden="true">*</span></label>
            <input id="f-name" name="name" type="text" autocomplete="name" required>
            <div class="error-msg text-danger small mt-1" id="err-name" style="display:none;"></div>
          </div>
          <div class="field">
            <label for="f-for">{{ setting('begin_label_for', 'Who is the story for?') }} <span class="req" aria-hidden="true">*</span></label>
            <input id="f-for" name="for" type="text" placeholder="{{ setting('begin_ph_for', 'e.g. my mother, my best friend') }}" required>
            <div class="error-msg text-danger small mt-1" id="err-for" style="display:none;"></div>
          </div>
        </div>

        {{-- Whichever reply channel is chosen below decides which of these two
             is required. The asterisks are driven by JS; the server enforces it
             for real with required_if. --}}
        <div class="form-row">
          <div class="field">
            <label for="f-email">{{ setting('begin_label_email', 'Your Email Address') }} <span class="req" id="req-email" aria-hidden="true" hidden>*</span></label>
            <input id="f-email" name="email" type="email" autocomplete="email">
            <div class="error-msg text-danger small mt-1" id="err-email" style="display:none;"></div>
          </div>
          <div class="field">
            <label for="f-phone">{{ setting('begin_label_phone', 'Your Phone Number') }} <span class="req" id="req-phone" aria-hidden="true" hidden>*</span></label>
            <input id="f-phone" name="phone" type="tel" autocomplete="tel">
            <div class="error-msg text-danger small mt-1" id="err-phone" style="display:none;"></div>
          </div>
        </div>

        {{-- No "your timeline" question: every book runs to the same fixed
             schedule, so asking the customer to pick a speed only invited an
             expectation we wouldn't be setting. --}}
        @php
          $occasionList = array_filter(array_map('trim', explode(',', setting(
              'begin_occasions',
              "Anniversary, Birthday, Wedding, Diwali, Raksha Bandhan, Mother's Day, Father's Day, Farewell / Moving, Just Because"
          ))));
        @endphp
        <div class="field">
          <label for="f-occasion">{{ setting('begin_label_occasion', 'The occasion') }}</label>
          <select id="f-occasion" name="occasion">
            <option value="">{{ setting('begin_ph_occasion', "Choose one (or don't)") }}</option>
            @foreach($occasionList as $occasionOption)
              <option>{{ $occasionOption }}</option>
            @endforeach
          </select>
        </div>

        <div class="field">
          <label for="f-story">{{ setting('begin_label_story', 'Tell us one memory') }} <span class="req" aria-hidden="true">*</span></label>
          <textarea id="f-story" name="story" rows="4" placeholder="{{ setting('begin_ph_story', "Don't worry about writing well — bullet points, half-remembered details, or a single story are plenty.") }}" required></textarea>
          <div class="error-msg text-danger small mt-1" id="err-story" style="display:none;"></div>
        </div>

        <div class="field">
          <label>{{ setting('begin_label_channel', 'Where should we reply?') }}</label>
          <div class="channel-choice">
            <label><input type="radio" name="channel" value="whatsapp" checked> {{ setting('begin_channel_whatsapp', 'WhatsApp') }}</label>
            <label><input type="radio" name="channel" value="email"> {{ setting('begin_channel_email', 'Email') }}</label>
          </div>
          <div class="error-msg text-danger small mt-1" id="err-channel" style="display:none;"></div>
        </div>

        <div>
          <button class="btn btn-primary btn-lg" type="submit" id="btn-submit-story" style="width: 100%; justify-content: center;">
            <span id="btn-text">{{ setting('begin_btn_text', 'Send Memory & Begin') }}</span>
            <span id="btn-spinner" class="spinner-border spinner-border-sm ms-2" style="display:none;" role="status" aria-hidden="true"></span>
          </button>
        </div>

        <div id="begin-success" style="display:none;"></div>
      </form>

    </div>
  </section>
  @endif

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const form = document.getElementById('laravel-begin-form');
      if (!form) return;

      /* Whichever channel they pick is the one we need a way to reach them on,
         so that field becomes required and the other stays optional. The
         server enforces the same rule — this only saves a round trip. */
      const emailField = document.getElementById('f-email');
      const phoneField = document.getElementById('f-phone');
      const emailStar  = document.getElementById('req-email');
      const phoneStar  = document.getElementById('req-phone');

      function applyChannel() {
        const channel = form.querySelector('input[name="channel"]:checked')?.value || 'whatsapp';
        const wantsEmail = channel === 'email';

        emailField.required = wantsEmail;
        phoneField.required = !wantsEmail;
        emailStar.hidden = !wantsEmail;
        phoneStar.hidden = wantsEmail;

        // Clear a stale "this is required" from the channel they just left.
        document.getElementById(wantsEmail ? 'err-phone' : 'err-email').style.display = 'none';
      }

      form.querySelectorAll('input[name="channel"]').forEach(function (radio) {
        radio.addEventListener('change', applyChannel);
      });
      applyChannel();

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
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content || "{{ csrf_token() }}",
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
            successEl.innerHTML = '<strong>' + data.message + '</strong><br>{{ addslashes(setting('begin_success_note', 'We have received your details and will get in touch shortly.')) }}';
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
