<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hero;
use App\Models\About;
use App\Models\Service;
use App\Models\Project;
use App\Models\Portfolio;
use App\Models\Product;
use App\Models\PricingPlan;
use App\Models\Faq;
use App\Models\Testimonial;
use App\Models\TeamMember;
use App\Models\Blog;
use App\Models\LibraryBook;
use App\Models\ContactMessage;
use App\Models\NewsletterSubscriber;
use App\Mail\NewEnquiry;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class FrontendController extends Controller
{
    /**
     * Display the Home Page.
     */
    public function index()
    {
        $hero = safeCache('home_hero', 3600, fn() => Hero::first());
        if (!($hero instanceof Hero)) {
            $hero = null;
        }

        $services = safeCache('home_services', 3600, fn() => Service::where('status', 'active')->orderBy('display_order')->get());
        $projects = safeCache('home_projects', 3600, fn() => Project::where('status', 'published')->orderBy('created_at', 'desc')->get());
        $portfolios = safeCache('home_portfolios', 3600, fn() => Portfolio::where('status', 'published')->get());
        $testimonials = safeCache('home_testimonials', 3600, fn() => Testimonial::where('status', 'active')->get());
        $faqs = safeCache('home_faqs', 3600, fn() => Faq::where('status', 'active')->orderBy('display_order')->take(4)->get());
        
        $seo = \App\Support\Seo::forPage('home');

        return view('frontend.index', compact('hero', 'services', 'projects', 'portfolios', 'testimonials', 'faqs', 'seo'));
    }

    /**
     * Display the About Page.
     */
    public function about()
    {
        $about = About::first();
        $team = TeamMember::where('status', 'active')->get();
        
        $seo = \App\Support\Seo::forPage('about');

        return view('frontend.about', compact('about', 'team', 'seo'));
    }

    /**
     * Display the How It Works Page.
     */
    public function howItWorks()
    {
        $faqs = Faq::where('status', 'active')->orderBy('display_order')->get();
        
        $seo = \App\Support\Seo::forPage('how-it-works');

        return view('frontend.how-it-works', compact('faqs', 'seo'));
    }

    /**
     * Display the Library Page.
     */
    public function library()
    {
        if (LibraryBook::count() === 0) {
            $this->seedDefaultLibraryBooks();
        }

        $featuredBooks = LibraryBook::where('status', true)->where('type', 'featured')->orderBy('order', 'asc')->get();
        $shelfBooks = LibraryBook::where('status', true)->where('type', 'shelf')->orderBy('order', 'asc')->get();

        if ($featuredBooks->isEmpty() && $shelfBooks->isEmpty()) {
            $featuredBooks = LibraryBook::where('type', 'featured')->orderBy('order', 'asc')->get();
            $shelfBooks = LibraryBook::where('type', 'shelf')->orderBy('order', 'asc')->get();

            if ($featuredBooks->isEmpty() && $shelfBooks->isEmpty()) {
                LibraryBook::truncate();
                $this->seedDefaultLibraryBooks();
                $featuredBooks = LibraryBook::where('type', 'featured')->orderBy('order', 'asc')->get();
                $shelfBooks = LibraryBook::where('type', 'shelf')->orderBy('order', 'asc')->get();
            }
        }
        
        $seo = \App\Support\Seo::forPage('library');

        return view('frontend.library', compact('featuredBooks', 'shelfBooks', 'seo'));
    }

    /**
     * Seed default library books if database table is empty.
     */
    private function seedDefaultLibraryBooks()
    {
        if (LibraryBook::count() > 0) {
            return;
        }

        $books = [
            [
                'title' => 'The First Home',
                'subtitle' => 'A birthday gift for Mansi',
                'type' => 'featured',
                'relation_tag' => 'For a wife',
                'occasion_tag' => 'Birthday',
                'spreads_count' => '15 spreads',
                'read_time' => '8 min read',
                'synopsis' => 'Their first flat had a leaking tap, one steel cup, and a view of every rooftop in the city. For Mansi\'s birthday, her husband turned their first year in their first home into a painted story — the morning chai, the evening walks, the plate of fries they still argue about.',
                'caption' => 'the actual cover — printed, bound, gifted',
                'cover_image' => 'assets/img/book1/cover.webp',
                'back_image' => 'assets/img/book1/back.webp',
                'pages_json' => array_map(function($i) {
                    $num = sprintf('%02d', $i);
                    return ['src' => "assets/img/book1/s{$num}.webp", 'alt' => "The First Home — spread {$i}"];
                }, range(1, 15)),
                'order' => 1,
                'status' => true,
            ],
            [
                'title' => 'Underwater, Together',
                'subtitle' => 'A rakhi gift for Chicky Didi',
                'type' => 'featured',
                'relation_tag' => 'For a sister',
                'occasion_tag' => 'Raksha Bandhan',
                'spreads_count' => '17 spreads',
                'read_time' => '9 min read',
                'synopsis' => 'Two kids, one landline, and a swim class neither of them wanted to attend. This Raksha Bandhan, instead of another gift, a brother bound twenty years of schemes, duets and dance routines into a book for his Chicky Didi — proof that some skills only work in pairs.',
                'caption' => 'the actual cover — a rakhi gift for Chicky Didi',
                'cover_image' => 'assets/img/book2/cover.webp',
                'back_image' => 'assets/img/book2/back.webp',
                'pages_json' => array_map(function($i) {
                    $num = sprintf('%02d', $i);
                    return ['src' => "assets/img/book2/s{$num}.webp", 'alt' => "Underwater, Together — spread {$i}"];
                }, range(1, 17)),
                'order' => 2,
                'status' => true,
            ],
            [
                'title' => 'The Moon Protector',
                'subtitle' => 'For a daughter',
                'type' => 'shelf',
                'relation_tag' => 'For a daughter · on the loom',
                'synopsis' => 'A bedtime adventure for the girl who asked if the moon follows her home.',
                'cover_image' => 'assets/img/spread-under-stars.webp',
                'order' => 3,
                'status' => true,
            ],
            [
                'title' => 'Letters From Grandma',
                'subtitle' => 'For a grandmother',
                'type' => 'shelf',
                'relation_tag' => 'For a grandmother · on the loom',
                'synopsis' => 'Sixty years of recipes, prayers, and Sunday letters, finally bound.',
                'cover_image' => 'assets/img/spread-street-morning.webp',
                'order' => 4,
                'status' => true,
            ],
            [
                'title' => 'Dad\'s Bicycle',
                'subtitle' => 'For a father',
                'type' => 'shelf',
                'relation_tag' => 'For a father · on the loom',
                'synopsis' => 'Every route he ever pedalled, retold by the boy on the back seat.',
                'cover_image' => 'assets/img/spread-alone-bench.webp',
                'order' => 5,
                'status' => true,
            ],
            [
                'title' => 'Our Little Explorer',
                'subtitle' => 'For a son',
                'type' => 'shelf',
                'relation_tag' => 'For a son · on the loom',
                'synopsis' => 'The first five years of a boy who never once sat still.',
                'cover_image' => 'assets/img/book2-page-dance.webp',
                'order' => 6,
                'status' => true,
            ],
        ];

        foreach ($books as $b) {
            LibraryBook::create($b);
        }
    }

    /**
     * Display the Occasions Page.
     */
    public function occasions()
    {
        $portfolios = safeCache('occasions_portfolios', 3600, fn() => Portfolio::where('status', 'published')->get());
        
        $seo = \App\Support\Seo::forPage('occasions');

        return view('frontend.occasions', compact('portfolios', 'seo'));
    }

    /**
     * Display the Pricing Page.
     */
    public function pricing()
    {
        $plans = safeCache('pricing_plans', 3600, fn() => PricingPlan::where('status', 'active')->get());
        
        $seo = \App\Support\Seo::forPage('pricing');

        return view('frontend.pricing', compact('plans', 'seo'));
    }

    /**
     * Display the FAQ Page.
     */
    public function faq()
    {
        $faqs = safeCache('faq_faqs', 3600, fn() => Faq::where('status', 'active')->orderBy('display_order')->get());
        
        $seo = \App\Support\Seo::forPage('faq');

        return view('frontend.faq', compact('faqs', 'seo'));
    }

    /**
     * Display the Begin Story Form Page.
     */
    public function begin()
    {
        $seo = \App\Support\Seo::forPage('begin');

        return view('frontend.begin', compact('seo'));
    }

    /**
     * Display the Journal / Blog Articles Page.
     */
    public function blog()
    {
        $articles = Blog::where('status', 'published')->orderBy('created_at', 'desc')->paginate(9);

        $seo = \App\Support\Seo::forPage('journal');

        return view('frontend.blog.index', compact('articles', 'seo'));
    }

    /**
     * Display a single Blog Article post.
     */
    public function blogShow($slug)
    {
        $article = Blog::where('slug', $slug)->where('status', 'published')->firstOrFail();

        // Prefer articles from the same category, backfilling with latest published articles if < 3
        $related = Blog::published()
            ->where('id', '!=', $article->id)
            ->where('category', $article->category)
            ->latest()
            ->take(3)
            ->get();

        if ($related->count() < 3) {
            $existingIds = $related->pluck('id')->push($article->id)->toArray();
            $more = Blog::published()
                ->whereNotIn('id', $existingIds)
                ->latest()
                ->take(3 - $related->count())
                ->get();
            $related = $related->concat($more);
        }

        $seo = [
            'title' => ($article->meta_title ?: $article->title) . ' | Storyloom Journal',
            'description' => $article->meta_description ?: $article->short_description,
            'keywords' => $article->keywords,
        ];

        return view('frontend.blog.show', compact('article', 'related', 'seo'));
    }

    /**
     * Send visitors to WhatsApp via our own URL.
     *
     * Nothing published anywhere — the site, an Instagram bio, a business card,
     * a customer's screenshot — should contain the raw number, because the
     * number is going to change once Storyloom has its own line. Everything
     * points at /whatsapp instead, and changing the number is then a single
     * field in Site Settings with no dead links left behind.
     *
     * Deliberately a 302: the destination changes, so it must not be cached.
     */
    public function whatsapp()
    {
        $link = \App\Support\Contact::whatsappLink();

        // No usable number saved. Sending someone to a chat that will never be
        // answered is worse than not offering the link, so fall back to the page
        // that does capture the enquiry.
        return $link === null
            ? redirect()->route('begin')
            : redirect()->away($link);
    }

    /**
     * Handle Contact Message Form Submission.
     */
    public function submitContact(Request $request)
    {
        // We must end up with a way to reach them on the channel they chose,
        // so that field — and only that one — is required.
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'for' => 'required|string|max:255',
            'occasion' => 'nullable|string|max:255',
            'story' => 'required|string',
            'channel' => 'required|string|in:whatsapp,email',
            'email' => 'required_if:channel,email|nullable|email|max:255',
            'phone' => 'required_if:channel,whatsapp|nullable|string|max:255',
        ], [
            'email.required_if' => 'We need your email address to reply there.',
            'phone.required_if' => 'We need your number to reply on WhatsApp.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Map inputs to ContactMessage
        $messageText = "For: " . $request->input('for') . "\n"
                     . "Occasion: " . ($request->input('occasion') ?: 'None') . "\n"
                     . "Preferred channel: " . $request->input('channel') . "\n\n"
                     . "Story:\n" . $request->input('story');

        $contactMessage = ContactMessage::create([
            'name' => $request->input('name'),
            'email' => $request->input('email') ?: 'anonymous@storyloom.in',
            'phone' => $request->input('phone'),
            'subject' => 'New Story Started: For ' . $request->input('for'),
            'message' => $messageText,
        ]);

        // The enquiry is already safe in the dashboard by this point, so a mail
        // problem must never cost us the lead or show the visitor an error.
        try {
            Mail::to(setting('enquiry_notify_email', 'team@storyloombooks.com'))
                ->send(new NewEnquiry($contactMessage, $request->input('channel')));
        } catch (\Throwable $e) {
            Log::error('Enquiry notification email failed', [
                'message_id' => $contactMessage->id,
                'error' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Beautifully begun. Your story starter has been logged.'
        ]);
    }

    /**
     * Handle Newsletter Subscription Form Submission.
     */
    public function subscribeNewsletter(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletter_subscribers,email|max:255',
        ]);

        NewsletterSubscriber::create([
            'email' => $request->input('email'),
        ]);

        return back()->with('newsletter_success', 'Thank you for subscribing to Storyloom updates!');
    }
}
