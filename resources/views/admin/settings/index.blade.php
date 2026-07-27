@extends('layouts.admin')

@section('title', 'Page Content & Website Settings')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="page-title h3 mb-1">Page Content & Website Settings</h1>
        <p class="text-muted small mb-0">Customize all frontend page titles, text content, section headers, badges, images, and brand settings.</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Page Content & Settings</li>
        </ol>
    </nav>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Settings Navigation Tabs -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom-0 pb-0 pt-3">
            <ul class="nav nav-tabs card-header-tabs flex-wrap" id="settingsTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-semibold" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab"><i class="bi bi-gear-fill me-1"></i> General & Branding</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab"><i class="bi bi-house-door-fill me-1"></i> Home Page</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold" id="about-tab" data-bs-toggle="tab" data-bs-target="#about" type="button" role="tab"><i class="bi bi-info-circle-fill me-1"></i> About Page</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold" id="how-tab" data-bs-toggle="tab" data-bs-target="#how" type="button" role="tab"><i class="bi bi-diagram-3-fill me-1"></i> How It Works</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold" id="pricing-tab" data-bs-toggle="tab" data-bs-target="#pricing" type="button" role="tab"><i class="bi bi-tags-fill me-1"></i> Pricing Page</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold" id="library-tab" data-bs-toggle="tab" data-bs-target="#library" type="button" role="tab"><i class="bi bi-book-fill me-1"></i> Library & Occasions</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold" id="faq-tab" data-bs-toggle="tab" data-bs-target="#faq" type="button" role="tab"><i class="bi bi-question-circle-fill me-1"></i> FAQ & Begin Form</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold" id="cta-tab" data-bs-toggle="tab" data-bs-target="#cta" type="button" role="tab"><i class="bi bi-megaphone-fill me-1"></i> Global CTA Banner</button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Tab Contents -->
    <div class="tab-content" id="settingsTabContent">

        <!-- ================= TAB 1: GENERAL & BRANDING ================= -->
        <div class="tab-pane fade show active" id="general" role="tabpanel">
            <div class="row g-4">
                <div class="col-lg-8">
                    <!-- General Information -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3 border-0">
                            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-info-square me-2 text-primary"></i> Site Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="site_name" class="form-label font-weight-bold">Site Name</label>
                                <input type="text" class="form-control" id="site_name" name="site_name" value="{{ setting('site_name', 'Storyloom') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="copyright_text" class="form-label">Copyright Text</label>
                                <input type="text" class="form-control" id="copyright_text" name="copyright_text" value="{{ setting('copyright_text', 'Storyloom. Every story belongs to its family.') }}">
                            </div>
                            <div class="mb-3">
                                <label for="site_description" class="form-label">Footer Description Text</label>
                                <textarea class="form-control" id="site_description" name="site_description" rows="3">{{ setting('site_description', 'Storyloom transforms your memories into a hand-illustrated keepsake storybook — a one-of-a-kind gift for the people who shaped your life.') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Details -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3 border-0">
                            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-telephone-fill me-2 text-success"></i> Contact & Support</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="contact_email" class="form-label">Contact Email</label>
                                    <input type="email" class="form-control" id="contact_email" name="contact_email" value="{{ setting('contact_email', 'hello@storyloom.in') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="contact_phone" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" id="contact_phone" name="contact_phone" value="{{ setting('contact_phone', '+91 99999 99999') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="contact_whatsapp" class="form-label">WhatsApp Number (e.g. 919999999999)</label>
                                    <input type="text" class="form-control" id="contact_whatsapp" name="contact_whatsapp" value="{{ setting('contact_whatsapp', '919999999999') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="contact_address" class="form-label">Office Address</label>
                                    <input type="text" class="form-control" id="contact_address" name="contact_address" value="{{ setting('contact_address', 'New Delhi, India') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="social_instagram" class="form-label">Instagram Profile URL</label>
                                    <input type="url" class="form-control" id="social_instagram" name="social_instagram" value="{{ setting('social_instagram', 'https://instagram.com/storyloombooks') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="instagram_username" class="form-label">Instagram Username (without @)</label>
                                    <input type="text" class="form-control" id="instagram_username" name="instagram_username" value="{{ setting('instagram_username', 'storyloombooks') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Default SEO -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3 border-0">
                            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-search me-2 text-info"></i> Default SEO Meta Tags</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="seo_title" class="form-label">Default SEO Meta Title</label>
                                <input type="text" class="form-control" id="seo_title" name="seo_title" value="{{ setting('seo_title', 'Storyloom — The Story Only You Could Give') }}">
                            </div>
                            <div class="mb-3">
                                <label for="seo_description" class="form-label">Default SEO Description</label>
                                <textarea class="form-control" id="seo_description" name="seo_description" rows="3">{{ setting('seo_description', 'Storyloom transforms your memories into a hand-illustrated keepsake storybook — a one-of-a-kind gift for the people who shaped your life.') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="seo_keywords" class="form-label">Default SEO Keywords</label>
                                <input type="text" class="form-control" id="seo_keywords" name="seo_keywords" value="{{ setting('seo_keywords', 'personalized storybook, keepsake books, customized gifts, illustrated storybook, India gifts') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Brand Assets -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3 border-0">
                            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-image me-2 text-warning"></i> Brand Assets</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <label class="form-label">Header Logo (Light)</label>
                                @if(setting('site_logo_light'))
                                    <div class="mb-2 p-2 bg-dark rounded text-center">
                                        <img src="{{ asset(setting('site_logo_light')) }}" alt="Logo Light" height="40">
                                    </div>
                                @endif
                                <input type="file" class="form-control" name="site_logo_light" accept="image/*">
                                <div class="form-text">Max file size: <strong>2 MB</strong>. Recommended dimensions: <strong>300 × 100 px</strong> (PNG or SVG with transparent background).</div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Brand Emblem</label>
                                @if(setting('site_emblem'))
                                    <div class="mb-2 p-2 bg-light rounded text-center">
                                        <img src="{{ asset(setting('site_emblem')) }}" alt="Emblem" height="50">
                                    </div>
                                @endif
                                <input type="file" class="form-control" name="site_emblem" accept="image/*">
                                <div class="form-text">Max file size: <strong>2 MB</strong>. Recommended dimensions: <strong>512 × 512 px</strong> (Square 1:1 format).</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Favicon</label>
                                @if(setting('site_favicon'))
                                    <div class="mb-2 text-center">
                                        <img src="{{ asset(setting('site_favicon')) }}" alt="Favicon" width="32" height="32">
                                    </div>
                                @endif
                                <input type="file" class="form-control" name="site_favicon" accept="image/*">
                                <div class="form-text">Max file size: <strong>1 MB</strong>. Recommended dimensions: <strong>64 × 64 px</strong> or <strong>32 × 32 px</strong> (PNG format).</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= TAB 2: HOMEPAGE CONTENT ================= -->
        <div class="tab-pane fade" id="home" role="tabpanel">
            <!-- Hero Section — Image Arc Carousel -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-images me-2 text-primary"></i> Hero Section — Image Arc Carousel</h5>
                    <a href="{{ route('admin.hero.edit') }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil-square me-1"></i> Dedicated Carousel & Copy Editor</a>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="hero_subheading" class="form-label font-weight-bold">Section Eyebrow</label>
                            <input type="text" class="form-control" id="hero_subheading" name="hero_subheading" value="{{ setting('hero_subheading', 'PERSONALISED KEEPSAKE STORYBOOKS') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="hero_heading" class="form-label font-weight-bold">Main Heading (HTML allowed like &lt;em&gt;)</label>
                            <input type="text" class="form-control" id="hero_heading" name="hero_heading" value="{{ setting('hero_heading', 'The story only <em>you</em> could give.') }}">
                        </div>
                        <div class="col-12">
                            <label for="hero_description" class="form-label font-weight-bold">Section Description</label>
                            <textarea class="form-control" id="hero_description" name="hero_description" rows="3">{{ setting('hero_description', 'We transform your memories into a beautifully illustrated keepsake book — every page painted around your people, your places, and the moments that made you a family.') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="hero_btn1_text" class="form-label font-weight-bold">Primary Button Text</label>
                            <input type="text" class="form-control" id="hero_btn1_text" name="hero_btn1_text" value="{{ setting('hero_btn1_text', 'BEGIN YOUR STORY') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="hero_btn1_link" class="form-label font-weight-bold">Primary Button Link</label>
                            <input type="text" class="form-control" id="hero_btn1_link" name="hero_btn1_link" value="{{ setting('hero_btn1_link', '/begin') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="hero_btn2_text" class="form-label font-weight-bold">Secondary Button Text</label>
                            <input type="text" class="form-control" id="hero_btn2_text" name="hero_btn2_text" value="{{ setting('hero_btn2_text', 'READ A STORYLOOM') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="hero_btn2_link" class="form-label font-weight-bold">Secondary Button Link</label>
                            <input type="text" class="form-control" id="hero_btn2_link" name="hero_btn2_link" value="{{ setting('hero_btn2_link', '/library') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="hero_note" class="form-label font-weight-bold">Rating Sub-note / Tagline</label>
                            <input type="text" class="form-control" id="hero_note" name="hero_note" value="{{ setting('hero_note', 'Illustrated by hand · Crafted in India · Delivered worldwide') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="hero_carousel_speed" class="form-label font-weight-bold">Carousel Speed (Seconds)</label>
                            <div class="input-group">
                                <input type="number" step="0.5" min="1" max="15" class="form-control" id="hero_carousel_speed" name="hero_carousel_speed" value="{{ setting('hero_carousel_speed', 3.0) }}">
                                <span class="input-group-text">sec</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Problem Section -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-exclamation-triangle me-2 text-warning"></i> "The Trouble with Gifts" Section</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="problem_eyebrow" class="form-label">Section Eyebrow</label>
                            <input type="text" class="form-control" id="problem_eyebrow" name="problem_eyebrow" value="{{ setting('problem_eyebrow', 'The trouble with gifts') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="problem_heading" class="form-label">Section Heading (HTML allowed)</label>
                            <input type="text" class="form-control" id="problem_heading" name="problem_heading" value="{{ setting('problem_heading', 'Most gifts are <em>forgotten.</em>') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Gift 1 Word</label>
                            <input type="text" class="form-control" name="problem_gift1_word" value="{{ setting('problem_gift1_word', 'Flowers') }}">
                            <label class="form-label mt-2">Gift 1 Fate</label>
                            <input type="text" class="form-control" name="problem_gift1_fate" value="{{ setting('problem_gift1_fate', 'fade in a week') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Gift 2 Word</label>
                            <input type="text" class="form-control" name="problem_gift2_word" value="{{ setting('problem_gift2_word', 'Chocolates') }}">
                            <label class="form-label mt-2">Gift 2 Fate</label>
                            <input type="text" class="form-control" name="problem_gift2_fate" value="{{ setting('problem_gift2_fate', 'disappear in a day') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Gift 3 Word</label>
                            <input type="text" class="form-control" name="problem_gift3_word" value="{{ setting('problem_gift3_word', 'Gadgets') }}">
                            <label class="form-label mt-2">Gift 3 Fate</label>
                            <input type="text" class="form-control" name="problem_gift3_fate" value="{{ setting('problem_gift3_fate', 'are replaced next year') }}">
                        </div>
                        <div class="col-12 mt-3">
                            <label for="problem_lede" class="form-label">Bottom Conclusion Text</label>
                            <textarea class="form-control" id="problem_lede" name="problem_lede" rows="2">{{ setting('problem_lede', 'The people who shaped your life deserve something that says exactly what they mean to you — and keeps saying it, for years.') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reveal Section -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-eye me-2 text-info"></i> "Introducing Storyloom" Section</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="reveal_eyebrow" class="form-label">Section Eyebrow</label>
                            <input type="text" class="form-control" id="reveal_eyebrow" name="reveal_eyebrow" value="{{ setting('reveal_eyebrow', 'Introducing Storyloom') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="reveal_heading" class="form-label">Section Heading</label>
                            <input type="text" class="form-control" id="reveal_heading" name="reveal_heading" value="{{ setting('reveal_heading', 'Your memories, woven into a <em>storybook.</em>') }}">
                        </div>
                        <div class="col-12">
                            <label for="reveal_lede" class="form-label">Section Description</label>
                            <textarea class="form-control" id="reveal_lede" name="reveal_lede" rows="2">{{ setting('reveal_lede', 'A completely personalised, hand-illustrated book created from your memories — an original story where every detail belongs to your family alone.') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3 Process Steps Overview -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-123 me-2 text-success"></i> 3-Step Process Overview</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="process_eyebrow" class="form-label">Section Eyebrow</label>
                            <input type="text" class="form-control" id="process_eyebrow" name="process_eyebrow" value="{{ setting('process_eyebrow', 'The plan') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="process_heading" class="form-label">Section Heading</label>
                            <input type="text" class="form-control" id="process_heading" name="process_heading" value="{{ setting('process_heading', 'Three steps to a story they\'ll <em>never forget.</em>') }}">
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <h6 class="fw-bold text-primary">Step I</h6>
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control mb-2" name="process_step1_title" value="{{ setting('process_step1_title', 'Share Your Story') }}">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="process_step1_desc" rows="3">{{ setting('process_step1_desc', 'Tell us about them — the memories, the inside jokes, the places, the photographs. A gentle conversation, not a form. Whatever you have is enough.') }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <h6 class="fw-bold text-primary">Step II</h6>
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control mb-2" name="process_step2_title" value="{{ setting('process_step2_title', 'Refine It Together') }}">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="process_step2_desc" rows="3">{{ setting('process_step2_desc', 'Our writers shape your memories into a story; our illustrators paint your world into its pages. You review everything and we refine it until it feels exactly right.') }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <h6 class="fw-bold text-primary">Step III</h6>
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control mb-2" name="process_step3_title" value="{{ setting('process_step3_title', 'Receive Your Storyloom') }}">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="process_step3_desc" rows="3">{{ setting('process_step3_desc', 'A hardbound, archival-quality book arrives at your door — wrapped, sealed, and ready for the moment they open it.') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Why Storyloom / Transformation Cards -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-heart me-2 text-danger"></i> "Why Storyloom" & Transformation Cards</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="why_eyebrow" class="form-label">Section Eyebrow</label>
                            <input type="text" class="form-control" id="why_eyebrow" name="why_eyebrow" value="{{ setting('why_eyebrow', 'Why Storyloom') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="why_heading" class="form-label">Section Heading</label>
                            <input type="text" class="form-control" id="why_heading" name="why_heading" value="{{ setting('why_heading', 'Not a product. A <em>moment.</em>') }}">
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Card 1 Title</label>
                            <input type="text" class="form-control mb-2" name="why_card1_title" value="{{ setting('why_card1_title', 'A story, not a spec') }}">
                            <textarea class="form-control" name="why_card1_desc" rows="2">{{ setting('why_card1_desc', 'Not “32 pages” — a complete story they\'ll return to again and again, with a beginning, a middle, and your ending.') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Card 2 Title</label>
                            <input type="text" class="form-control mb-2" name="why_card2_title" value="{{ setting('why_card2_title', 'Made to be handed down') }}">
                            <textarea class="form-control" name="why_card2_desc" rows="2">{{ setting('why_card2_desc', 'Not “premium paper” — a book crafted to survive decades of bedtime readings, and still be there for the grandchildren.') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Card 3 Title</label>
                            <input type="text" class="form-control mb-2" name="why_card3_title" value="{{ setting('why_card3_title', 'Unmistakably them') }}">
                            <textarea class="form-control" name="why_card3_desc" rows="2">{{ setting('why_card3_desc', 'Their likeness, their street, their chai stall. A Storyloom could never belong to any other family — every detail on the page belongs to this one.') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Card 4 Title</label>
                            <input type="text" class="form-control mb-2" name="why_card4_title" value="{{ setting('why_card4_title', 'Painterly, calm, classic') }}">
                            <textarea class="form-control" name="why_card4_desc" rows="2">{{ setting('why_card4_desc', 'Closer to fine illustration than bright cartoon templates — art that belongs on a shelf, and in a will.') }}</textarea>
                        </div>
                    </div>
                    <hr class="my-4">
                    <h6 class="fw-bold">Before & After Quotes</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">"Before" Quote Text</label>
                            <input type="text" class="form-control mb-2" name="transform_before_quote" value="{{ setting('transform_before_quote', '“I don\'t know what to gift them…”') }}">
                            <label class="form-label">"Before" Subtext</label>
                            <input type="text" class="form-control" name="transform_before_who" value="{{ setting('transform_before_who', 'Every year, before') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">"After" Quote Text</label>
                            <input type="text" class="form-control mb-2" name="transform_after_quote" value="{{ setting('transform_after_quote', '“I can\'t believe you made this.”') }}">
                            <label class="form-label">"After" Subtext</label>
                            <input type="text" class="form-control" name="transform_after_who" value="{{ setting('transform_after_who', 'The moment they open it') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Testimonials & Marquee -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-chat-square-quote me-2 text-dark"></i> Testimonials & Marquee Chips</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Testimonials Eyebrow</label>
                            <input type="text" class="form-control" name="testimonial_eyebrow" value="{{ setting('testimonial_eyebrow', 'The moment it opens') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Testimonials Heading</label>
                            <input type="text" class="form-control" name="testimonial_heading" value="{{ setting('testimonial_heading', 'Some gifts get a thank-you. <em>These get tears.</em>') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Occasions Marquee Eyebrow</label>
                            <input type="text" class="form-control" name="marquee_eyebrow" value="{{ setting('marquee_eyebrow', 'For every occasion') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Occasions Marquee Heading</label>
                            <input type="text" class="form-control" name="marquee_heading" value="{{ setting('marquee_heading', 'Whenever words aren\'t <em>enough.</em>') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Occasions Chips List (comma separated)</label>
                            <input type="text" class="form-control" name="marquee_chips" value="{{ setting('marquee_chips', 'Anniversaries, Birthdays, Weddings, Diwali, Raksha Bandhan, Mother\'s Day, Father\'s Day, Valentine\'s Day, Proposals, Retirement, Graduation, Baby\'s First Year, Farewells') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= TAB 3: ABOUT PAGE ================= -->
        <div class="tab-pane fade" id="about" role="tabpanel">
            
            <!-- Section 1: Hero & Story Prose -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-file-earmark-person me-2 text-primary"></i> Section 1: Hero & Story Prose</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="about_hero_eyebrow" class="form-label font-weight-bold">Section Eyebrow</label>
                            <input type="text" class="form-control" id="about_hero_eyebrow" name="about_hero_eyebrow" value="{{ setting('about_hero_eyebrow', 'ABOUT STORYLOOM') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="about_hero_heading" class="form-label font-weight-bold">Section Heading (H1)</label>
                            <input type="text" class="form-control" id="about_hero_heading" name="about_hero_heading" value="{{ setting('about_hero_heading', 'We exist because memories<br>deserve better than a <em style="font-family: \'Cormorant Garamond\', Cormorant, Georgia, serif; font-style: italic; font-weight: 500; color: rgb(181, 91, 41);">camera roll.</em>') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="about_hero_p1" class="form-label">Story Prose — Paragraph 1 (Drop Cap)</label>
                        <textarea class="form-control" id="about_hero_p1" name="about_hero_p1" rows="2">{{ setting('about_hero_p1', 'Families capture more of their lives than ever — and revisit almost none of it.') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="about_hero_p2" class="form-label">Story Prose — Paragraph 2</label>
                        <textarea class="form-control" id="about_hero_p2" name="about_hero_p2" rows="2">{{ setting('about_hero_p2', 'Storyloom turns those scattered moments into the one object a family opens again and again: a book that holds a real relationship, a real home, a real chapter of a life.') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="about_hero_p3" class="form-label">Story Prose — Paragraph 3</label>
                        <textarea class="form-control" id="about_hero_p3" name="about_hero_p3" rows="2">{{ setting('about_hero_p3', 'The name is the method. A loom weaves loose threads into something whole.') }}</textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="about_artwork_img" class="form-label">Polaroid Artwork Image</label>
                            <input type="file" class="form-control mb-2" id="about_artwork_img" name="about_artwork_img">
                            <div class="form-text">Max file size: <strong>3 MB</strong>. Recommended dimensions: <strong>1600 × 900 px</strong> or <strong>1100 × 1469 px</strong>.</div>
                            <small class="text-muted">Current Image: {{ setting('about_artwork_img', 'assets/img/spread-street-morning.webp') }}</small>
                        </div>
                        <div class="col-md-6">
                            <label for="about_artwork_caption" class="form-label">Polaroid Handwritten Caption</label>
                            <input type="text" class="form-control" id="about_artwork_caption" name="about_artwork_caption" value="{{ setting('about_artwork_caption', 'ordinary moments — the ones that turn out to matter') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: What We Stand For -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-shield-check me-2 text-success"></i> Section 2: What We Stand For</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="stand_eyebrow" class="form-label font-weight-bold">Section Eyebrow</label>
                            <input type="text" class="form-control" id="stand_eyebrow" name="stand_eyebrow" value="{{ setting('stand_eyebrow', 'WHAT WE STAND FOR') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="stand_heading" class="form-label font-weight-bold">Section Heading</label>
                            <input type="text" class="form-control" id="stand_heading" name="stand_heading" value="{{ setting('stand_heading', 'Craftsmanship over speed.<br>Specificity over <em style="font-family: \'Cormorant Garamond\', Cormorant, Georgia, serif; font-style: italic; font-weight: 500; color: rgb(181, 91, 41);">sentiment.</em>') }}">
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-primary">Card 1 Title</label>
                            <input type="text" class="form-control mb-2" name="stand_card1_title" value="{{ setting('stand_card1_title', 'Every detail belongs to you') }}">
                            <label class="form-label">Card 1 Description</label>
                            <textarea class="form-control mb-3" name="stand_card1_desc" rows="2">{{ setting('stand_card1_desc', 'It\'s not a generic template. Every illustration — every street, corner, face — belongs to your story.') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-primary">Card 2 Title</label>
                            <input type="text" class="form-control mb-2" name="stand_card2_title" value="{{ setting('stand_card2_title', 'The book is the monument') }}">
                            <label class="form-label">Card 2 Description</label>
                            <textarea class="form-control mb-3" name="stand_card2_desc" rows="2">{{ setting('stand_card2_desc', 'Not a photo album. A custom hardbound book built to last longer than the memories inside it.') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-primary">Card 3 Title</label>
                            <input type="text" class="form-control mb-2" name="stand_card3_title" value="{{ setting('stand_card3_title', 'Paper, not plastic') }}">
                            <label class="form-label">Card 3 Description</label>
                            <textarea class="form-control mb-3" name="stand_card3_desc" rows="2">{{ setting('stand_card3_desc', 'Archival-quality paper, cloth-bound covers, true hot-stamped foil.') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-primary">Card 4 Title</label>
                            <input type="text" class="form-control mb-2" name="stand_card4_title" value="{{ setting('stand_card4_title', 'Made to be handed down') }}">
                            <label class="form-label">Card 4 Description</label>
                            <textarea class="form-control mb-3" name="stand_card4_desc" rows="2">{{ setting('stand_card4_desc', 'Built for living rooms — built to be kept for generations.') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 3: The Mark We Make -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-bookmark-star me-2 text-warning"></i> Section 3: The Mark We Make</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="mark_eyebrow" class="form-label font-weight-bold">Section Eyebrow</label>
                            <input type="text" class="form-control" id="mark_eyebrow" name="mark_eyebrow" value="{{ setting('mark_eyebrow', 'THE MARK WE MAKE') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="mark_heading" class="form-label font-weight-bold">Section Heading</label>
                            <input type="text" class="form-control" id="mark_heading" name="mark_heading" value="{{ setting('mark_heading', 'An heirloom mark,<br>not a <em style="font-family: \'Cormorant Garamond\', Cormorant, Georgia, serif; font-style: italic; font-weight: 500; color: rgb(181, 91, 41);">startup logo.</em>') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="mark_p1" class="form-label">Paragraph 1</label>
                        <textarea class="form-control" id="mark_p1" name="mark_p1" rows="3">{{ setting('mark_p1', 'Look closely at our emblem. At the top, a loom — vertical posts with threads strung between them: a family\'s scattered moments, still unformed. Below, those same threads fall and open into the pages of a book. One becomes the other.') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="mark_p2" class="form-label">Paragraph 2</label>
                        <textarea class="form-control" id="mark_p2" name="mark_p2" rows="3">{{ setting('mark_p2', 'The double ring borrows from seals and crests — marks that have always signified craftsmanship and things made to be handed down. It only reveals itself on a second look. So do our books.') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Section 4: A Note From The Founder -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-chat-quote-fill me-2 text-danger"></i> Section 4: A Note From The Founder</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="founder_eyebrow" class="form-label font-weight-bold">Section Eyebrow</label>
                            <input type="text" class="form-control" id="founder_eyebrow" name="founder_eyebrow" value="{{ setting('founder_eyebrow', 'A NOTE FROM THE FOUNDER') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="founder_author" class="form-label font-weight-bold">Founder Author Byline</label>
                            <input type="text" class="form-control" id="founder_author" name="founder_author" value="{{ setting('founder_author', 'MANAN · FOUNDER, STORYLOOM') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="founder_quote" class="form-label">Founder Quote Text</label>
                        <textarea class="form-control" id="founder_quote" name="founder_quote" rows="3">{{ setting('founder_quote', '“I started Storyloom after watching my mother re-read a forty-year-old letter until the folds wore through. We keep almost nothing now. I wanted to build the thing families keep.”') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Section 5: Final CTA Banner -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-megaphone-fill me-2 text-dark"></i> Section 5: Final CTA Banner</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="about_cta_heading" class="form-label font-weight-bold">Banner Heading</label>
                            <input type="text" class="form-control" id="about_cta_heading" name="about_cta_heading" value="{{ setting('about_cta_heading', 'Your family\'s chapter<br>is <em style="font-family: \'Cormorant Garamond\', Cormorant, Georgia, serif; font-style: italic; font-weight: 500; color: rgb(181, 91, 41);">ready</em> to be written.') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="about_cta_btn1" class="form-label font-weight-bold">Primary Button Text</label>
                            <input type="text" class="form-control" id="about_cta_btn1" name="about_cta_btn1" value="{{ setting('about_cta_btn1', 'BEGIN YOUR STORY') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="about_cta_desc" class="form-label">Banner Description</label>
                        <textarea class="form-control" id="about_cta_desc" name="about_cta_desc" rows="2">{{ setting('about_cta_desc', 'Somewhere a memory is waiting to be told and painted into a book. Tell us your story to begin, or read a storyloom.') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="about_cta_bg" class="form-label">Banner Background Image</label>
                        <input type="file" class="form-control mb-2" id="about_cta_bg" name="about_cta_bg">
                        <div class="form-text">Max file size: <strong>3 MB</strong>. Recommended dimensions: <strong>1600 × 900 px</strong> (Landscape format).</div>
                        <small class="text-muted">Current Image: {{ setting('about_cta_bg', 'assets/img/spread-alone-bench.webp') }}</small>
                    </div>
                </div>
            </div>

        </div>

        <!-- ================= TAB 4: HOW IT WORKS ================= -->
        <div class="tab-pane fade" id="how" role="tabpanel">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-map me-2 text-primary"></i> How It Works Page Header</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Eyebrow</label>
                            <input type="text" class="form-control" name="how_hero_eyebrow" value="{{ setting('how_hero_eyebrow', 'The journey') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Heading</label>
                            <input type="text" class="form-control" name="how_hero_heading" value="{{ setting('how_hero_heading', 'How a Storyloom is <em>woven.</em>') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Lede Description</label>
                            <textarea class="form-control" name="how_hero_lede" rows="2">{{ setting('how_hero_lede', 'From a single recollected memory to a finished illustrated heirloom book, the entire process takes about 4 to 6 weeks. Here is how we make it together.') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline Steps 1-4 -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-diagram-2 me-2 text-success"></i> 4 Timeline Steps</h5>
                </div>
                <div class="card-body">
                    <!-- Step 1 -->
                    <div class="p-3 bg-light rounded mb-4">
                        <h6 class="fw-bold text-primary">Step 1</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Badge Label</label>
                                <input type="text" class="form-control" name="how_step1_badge" value="{{ setting('how_step1_badge', 'Week 1') }}">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="how_step1_title" value="{{ setting('how_step1_title', '1. Share your story') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="how_step1_desc" rows="2">{{ setting('how_step1_desc', 'Tell us about the person this book is for. You share memory fragments, inside jokes, their favorite places, and photos of them. You don\'t need a written script — our writers will convert your fragments into a narrative structure.') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Step 1 Image</label>
                                @if(setting('how_step1_img'))
                                    <div class="mb-2"><img src="{{ asset(setting('how_step1_img')) }}" height="60" class="rounded"></div>
                                @endif
                                <input type="file" class="form-control" name="how_step1_img" accept="image/*">
                                <div class="form-text">Max file size: <strong>3 MB</strong>. Recommended dimensions: <strong>1400 × 600 px</strong> or <strong>1600 × 900 px</strong>.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="p-3 bg-light rounded mb-4">
                        <h6 class="fw-bold text-primary">Step 2</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Badge Label</label>
                                <input type="text" class="form-control" name="how_step2_badge" value="{{ setting('how_step2_badge', 'Week 2-3') }}">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="how_step2_title" value="{{ setting('how_step2_title', '2. Review draft & storyboard') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="how_step2_desc" rows="2">{{ setting('how_step2_desc', 'Our writers send you the drafted manuscript for approval. Once you like the words, our illustrators sketch out layout spreads showing where figures, text, and scenes go. You review everything online and give feedback.') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Step 2 Image</label>
                                @if(setting('how_step2_img'))
                                    <div class="mb-2"><img src="{{ asset(setting('how_step2_img')) }}" height="60" class="rounded"></div>
                                @endif
                                <input type="file" class="form-control" name="how_step2_img" accept="image/*">
                                <div class="form-text">Max file size: <strong>3 MB</strong>. Recommended dimensions: <strong>1400 × 600 px</strong> or <strong>1600 × 900 px</strong>.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="p-3 bg-light rounded mb-4">
                        <h6 class="fw-bold text-primary">Step 3</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Badge Label</label>
                                <input type="text" class="form-control" name="how_step3_badge" value="{{ setting('how_step3_badge', 'Week 4-5') }}">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="how_step3_title" value="{{ setting('how_step3_title', '3. Painting in watercolor') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="how_step3_desc" rows="2">{{ setting('how_step3_desc', 'Once you approve the sketches, we start painting with watercolor washes, details, and text overlays. We map out realistic skin tones, locations, and facial structures so the book feels unmistakably yours.') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Step 3 Image</label>
                                @if(setting('how_step3_img'))
                                    <div class="mb-2"><img src="{{ asset(setting('how_step3_img')) }}" height="60" class="rounded"></div>
                                @endif
                                <input type="file" class="form-control" name="how_step3_img" accept="image/*">
                                <div class="form-text">Max file size: <strong>3 MB</strong>. Recommended dimensions: <strong>1400 × 600 px</strong> or <strong>1600 × 900 px</strong>.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="p-3 bg-light rounded mb-4">
                        <h6 class="fw-bold text-primary">Step 4</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Badge Label</label>
                                <input type="text" class="form-control" name="how_step4_badge" value="{{ setting('how_step4_badge', 'Week 6') }}">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="how_step4_title" value="{{ setting('how_step4_title', '4. Binding & shipping') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="how_step4_desc" rows="2">{{ setting('how_step4_desc', 'The painted spreads are printed on premium textured archival sheets, handbound using cotton linen thread, wrapped in cotton dust-jackets, and shipped to your address globally with tracking details.') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Step 4 Image</label>
                                @if(setting('how_step4_img'))
                                    <div class="mb-2"><img src="{{ asset(setting('how_step4_img')) }}" height="60" class="rounded"></div>
                                @endif
                                <input type="file" class="form-control" name="how_step4_img" accept="image/*">
                                <div class="form-text">Max file size: <strong>3 MB</strong>. Recommended dimensions: <strong>1400 × 600 px</strong> or <strong>1600 × 900 px</strong>.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= TAB 5: PRICING PAGE ================= -->
        <div class="tab-pane fade" id="pricing" role="tabpanel">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-tag-fill me-2 text-primary"></i> Pricing Page Header</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Page Eyebrow</label>
                            <input type="text" class="form-control" name="pricing_hero_eyebrow" value="{{ setting('pricing_hero_eyebrow', 'Pricing') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Page Title</label>
                            <input type="text" class="form-control" name="pricing_hero_title" value="{{ setting('pricing_hero_title', 'What a one-of-one book <em>includes.</em>') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Lede Description</label>
                            <textarea class="form-control" name="pricing_hero_lede" rows="2">{{ setting('pricing_hero_lede', 'Every Storyloom — whichever edition — is written from scratch, illustrated from scratch, and reviewed by you before printing. You\'re not buying a book off a shelf; you\'re commissioning the only copy that will ever exist.') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Strip -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-bar-chart-line me-2 text-success"></i> 3 Key Stat Metrics Strip</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Stat 1 Number</label>
                            <input type="text" class="form-control mb-2" name="pricing_stat1_num" value="{{ setting('pricing_stat1_num', '60+') }}">
                            <label class="form-label">Stat 1 Label</label>
                            <input type="text" class="form-control" name="pricing_stat1_lbl" value="{{ setting('pricing_stat1_lbl', 'hours of writing & illustration') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Stat 2 Number</label>
                            <input type="text" class="form-control mb-2" name="pricing_stat2_num" value="{{ setting('pricing_stat2_num', '100%') }}">
                            <label class="form-label">Stat 2 Label</label>
                            <input type="text" class="form-control" name="pricing_stat2_lbl" value="{{ setting('pricing_stat2_lbl', 'original story & art — no templates') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Stat 3 Number</label>
                            <input type="text" class="form-control mb-2" name="pricing_stat3_num" value="{{ setting('pricing_stat3_num', '∞') }}">
                            <label class="form-label">Stat 3 Label</label>
                            <input type="text" class="form-control" name="pricing_stat3_lbl" value="{{ setting('pricing_stat3_lbl', 'times it will be read aloud') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Note on Price Section -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-journal-text me-2 text-warning"></i> "A Note on Price" Section</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Section Eyebrow</label>
                            <input type="text" class="form-control" name="price_note_eyebrow" value="{{ setting('price_note_eyebrow', 'A note on price') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Section Heading</label>
                            <input type="text" class="form-control" name="price_note_heading" value="{{ setting('price_note_heading', 'Why a book can cost more than a <em>phone cover.</em>') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Paragraph 1</label>
                            <textarea class="form-control" name="price_note_p1" rows="3">{{ setting('price_note_p1', 'A Storyloom is not printed-on-demand merchandise. It is a commission — weeks of a writer\'s and an illustrator\'s full attention on one family\'s story. Every spread is composed for you: your faces, your streets, your weather, your light.') }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Paragraph 2</label>
                            <textarea class="form-control" name="price_note_p2" rows="3">{{ setting('price_note_p2', 'Divide the price by the years it will sit on a bedside table, be read at bedtimes, survive house moves, and eventually be handed to someone not yet born — and it becomes the least expensive thing you\'ll ever give.') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= TAB 6: LIBRARY & OCCASIONS ================= -->
        <div class="tab-pane fade" id="library" role="tabpanel">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-book-half me-2 text-primary"></i> Library Page Header</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Eyebrow</label>
                            <input type="text" class="form-control" name="library_hero_eyebrow" value="{{ setting('library_hero_eyebrow', 'Our library') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Heading</label>
                            <input type="text" class="form-control" name="library_hero_heading" value="{{ setting('library_hero_heading', 'Read a <em>Storyloom.</em>') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="library_hero_lede" rows="2">{{ setting('library_hero_lede', 'Browse complete stories we have created for real families. Every book starts with a clean memory outline and ends as an illustrated keepsake.') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-calendar-event me-2 text-success"></i> Occasions Page Sections</h5>
                </div>
                <div class="card-body">
                    <!-- Page Header -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Page Eyebrow</label>
                            <input type="text" class="form-control" name="occasions_hero_eyebrow" value="{{ setting('occasions_hero_eyebrow', 'OCCASIONS') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Page Heading (HTML allowed)</label>
                            <input type="text" class="form-control" name="occasions_hero_heading" value="{{ setting('occasions_hero_heading', 'For the days that<br>deserve more than a <em>gift.</em>') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Page Description</label>
                            <textarea class="form-control" name="occasions_hero_lede" rows="2">{{ setting('occasions_hero_lede', 'Some occasions come with easy custom — a cake, a card, a sweater. And some deserve the one gift that could only ever belong to one person. A Storyloom takes three to four weeks to craft, so the best time to begin is now.') }}</textarea>
                        </div>
                    </div>

                    <hr class="my-4">
                    <!-- Festivals & Celebrations -->
                    <h6 class="fw-bold text-primary">Festivals & Celebrations Section</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Section Eyebrow</label>
                            <input type="text" class="form-control" name="festivals_eyebrow" value="{{ setting('festivals_eyebrow', 'FESTIVALS & CELEBRATIONS') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Section Heading</label>
                            <input type="text" class="form-control" name="festivals_heading" value="{{ setting('festivals_heading', 'Gifts for the days the<br>whole family <em>gathers.</em>') }}">
                        </div>
                    </div>

                    <hr class="my-4">
                    <!-- Milestones -->
                    <h6 class="fw-bold text-success">Milestones Section</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Section Eyebrow</label>
                            <input type="text" class="form-control" name="milestones_eyebrow" value="{{ setting('milestones_eyebrow', 'MILESTONES') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Section Heading</label>
                            <input type="text" class="form-control" name="milestones_heading" value="{{ setting('milestones_heading', 'For the chapters that <em>close</em><br>— and the ones that <em>open.</em>') }}">
                        </div>
                    </div>

                    <hr class="my-4">
                    <!-- By Relationship -->
                    <h6 class="fw-bold text-warning">By Relationship Section</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Section Eyebrow</label>
                            <input type="text" class="form-control" name="rel_eyebrow" value="{{ setting('rel_eyebrow', 'BY RELATIONSHIP') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Section Heading</label>
                            <input type="text" class="form-control" name="rel_heading" value="{{ setting('rel_heading', 'Whoever they are to<br>you, there\'s a <em>book</em> in it.') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Relationship Chips (comma-separated)</label>
                            <input type="text" class="form-control" name="rel_chips" value="{{ setting('rel_chips', 'For your partner, For your husband, For Mom, For Dad, For your daughter, For a mentor, For a grandparent') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Bottom Subnote</label>
                            <input type="text" class="form-control" name="rel_subnote" value="{{ setting('rel_subnote', '...and for anybody whose face you\'ve ever stared at and wondered where the time went.') }}">
                        </div>
                    </div>

                    <hr class="my-4">
                    <!-- Bottom CTA Banner -->
                    <h6 class="fw-bold text-danger">Occasion Bottom CTA Banner</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Banner Heading</label>
                            <input type="text" class="form-control" name="occasion_banner_heading" value="{{ setting('occasion_banner_heading', 'Which occasion is coming <em>next?</em>') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Banner Subtext</label>
                            <input type="text" class="form-control" name="occasion_banner_desc" value="{{ setting('occasion_banner_desc', 'A Storyloom takes three to four weeks to craft. Cover books take 3 weeks from draft... Tell us your story, and return with the perfect custom gift saved in time.') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= TAB 7: FAQ & BEGIN FORM ================= -->
        <div class="tab-pane fade" id="faq" role="tabpanel">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-question-circle me-2 text-primary"></i> FAQ Page Header</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Eyebrow</label>
                            <input type="text" class="form-control" name="faq_hero_eyebrow" value="{{ setting('faq_hero_eyebrow', 'Good questions') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Heading</label>
                            <input type="text" class="form-control" name="faq_hero_heading" value="{{ setting('faq_hero_heading', 'Frequently Asked <em>Questions.</em>') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="faq_hero_lede" rows="2">{{ setting('faq_hero_lede', 'Answers to questions about writing guides, references, drawing processes, proof prints, and shipping details.') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Begin Story Form Details -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-pencil-square me-2 text-success"></i> Begin Story Form Page</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Page Eyebrow</label>
                            <input type="text" class="form-control" name="begin_hero_eyebrow" value="{{ setting('begin_hero_eyebrow', 'Begin your story') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Page Heading</label>
                            <input type="text" class="form-control" name="begin_hero_heading" value="{{ setting('begin_hero_heading', 'Start with one <em>memory.</em>') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Page Lede Description</label>
                            <textarea class="form-control" name="begin_hero_lede" rows="2">{{ setting('begin_hero_lede', 'That\'s genuinely all it takes. Tell us who the book is for and one moment you never want forgotten. We\'ll reply within a day — with questions, a plan, and a timeline. No payment, no commitment, just the beginning.') }}</textarea>
                        </div>
                    </div>
                    <hr class="my-4">
                    <h6 class="fw-bold">"Prefer to talk?" Sidebar Box</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Box Eyebrow</label>
                            <input type="text" class="form-control" name="begin_box_eyebrow" value="{{ setting('begin_box_eyebrow', 'Prefer to just talk?') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Box Heading</label>
                            <input type="text" class="form-control" name="begin_box_heading" value="{{ setting('begin_box_heading', 'We\'re one message away.') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Box Subtext</label>
                            <textarea class="form-control" name="begin_box_subtext" rows="2">{{ setting('begin_box_subtext', 'Most Storylooms begin as a WhatsApp message that starts with “this might be a strange request…” It never is.') }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Handwritten Note</label>
                            <input type="text" class="form-control" name="begin_box_note" value="{{ setting('begin_box_note', 'voice notes welcome. rambling encouraged.') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= TAB 8: GLOBAL CTA BANNER ================= -->
        <div class="tab-pane fade" id="cta" role="tabpanel">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-megaphone-fill me-2 text-primary"></i> Bottom Call-to-Action (CTA) Banner</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Eyebrow</label>
                            <input type="text" class="form-control" name="cta_eyebrow" value="{{ setting('cta_eyebrow', 'Begin tonight') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Heading</label>
                            <input type="text" class="form-control" name="cta_heading" value="{{ setting('cta_heading', 'Every relationship has a story worth <em>preserving.</em>') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description / Subtext</label>
                            <textarea class="form-control" name="cta_desc" rows="2">{{ setting('cta_desc', 'Another occasion will come around soon. This time, give them something that says everything — and stays said, forever.') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Button 1 Label</label>
                            <input type="text" class="form-control" name="cta_btn1_text" value="{{ setting('cta_btn1_text', 'Begin Your Story') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Button 1 Target URL</label>
                            <input type="text" class="form-control" name="cta_btn1_link" value="{{ setting('cta_btn1_link', '/begin') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Button 2 Label</label>
                            <input type="text" class="form-control" name="cta_btn2_text" value="{{ setting('cta_btn2_text', 'Read a Storyloom') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Button 2 Target URL</label>
                            <input type="text" class="form-control" name="cta_btn2_link" value="{{ setting('cta_btn2_link', '/library') }}">
                        </div>
                        <div class="col-12 mt-3">
                            <label class="form-label">CTA Banner Background Image</label>
                            @if(setting('cta_bg_image'))
                                <div class="mb-2"><img src="{{ asset(setting('cta_bg_image')) }}" height="80" class="rounded border"></div>
                            @endif
                            <input type="file" class="form-control" name="cta_bg_image" accept="image/*">
                            <div class="form-text">Max file size: <strong>3 MB</strong>. Recommended dimensions: <strong>1600 × 900 px</strong> (Landscape format).</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Sticky Save Button Bar -->
    <div class="card shadow-sm border-0 sticky-bottom py-3 px-4 bg-white mt-4">
        <div class="d-flex align-items-center justify-content-between">
            <span class="text-muted small"><i class="bi bi-info-circle me-1"></i> Changes will immediately take effect across all frontend pages.</span>
            <button type="submit" class="btn btn-primary px-4 fw-bold">
                <i class="bi bi-save me-1"></i> Save All Page Content & Settings
            </button>
        </div>
    </div>
</form>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Helper to scroll smoothly to the settings tabs navigation bar
    function scrollToTabs() {
      var navElem = document.getElementById('settingsTabs');
      if (navElem) {
        var topPos = navElem.getBoundingClientRect().top + window.pageYOffset - 80;
        window.scrollTo({ top: topPos, behavior: 'smooth' });
      }
    }

    // 1. Activate tab on page load based on URL hash (e.g., #faq or #cta)
    var hash = window.location.hash;
    if (hash) {
      var targetBtn = document.querySelector('button[data-bs-target="' + hash + '"]');
      if (targetBtn) {
        var bsTab = new bootstrap.Tab(targetBtn);
        bsTab.show();
        setTimeout(scrollToTabs, 150);
      }
    }

    // 2. On clicking any tab button, scroll smoothly to the top of tab content so user never has to scroll down
    var tabButtons = document.querySelectorAll('#settingsTabs button[data-bs-toggle="tab"]');
    tabButtons.forEach(function(btn) {
      btn.addEventListener('click', function(e) {
        setTimeout(scrollToTabs, 50);
        var targetHash = btn.getAttribute('data-bs-target');
        if (history.pushState && targetHash) {
          history.pushState(null, null, targetHash);
        }
      });
    });
  });
</script>
@endsection
