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
use App\Models\ContactMessage;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{
    /**
     * Display the Home Page.
     */
    public function home()
    {
        $hero = Hero::first();
        $services = Service::where('status', 'active')->orderBy('display_order')->get();
        $projects = Project::where('status', 'published')->orderBy('created_at', 'desc')->get();
        $portfolios = Portfolio::where('status', 'published')->get();
        $testimonials = Testimonial::where('status', 'active')->get();
        $faqs = Faq::where('status', 'active')->orderBy('display_order')->take(4)->get();
        
        $seo = [
            'title' => setting('seo_title', 'Storyloom — The Story Only You Could Give'),
            'description' => setting('seo_description'),
            'keywords' => setting('seo_keywords'),
        ];

        return view('frontend.home', compact('hero', 'services', 'projects', 'portfolios', 'testimonials', 'faqs', 'seo'));
    }

    public function index()
    {
        return $this->home();
    }

    /**
     * Display the About Page.
     */
    public function about()
    {
        $about = About::first();
        $team = TeamMember::where('status', 'active')->get();
        
        $seo = [
            'title' => 'About Storyloom — Our Mission & Craftsmanship',
            'description' => 'Learn how Storyloom weaves family memories into handbound, illustrated keepsake books crafted by master artisans in India.',
        ];

        return view('frontend.about', compact('about', 'team', 'seo'));
    }

    /**
     * Display the How It Works Page.
     */
    public function howItWorks()
    {
        $faqs = Faq::where('status', 'active')->orderBy('display_order')->get();
        
        $seo = [
            'title' => 'How It Works — The Journey of a Storyloom',
            'description' => 'From sharing a single memory to reviewing hand-painted spreads, learn the step-by-step process of crafting your keepsake book.',
        ];

        return view('frontend.how-it-works', compact('faqs', 'seo'));
    }

    /**
     * Display the Library Page.
     */
    public function library()
    {
        $projects = Project::where('status', 'published')->orderBy('created_at', 'desc')->get();
        $featuredBooks = \App\Models\LibraryBook::where('status', true)->where('type', 'featured')->orderBy('order', 'asc')->get();
        $shelf = \App\Models\LibraryBook::where('status', true)->where('type', 'shelf')->orderBy('order', 'asc')->get();
        if ($shelf->isEmpty()) {
            $shelf = Portfolio::where('status', 'published')->get();
        }
        
        $seo = [
            'title' => 'Read a Storyloom — Illustrated Keepsake Book Library',
            'description' => 'Explore sample hand-drawn pages, watercolor spreads, and heirloom books created from real family memories.',
        ];

        return view('frontend.library', compact('projects', 'featuredBooks', 'shelf', 'seo'));
    }

    /**
     * Display the Occasions Page.
     */
    public function occasions()
    {
        $portfolios = Portfolio::where('status', 'published')->get();
        
        $seo = [
            'title' => 'Gifting Occasions — Keepsakes for Milestones',
            'description' => 'Personalised books for anniversaries, Mother\'s Day, Father\'s Day, weddings, retirements, birthdays, and farewelling loved ones.',
        ];

        return view('frontend.occasions', compact('portfolios', 'seo'));
    }

    /**
     * Display the Pricing Page.
     */
    public function pricing()
    {
        $plans = PricingPlan::where('status', 'active')->get();
        
        $seo = [
            'title' => 'Pricing & Book Formats — Storyloom',
            'description' => 'Compare our Keepsake and Heirloom custom book editions. Clear pricing for handbound, illustrated storytelling.',
        ];

        return view('frontend.pricing', compact('plans', 'seo'));
    }

    /**
     * Display the FAQ Page.
     */
    public function faq()
    {
        $faqs = Faq::where('status', 'active')->orderBy('display_order')->get();
        
        $seo = [
            'title' => 'Good Questions — FAQ | Storyloom',
            'description' => 'Answers to questions about writing, image references, international shipping, print proof reviews, and pricing packages.',
        ];

        return view('frontend.faq', compact('faqs', 'seo'));
    }

    /**
     * Display the Begin Story Form Page.
     */
    public function begin()
    {
        $seo = [
            'title' => 'Begin Your Story — Start a Storybook | Storyloom',
            'description' => 'Start with one memory. Tell us who the book is for, and we\'ll send a personalized plan, timeline, and quote.',
        ];

        return view('frontend.begin', compact('seo'));
    }

    /**
     * Display the Journal / Blog Articles Page.
     */
    public function blog()
    {
        $posts = Blog::where('status', 'published')->orderBy('created_at', 'desc')->paginate(9);
        $articles = $posts;

        $seo = [
            'title' => 'The Storyloom Journal — Reflections on Memory & Keepsakes',
            'description' => 'Essays, family traditions, memory-keeping ideas, and behind-the-scenes stories from the Storyloom writing and art desk.',
        ];

        return view('frontend.blog', compact('posts', 'articles', 'seo'));
    }

    /**
     * Display a single Blog Article post.
     */
    public function blogPost($slug)
    {
        $post = Blog::where('slug', $slug)->where('status', 'published')->firstOrFail();
        $related = Blog::where('status', 'published')->where('id', '!=', $post->id)->take(3)->get();

        $seo = [
            'title' => ($post->meta_title ?: $post->title) . ' | Storyloom Journal',
            'description' => $post->meta_description ?: $post->short_description,
            'keywords' => $post->keywords ?? null,
        ];

        return view('frontend.blog-detail', compact('post', 'related', 'seo'));
    }

    public function blogShow($slug)
    {
        return $this->blogPost($slug);
    }

    /**
     * Display a single Project detail page.
     */
    public function project($slug)
    {
        $project = Project::where('slug', $slug)->where('status', 'published')->firstOrFail();

        $seo = [
            'title' => $project->title . ' | Storyloom Portfolio',
            'description' => $project->excerpt ?? $project->title,
        ];

        return view('frontend.project-detail', compact('project', 'seo'));
    }

    /**
     * Generate XML Sitemap.
     */
    public function sitemap()
    {
        $posts = Blog::where('status', 'published')->get();
        $projects = Project::where('status', 'published')->get();

        return response()->view('frontend.sitemap', compact('posts', 'projects'))->header('Content-Type', 'text/xml');
    }

    /**
     * Return robots.txt file content.
     */
    public function robots()
    {
        $content = "User-agent: *\nDisallow:\nSitemap: " . url('/sitemap.xml');
        return response($content, 200, ['Content-Type' => 'text/plain']);
    }

    /**
     * Handle Contact Message Form Submission.
     */
    public function submitContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'for' => 'required|string|max:255',
            'occasion' => 'nullable|string|max:255',
            'timeline' => 'nullable|string|max:255',
            'story' => 'required|string',
            'channel' => 'required|string|in:whatsapp,email',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        ContactMessage::create([
            'name' => $request->input('name'),
            'email' => $request->input('email') ?: 'anonymous@storyloom.in',
            'phone' => $request->input('phone'),
            'subject' => 'New Story Started: For ' . $request->input('for'),
            'message' => $request->input('story'),
            'for' => $request->input('for'),
            'occasion' => $request->input('occasion'),
            'timeline' => $request->input('timeline'),
            'channel' => $request->input('channel'),
        ]);

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
