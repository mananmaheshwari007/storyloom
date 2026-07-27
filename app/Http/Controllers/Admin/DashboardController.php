<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Product;
use App\Models\Faq;
use App\Models\PricingPlan;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Blog;
use App\Models\ContactMessage;
use App\Models\NewsletterSubscriber;

class DashboardController extends Controller
{
    /**
     * Display the Admin Dashboard.
     */
    public function index()
    {
        $stats = [
            'total_projects' => Project::count(),
            'total_products' => Product::count(),
            'total_faqs' => Faq::count(),
            'total_pricing_plans' => PricingPlan::count(),
            'total_services' => Service::count(),
            'total_testimonials' => Testimonial::count(),
            'total_blogs' => Blog::count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
        ];

        $latest_messages = ContactMessage::orderBy('created_at', 'desc')->take(5)->get();
        $latest_blogs = Blog::orderBy('created_at', 'desc')->take(5)->get();
        $latest_projects = Project::orderBy('created_at', 'desc')->take(5)->get();
        $latest_subscribers = NewsletterSubscriber::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'stats', 
            'latest_messages', 
            'latest_blogs', 
            'latest_projects',
            'latest_subscribers'
        ));
    }
}
