<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\HeroController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PricingPlanController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\MediaManagerController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/how-it-works', [FrontendController::class, 'howItWorks'])->name('how-it-works');
Route::get('/library', [FrontendController::class, 'library'])->name('library');
Route::get('/occasions', [FrontendController::class, 'occasions'])->name('occasions');
Route::get('/pricing', [FrontendController::class, 'pricing'])->name('pricing');
Route::get('/faq', [FrontendController::class, 'faq'])->name('faq');
Route::get('/journal', [FrontendController::class, 'blog'])->name('blog.index');
Route::get('/journal/{slug}', [FrontendController::class, 'blogShow'])->name('blog.show');
Route::get('/journal-dont-get-me-anything', function () {
    return redirect()->route('blog.show', 'what-to-give-the-person-who-says-dont-get-me-anything');
});
Route::get('/journal-dont-get-me-anything.html', function () {
    return redirect()->route('blog.show', 'what-to-give-the-person-who-says-dont-get-me-anything');
});
Route::get('/begin', [FrontendController::class, 'begin'])->name('begin');

/*
 * Crawler files. Served by routes, not as static files in public/, so they ship
 * with every deployment and the sitemap stays in step with what's published.
 */
Route::get('/sitemap.xml', [SitemapController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

Route::post('/contact/submit', [FrontendController::class, 'submitContact'])->name('contact.submit');
Route::post('/newsletter/subscribe', [FrontendController::class, 'subscribeNewsletter'])->name('newsletter.subscribe');

/*
|--------------------------------------------------------------------------
| Authentication Routes (Breeze)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Admin Panel Routes (Protected by Auth)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/clear-cache', [DashboardController::class, 'clearCache'])->name('clear-cache');

    // Journal writer helpers
    Route::post('/blog/upload', [BlogController::class, 'upload'])->name('blog.upload');
    Route::post('/blog/preview', [BlogController::class, 'preview'])->name('blog.preview');
    Route::get('/blog/default-book', [BlogController::class, 'defaultBook'])->name('blog.defaultBook');
    Route::post('/blog/default-book', [BlogController::class, 'updateDefaultBook'])->name('blog.defaultBook.update');

    // Website Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    // Hero Section
    Route::get('/hero', [HeroController::class, 'edit'])->name('hero.edit');
    Route::post('/hero', [HeroController::class, 'update'])->name('hero.update');
    Route::post('/hero/upload-image', [HeroController::class, 'uploadImage'])->name('hero.uploadImage');

    // How It Works Page
    Route::get('/how-it-works', [\App\Http\Controllers\Admin\HowItWorksController::class, 'edit'])->name('how.edit');
    Route::post('/how-it-works', [\App\Http\Controllers\Admin\HowItWorksController::class, 'update'])->name('how.update');

    // About Section
    Route::get('/about', [AboutController::class, 'edit'])->name('about.edit');
    Route::post('/about', [AboutController::class, 'update'])->name('about.update');

    // Begin a Story Page
    Route::get('/begin', [\App\Http\Controllers\Admin\BeginController::class, 'edit'])->name('begin.edit');
    Route::post('/begin', [\App\Http\Controllers\Admin\BeginController::class, 'update'])->name('begin.update');

    // Read a Storyloom (Library)
    Route::post('/library/reorder', [\App\Http\Controllers\Admin\LibraryController::class, 'reorder'])->name('library.reorder');
    Route::post('/library/settings', [\App\Http\Controllers\Admin\LibraryController::class, 'updateSettings'])->name('library.settings');
    Route::resource('library', \App\Http\Controllers\Admin\LibraryController::class);

    // Dynamic CRUD Modules
    Route::post('/services/settings', [ServiceController::class, 'updateSettings'])->name('services.settings');
    Route::resource('services', ServiceController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('portfolio', PortfolioController::class);
    Route::resource('products', ProductController::class);
    Route::post('/pricing/settings', [PricingPlanController::class, 'updateSettings'])->name('pricing.settings');
    Route::resource('pricing', PricingPlanController::class);
    Route::post('/faqs/settings', [FaqController::class, 'updateSettings'])->name('faqs.settings');
    Route::resource('faqs', FaqController::class);
    Route::resource('testimonials', TestimonialController::class);
    Route::resource('team', TeamMemberController::class);
    Route::post('/blog/settings', [BlogController::class, 'updateSettings'])->name('blog.settings');
    Route::resource('blog', BlogController::class);

    // Communications
    Route::get('/messages', [ContactMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [ContactMessageController::class, 'show'])->name('messages.show');
    Route::delete('/messages/{message}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');

    Route::get('/newsletter', [NewsletterController::class, 'index'])->name('newsletter.index');
    Route::delete('/newsletter/{subscriber}', [NewsletterController::class, 'destroy'])->name('newsletter.destroy');
    Route::get('/newsletter/export', [NewsletterController::class, 'export'])->name('newsletter.export');

    // Media Manager
    Route::get('/media', [MediaManagerController::class, 'index'])->name('media.index');
    Route::post('/media', [MediaManagerController::class, 'store'])->name('media.store');
    Route::delete('/media', [MediaManagerController::class, 'destroy'])->name('media.destroy');
});
