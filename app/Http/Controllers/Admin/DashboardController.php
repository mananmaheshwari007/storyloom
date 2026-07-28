<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LibraryBook;
use App\Models\Project;
use App\Models\Product;
use App\Models\Faq;
use App\Models\PricingPlan;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Blog;
use App\Models\ContactMessage;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Artisan;

class DashboardController extends Controller
{
    /**
     * Display the Admin Dashboard.
     */
    public function index()
    {
        $totalBooks = class_exists(LibraryBook::class) ? LibraryBook::count() : Project::count();
        $publishedBooks = class_exists(LibraryBook::class) ? LibraryBook::where('status', 'published')->count() : Project::where('status', 'published')->count();
        
        $stats = [
            'total_books' => $totalBooks,
            'published_books' => $publishedBooks,
            'draft_books' => max(0, $totalBooks - $publishedBooks),
            'total_projects' => Project::count(),
            'total_products' => Product::count(),
            'total_faqs' => Faq::count(),
            'total_pricing_plans' => PricingPlan::count(),
            'total_services' => Service::count(),
            'total_testimonials' => Testimonial::count(),
            'total_blogs' => Blog::count(),
            'published_blogs' => Blog::where('status', 'published')->count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
            'total_messages' => ContactMessage::count(),
            'total_subscribers' => NewsletterSubscriber::count(),
            'ga_id' => setting('google_analytics_id', 'G-1V87JW7B54'),
        ];

        $latest_books = class_exists(LibraryBook::class) 
            ? LibraryBook::orderBy('created_at', 'desc')->take(5)->get()
            : Project::orderBy('created_at', 'desc')->take(5)->get();

        $latest_messages = ContactMessage::orderBy('created_at', 'desc')->take(5)->get();
        $latest_blogs = Blog::orderBy('created_at', 'desc')->take(5)->get();
        $latest_projects = Project::orderBy('created_at', 'desc')->take(5)->get();
        $latest_subscribers = NewsletterSubscriber::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'stats', 
            'latest_books',
            'latest_messages', 
            'latest_blogs', 
            'latest_projects',
            'latest_subscribers'
        ));
    }

    /**
     * 1-Click Clear Application and View Cache
     */
    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            return redirect()->back()->with('success', 'Application and view cache cleared successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Cache clear error: ' . $e->getMessage());
        }
    }
}
