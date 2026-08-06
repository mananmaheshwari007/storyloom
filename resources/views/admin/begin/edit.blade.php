@extends('layouts.admin')

@section('title', 'Begin a Story Page Manager')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="page-title h3 mb-1"><i class="bi bi-rocket-takeoff me-2 text-primary"></i> 9. Begin a Story Page Manager</h1>
        <p class="text-muted small mb-0">Every piece of text on the /begin page, in the order it appears.</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Begin a Story</li>
        </ol>
    </nav>
</div>

<form action="{{ route('admin.begin.update') }}" method="POST">
    @csrf

    <div class="card shadow-sm border-0 mb-4 bg-white sticky-top" style="top: 80px; z-index: 100;">
        <div class="card-body py-2 px-3 d-flex align-items-center justify-content-between">
            <span class="fw-bold text-dark small"><i class="bi bi-sliders me-1 text-primary"></i> Begin Page Controls</span>
            <button type="submit" class="btn btn-sm btn-primary fw-bold px-4 py-1">
                <i class="bi bi-save me-1"></i> Save Begin Page Changes
            </button>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">

            {{-- ---------- Hero ---------- --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-bold text-dark"><i class="bi bi-fonts me-2 text-primary"></i> Page Hero</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Eyebrow</label>
                        <input type="text" name="begin_hero_eyebrow" class="form-control form-control-sm" value="{{ setting('begin_hero_eyebrow', 'Begin your story') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Main Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                        <input type="text" name="begin_hero_heading" class="form-control form-control-sm" value="{{ setting('begin_hero_heading', 'Start with one <em>memory.</em>') }}">
                        <div class="form-text">Use <code>&lt;em&gt;word&lt;/em&gt;</code> for the italic accent, <code>&lt;br&gt;</code> for a line break.</div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold">Intro Paragraph</label>
                        <textarea name="begin_hero_lede" class="form-control form-control-sm" rows="3">{{ setting('begin_hero_lede', 'That\'s genuinely all it takes. Tell us who the book is for and one moment you never want forgotten. We\'ll reply within a day — with questions, a plan, and a timeline. No payment, no commitment, just the beginning.') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- ---------- The form ---------- --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-bold text-dark"><i class="bi bi-ui-checks me-2 text-primary"></i> The Form</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">"Your name" label</label>
                            <input type="text" name="begin_label_name" class="form-control form-control-sm" value="{{ setting('begin_label_name', 'Your name') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">"Who is the story for?" label</label>
                            <input type="text" name="begin_label_for" class="form-control form-control-sm" value="{{ setting('begin_label_for', 'Who is the story for?') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">"Who is it for?" placeholder</label>
                            <input type="text" name="begin_ph_for" class="form-control form-control-sm" value="{{ setting('begin_ph_for', 'e.g. my mother, my best friend') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Email field label</label>
                            <input type="text" name="begin_label_email" class="form-control form-control-sm" value="{{ setting('begin_label_email', 'Your Email Address') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Phone field label</label>
                            <input type="text" name="begin_label_phone" class="form-control form-control-sm" value="{{ setting('begin_label_phone', 'Your Phone Number') }}">
                        </div>
                        <div class="col-12">
                            <div class="alert alert-light border small mb-0">
                                <i class="bi bi-info-circle me-1 text-primary"></i>
                                Whichever reply channel the visitor picks decides which of these two is required —
                                WhatsApp makes the phone number mandatory, Email makes the address mandatory.
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Occasion field label</label>
                            <input type="text" name="begin_label_occasion" class="form-control form-control-sm" value="{{ setting('begin_label_occasion', 'The occasion') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Occasion "nothing chosen" option</label>
                            <input type="text" name="begin_ph_occasion" class="form-control form-control-sm" value="{{ setting('begin_ph_occasion', 'Choose one (or don\'t)') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Occasion choices</label>
                            <textarea name="begin_occasions" class="form-control form-control-sm" rows="2">{{ setting('begin_occasions', "Anniversary, Birthday, Wedding, Diwali, Raksha Bandhan, Mother's Day, Father's Day, Farewell / Moving, Just Because") }}</textarea>
                            <div class="form-text">Separate each option with a comma.</div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">"Tell us one memory" label</label>
                            <input type="text" name="begin_label_story" class="form-control form-control-sm" value="{{ setting('begin_label_story', 'Tell us one memory') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Memory box placeholder</label>
                            <textarea name="begin_ph_story" class="form-control form-control-sm" rows="2">{{ setting('begin_ph_story', 'Don\'t worry about writing well — bullet points, half-remembered details, or a single story are plenty.') }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">"Where should we reply?" label</label>
                            <input type="text" name="begin_label_channel" class="form-control form-control-sm" value="{{ setting('begin_label_channel', 'Where should we reply?') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">WhatsApp option</label>
                            <input type="text" name="begin_channel_whatsapp" class="form-control form-control-sm" value="{{ setting('begin_channel_whatsapp', 'WhatsApp') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Email option</label>
                            <input type="text" name="begin_channel_email" class="form-control form-control-sm" value="{{ setting('begin_channel_email', 'Email') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Submit button text</label>
                            <input type="text" name="begin_btn_text" class="form-control form-control-sm" value="{{ setting('begin_btn_text', 'Send Memory & Begin') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Message shown after sending</label>
                            <input type="text" name="begin_success_note" class="form-control form-control-sm" value="{{ setting('begin_success_note', 'We have received your details and will get in touch shortly.') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">

            {{-- ---------- Side card ---------- --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-bold text-dark"><i class="bi bi-chat-dots me-2 text-primary"></i> "Prefer to just talk?" Card</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Eyebrow</label>
                        <input type="text" name="begin_box_eyebrow" class="form-control form-control-sm" value="{{ setting('begin_box_eyebrow', 'Prefer to just talk?') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Heading</label>
                        <input type="text" name="begin_box_heading" class="form-control form-control-sm" value="{{ setting('begin_box_heading', 'We\'re one message away.') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Supporting Text</label>
                        <textarea name="begin_box_subtext" class="form-control form-control-sm" rows="3">{{ setting('begin_box_subtext', 'Most Storylooms begin as a WhatsApp message that starts with “this might be a strange request…” It never is.') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">WhatsApp link text</label>
                        <input type="text" name="begin_box_wa_text" class="form-control form-control-sm" value="{{ setting('begin_box_wa_text', 'Message us directly') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Handwritten Note</label>
                        <input type="text" name="begin_box_note" class="form-control form-control-sm" value="{{ setting('begin_box_note', 'voice notes welcome. rambling encouraged.') }}">
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold">Privacy Note <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                        <textarea name="begin_privacy_note" class="form-control form-control-sm" rows="4">{{ setting('begin_privacy_note', 'Your memories stay between us. We never sell, share or publish anything you send — not your story, not your photographs, not your contact details. Nothing appears on this site without your written permission.') }}</textarea>
                        <div class="form-text">Sits under this card with a small shield icon. Leave blank to hide it entirely.</div>
                    </div>
                    <hr class="my-3">
                    <p class="text-muted small mb-0">
                        The WhatsApp number, email address and Instagram handle in this card come from
                        <a href="{{ route('admin.settings.index') }}">Site Settings</a>.
                    </p>
                </div>
            </div>

            {{-- ---------- Notifications ---------- --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-bold text-dark"><i class="bi bi-envelope-check me-2 text-primary"></i> Enquiry Notifications</h5>
                </div>
                <div class="card-body">
                    <label class="form-label fw-bold">Send new enquiries to</label>
                    <input type="email" name="enquiry_notify_email" class="form-control form-control-sm @error('enquiry_notify_email') is-invalid @enderror" value="{{ setting('enquiry_notify_email', 'team@storyloombooks.com') }}">
                    @error('enquiry_notify_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">
                        Every submission is saved under <a href="{{ route('admin.messages.index') }}">Messages</a> first — this email is an extra alert on top of that,
                        so a mail problem can never lose you an enquiry.
                    </div>
                </div>
            </div>

            {{-- ---------- Mail diagnostics ----------
                 Enquiry mail failures are logged rather than shown to the
                 visitor, so without this panel a misconfigured mailbox looks
                 exactly like a working one from the dashboard. --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-bold text-dark"><i class="bi bi-wrench-adjustable me-2 text-primary"></i> Mail Status</h5>
                </div>
                <div class="card-body">
                    @php
                        $mailer = config('mail.default');
                        $smtp = config('mail.mailers.smtp');
                        $fromAddress = config('mail.from.address');
                        $configCached = file_exists(base_path('bootstrap/cache/config.php'));
                    @endphp

                    @if($mailer === 'log')
                        <div class="alert alert-danger py-2 px-3 small mb-3">
                            <strong>Nothing is being sent.</strong> The mailer is set to <code>log</code>, so enquiry emails are written to
                            <code>storage/logs/laravel.log</code> instead of being delivered.
                        </div>
                    @endif

                    <table class="table table-sm mb-3 small">
                        <tr><td class="text-muted" style="width:110px;">Mailer</td><td><code>{{ $mailer }}</code></td></tr>
                        <tr><td class="text-muted">SMTP host</td><td><code>{{ $smtp['host'] ?? '—' }}:{{ $smtp['port'] ?? '—' }}</code></td></tr>
                        <tr><td class="text-muted">Scheme</td><td><code>{{ $smtp['scheme'] ?: 'auto (STARTTLS)' }}</code></td></tr>
                        <tr><td class="text-muted">Username</td><td><code>{{ $smtp['username'] ?: 'none' }}</code></td></tr>
                        <tr>
                            <td class="text-muted">From</td>
                            <td>
                                <code>{{ $fromAddress }}</code>
                                @if($fromAddress === 'hello@example.com')
                                    <span class="badge bg-danger ms-1">placeholder</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    @if($configCached)
                        <div class="alert alert-warning py-2 px-3 small mb-3">
                            <strong>Config is cached.</strong> The values above come from
                            <code>bootstrap/cache/config.php</code>, not from <code>.env</code>. If they don't match what you
                            put in <code>.env</code>, delete that cache file and reload this page.
                        </div>
                    @endif

                    @if(session('mail_test_ok'))
                        <div class="alert alert-success py-2 px-3 small mb-3">{{ session('mail_test_ok') }}</div>
                    @endif
                    @if(session('mail_test_error'))
                        <div class="alert alert-danger py-2 px-3 small mb-3">
                            <strong>Send failed.</strong>
                            <div class="mt-1" style="word-break: break-word;">{{ session('mail_test_error') }}</div>
                        </div>
                    @endif

                    {{-- Submits the separate form below, since forms can't nest. --}}
                    <button type="submit" form="mail-test-form" class="btn btn-outline-primary btn-sm w-100">
                        <i class="bi bi-send me-1"></i> Send a test email
                    </button>
                    <div class="form-text mt-2">
                        Goes to the address above and reports the exact error if it fails. Save any address change first.
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- Kept outside the editor form: HTML forms cannot be nested, so the button in
     the Mail Status card targets this one via its form="" attribute. --}}
<form id="mail-test-form" action="{{ route('admin.begin.testMail') }}" method="POST" class="d-none">
    @csrf
</form>
@endsection
