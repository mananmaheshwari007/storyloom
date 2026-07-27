<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Product;
use App\Models\Faq;
use App\Models\PricingPlan;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\BlogPost;
use App\Models\ContactMessage;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'projects' => Project::count(),
            'products' => Product::count(),
            'faqs' => Faq::count(),
            'pricing_plans' => PricingPlan::count(),
            'services' => Service::count(),
            'testimonials' => Testimonial::count(),
            'blog_posts' => BlogPost::count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
            'subscribers' => NewsletterSubscriber::count()
        ];

        $recentProjects = Project::latest()->take(5)->get();
        $recentMessages = ContactMessage::latest()->take(5)->get();
        $recentBlogs = BlogPost::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentProjects', 'recentMessages', 'recentBlogs'));
    }
}
