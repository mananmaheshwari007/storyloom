<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\HeroController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PricingController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\MediaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/how-it-works', [FrontendController::class, 'howItWorks'])->name('how-it-works');
Route::get('/library', [FrontendController::class, 'library'])->name('library');
Route::get('/occasions', [FrontendController::class, 'occasions'])->name('occasions');
Route::get('/pricing', [FrontendController::class, 'pricing'])->name('pricing');
Route::get('/faq', [FrontendController::class, 'faq'])->name('faq');
Route::get('/begin', [FrontendController::class, 'begin'])->name('begin');

// Blog frontend routes
Route::get('/blog', [FrontendController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [FrontendController::class, 'blogPost'])->name('blog.show');
Route::get('/projects/{slug}', [FrontendController::class, 'project'])->name('projects.show');

// Contact Form & Newsletter submissions
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');

// XML Sitemap & Robots.txt
Route::get('/sitemap.xml', [FrontendController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [FrontendController::class, 'robots'])->name('robots');


/*
|--------------------------------------------------------------------------
| Admin & Breeze Dashboard Redirects
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', function () {
    return redirect()->route('login');
});

Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
});

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Panel Routes
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Core settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
    
    Route::get('/hero', function () { return redirect(route('admin.settings') . '#home'); })->name('hero');
    Route::put('/hero', [SettingController::class, 'update'])->name('hero.update');
    
    Route::get('/about', function () { return redirect(route('admin.settings') . '#about'); })->name('about');
    Route::put('/about', [SettingController::class, 'update'])->name('about.update');

    // Dynamic modules CRUD resources
    Route::resource('services', ServiceController::class)->except(['show']);
    Route::resource('projects', ProjectController::class);
    Route::resource('portfolio', PortfolioController::class)->except(['show']);
    Route::resource('products', ProductController::class);
    Route::resource('pricing', PricingController::class);
    Route::resource('faqs', FaqController::class)->except(['show']);
    Route::resource('testimonials', TestimonialController::class)->except(['show']);
    Route::resource('team', TeamMemberController::class)->except(['show']);
    Route::resource('blog', BlogController::class);

    // Library Manager with reordering
    Route::post('/library/reorder', [App\Http\Controllers\Admin\LibraryController::class, 'reorder'])->name('library.reorder');
    Route::resource('library', App\Http\Controllers\Admin\LibraryController::class);

    // Contact messages lead log
    Route::resource('messages', ContactMessageController::class)->only(['index', 'show', 'destroy']);
    
    // Newsletter export & delete list
    Route::get('/subscribers/export', [SubscriberController::class, 'exportCsv'])->name('subscribers.export');
    Route::get('/subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');
    Route::delete('/subscribers/{subscriber}', [SubscriberController::class, 'destroy'])->name('subscribers.destroy');

    // Media Manager
    Route::get('/media', [MediaController::class, 'index'])->name('media');
    Route::post('/media', [MediaController::class, 'store'])->name('media.store');
    Route::delete('/media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');
});

require __DIR__.'/auth.php';
