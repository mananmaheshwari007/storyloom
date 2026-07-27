@extends('layouts.app')

@section('content')

  <section class="page-hero container">
    <p class="eyebrow eyebrow-center" data-reveal>Begin your story</p>
    <h1 data-reveal>Start with one <em>memory.</em></h1>
    <p class="lede" data-reveal>That's genuinely all it takes. Tell us who the book is for and one moment you never want forgotten. We'll reply within a day — with questions, a plan, and a timeline. No payment, no commitment, just the beginning.</p>
  </section>

  <section class="section grain" style="padding-top: clamp(16px, 3vh, 40px);">
    <div class="container begin-grid">

      <div class="direct-card card" data-reveal="left">
        <p class="eyebrow">Prefer to just talk?</p>
        <h2 style="font-size:clamp(1.5rem,2.6vw,2rem); margin-bottom: 6px;">We're one message away.</h2>
        <p style="color:var(--ink-soft); font-size:.95rem;">Most Storylooms begin as a WhatsApp message that starts with “this might be a strange request…” It never is.</p>
        <ul style="list-style:none; padding:0;">
          <li style="display:flex; gap:14px; align-items:flex-start; margin-bottom:18px;">
            <svg style="width:20px; height:20px; flex:none; margin-top:4px; color:var(--terra);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M12 3a9 9 0 0 0-7.8 13.5L3 21l4.7-1.2A9 9 0 1 0 12 3Z"/><path d="M9 9.5c.5 2.5 3 5 5.5 5.5l1-1.5 2 1c-.5 1.5-1.5 2-3 2-3.5-.5-6.5-3.5-7-7 0-1.5.5-2.5 2-3l1 2-1.5 1Z" fill="currentColor" stroke="none"/></svg>
            <span><span class="lbl" style="display:block; font-size: 0.78rem; letter-spacing: 0.2em; text-transform: uppercase; color: var(--ink-faint); margin-bottom: 2px;">WhatsApp</span><a href="https://wa.me/{{ setting('contact_whatsapp', '919999999999') }}" rel="noopener" style="color: var(--terra-deep); text-decoration: underline; text-underline-offset: 3px;">Message us directly</a></span>
          </li>
          <li style="display:flex; gap:14px; align-items:flex-start; margin-bottom:18px;">
            <svg style="width:20px; height:20px; flex:none; margin-top:4px; color:var(--terra);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M4 6h16v12H4zM4 7l8 6 8-6"/></svg>
            <span><span class="lbl" style="display:block; font-size: 0.78rem; letter-spacing: 0.2em; text-transform: uppercase; color: var(--ink-faint); margin-bottom: 2px;">Email</span><a href="mailto:{{ setting('contact_email', 'hello@storyloom.in') }}" style="color: var(--terra-deep); text-decoration: underline; text-underline-offset: 3px;">{{ setting('contact_email', 'hello@storyloom.in') }}</a></span>
          </li>
          <li style="display:flex; gap:14px; align-items:flex-start; margin-bottom:18px;">
            <svg style="width:20px; height:20px; flex:none; margin-top:4px; color:var(--terra);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="3.5" y="3.5" width="17" height="17" rx="4.5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r="1" fill="currentColor" stroke="none"/></svg>
            <span><span class="lbl" style="display:block; font-size: 0.78rem; letter-spacing: 0.2em; text-transform: uppercase; color: var(--ink-faint); margin-bottom: 2px;">Instagram</span><a href="{{ setting('social_instagram', 'https://instagram.com/storyloom.in') }}" rel="noopener" style="color: var(--terra-deep); text-decoration: underline; text-underline-offset: 3px;">@{{ setting('instagram_username', 'storyloom.in') }}</a></span>
          </li>
        </ul>
        <p class="hand-note" style="margin-top: 26px;">voice notes welcome. rambling encouraged.</p>
      </div>

      <form id="begin-form" class="form-grid" data-reveal="right" novalidate>
        @csrf
        <div class="form-row">
          <div class="field">
            <label for="f-name">Your name <span class="req" aria-hidden="true">*</span></label>
            <input id="f-name" name="name" type="text" autocomplete="name" required>
          </div>
          <div class="field">
            <label for="f-for">Who is the story for? <span class="req" aria-hidden="true">*</span></label>
            <input id="f-for" name="for" type="text" placeholder="e.g. my mother, my best friend" required>
          </div>
        </div>
        
        <div class="form-row">
          <div class="field">
            <label for="f-email">Your Email Address <span class="req" aria-hidden="true">*</span></label>
            <input id="f-email" name="email" type="email" autocomplete="email" required>
          </div>
          <div class="field">
            <label for="f-phone">Your Phone Number</label>
            <input id="f-phone" name="phone" type="tel" autocomplete="tel">
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
              <option>Mother's Day / Father's Day</option>
              <option>Retirement</option>
              <option>Farewell / moving away</option>
              <option>Proposal</option>
              <option>Just because</option>
            </select>
          </div>
          <div class="field">
            <label for="f-timeline">When do you need it?</label>
            <input id="f-timeline" name="timeline" type="text" placeholder="a date, a month, or 'flexible'">
            <p class="helper">Most books take 3–5 weeks. Tight date? Still write — we plan backwards.</p>
          </div>
        </div>
        
        <div class="field">
          <label for="f-story">One memory you never want forgotten <span class="req" aria-hidden="true">*</span></label>
          <textarea id="f-story" name="story" required
            placeholder="Don't polish it. 'Every Sunday my dad cycled me to the same juice stall and we never told my mother' is a perfect beginning."></textarea>
        </div>
        <fieldset style="border:none;">
          <legend class="field" style="margin-bottom:10px;"><span style="font-family:var(--font-display); font-weight:700; font-size:.85rem; letter-spacing:.18em; text-transform:uppercase; color:var(--ink-soft);">How should we continue?</span></legend>
          <div class="channel-choice">
            <label><input type="radio" name="channel" value="whatsapp" checked> Continue on WhatsApp</label>
            <label><input type="radio" name="channel" value="email"> Continue over email</label>
          </div>
        </fieldset>
        <div>
          <button class="btn btn-primary" type="submit">Send &amp; Begin
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
          </button>
          <div id="begin-success" hidden tabindex="-1">
            Beautifully begun. Your message is opening in WhatsApp or your mail app — send it, and a real person will reply within a day.
          </div>
        </div>
      </form>
    </div>
  </section>

  <section class="section section-tint">
    <div class="container">
      <div class="section-head center" data-reveal>
        <p class="eyebrow eyebrow-center">What happens next</p>
        <h2>The gentlest <em>beginning.</em></h2>
      </div>
      <div class="process-grid">
        <div class="process-step" data-reveal style="--stagger:0">
          <div class="step-no">I</div>
          <h3>We reply within a day</h3>
          <p>With a few thoughtful questions about the person and the occasion — and an honest timeline for your date.</p>
          <span class="process-line" aria-hidden="true"></span>
        </div>
        <div class="process-step" data-reveal style="--stagger:1">
          <div class="step-no">II</div>
          <h3>You get a plan &amp; quote</h3>
          <p>The story direction, the edition we'd recommend, and the exact price. You decide only once you can picture the book.</p>
          <span class="process-line" aria-hidden="true"></span>
        </div>
        <div class="process-step" data-reveal style="--stagger:2">
          <div class="step-no">III</div>
          <h3>The loom starts</h3>
          <p>Writers write, illustrators paint, you review — and in a few weeks, someone you love is holding their own story.</p>
        </div>
      </div>
    </div>
  </section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  var form = document.getElementById('begin-form');
  if (form) {
    form.addEventListener('submit', function (e) {
      // Prevent other handlers (specifically the main.js static redirection handler) from firing
      e.preventDefault();
      e.stopImmediatePropagation();
      
      if (!form.checkValidity()) {
        form.reportValidity();
        return;
      }
      
      var submitBtn = form.querySelector('button[type="submit"]');
      submitBtn.disabled = true;
      submitBtn.innerText = 'Sending...';

      var formData = new FormData(form);
      
      fetch('{{ route("contact.submit") }}', {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
      })
      .then(function (response) {
        return response.json();
      })
      .then(function (data) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Send &amp; Begin <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>';
        
        if (data.success) {
          // Display success note
          var note = document.querySelector("#begin-success");
          if (note) {
            note.hidden = false;
            note.focus();
          }
          
          // Open WhatsApp or mail client
          if (data.channel === 'email') {
            window.location.href = data.email_url;
          } else {
            window.open(data.whatsapp_url, "_blank", "noopener");
          }
          
          // Reset the form
          form.reset();
        } else {
          alert('Something went wrong. Please check inputs and try again.');
        }
      })
      .catch(function (error) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Send &amp; Begin <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>';
        console.error('Error:', error);
        alert('An error occurred while submitting. Please try again.');
      });
    });
  }
});
</script>
@endpush
