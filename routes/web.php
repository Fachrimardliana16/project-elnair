<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HeroController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\MarketingAdController;
use App\Http\Controllers\Admin\LandingPageController;
use App\Http\Controllers\Admin\LandingPageLeadController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\PublicLandingPageController;
use App\Http\Controllers\PublicHomeController;

Route::get('/sitemap.xml', [SitemapController::class, 'index']);

Route::get('/', [PublicHomeController::class, 'index'])->name('home');

Route::get('/p/{slug}', [PublicLandingPageController::class, 'show'])->name('landing.page');
Route::get('/p/{slug}/whatsapp-redirect', [PublicLandingPageController::class, 'whatsappRedirect'])->name('landing.whatsapp-redirect');
Route::post('/p/{slug}/lead', [PublicLandingPageController::class, 'storeLead'])->middleware('throttle:5,1')->name('landing.store-lead');
Route::get('/paket/{slug}', [\App\Http\Controllers\PublicPackageController::class, 'show'])->name('paket.show');
Route::get('/tentang-kami', [\App\Http\Controllers\PublicPageController::class, 'about'])->name('about');
Route::get('/artikel', [\App\Http\Controllers\PublicArticleController::class, 'index'])->name('artikel.index');
Route::get('/artikel/{slug}', [\App\Http\Controllers\PublicArticleController::class, 'show'])->name('artikel.show');

Route::get('/clear-all-cache-temp', function() {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    return 'Cache cleared successfully!';
});

Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
});

// Admin Auth
Route::name('admin.')->prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected Admin Routes
    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::get('/hero', [HeroController::class, 'index'])->name('hero');
        Route::post('/hero', [HeroController::class, 'update'])->name('hero.update');

        Route::resource('guides', \App\Http\Controllers\Admin\GuideController::class)->names('guides');

        Route::resource('features', FeatureController::class)->names('features');
        Route::resource('packages', PackageController::class)->names('packages');
        Route::resource('testimonials', TestimonialController::class)->names('testimonials');

        Route::resource('users', UserController::class)->names('users');
        Route::resource('roles', RoleController::class)->names('roles');
        Route::resource('gallery', GalleryController::class)->names('gallery');
        Route::resource('articles', ArticleController::class)->names('articles');
        Route::resource('ads', MarketingAdController::class)->names('ads');
        Route::resource('landing-pages', LandingPageController::class)->names('landing-pages');
        Route::post('landing-pages/{landing_page}/toggle', [LandingPageController::class, 'toggleStatus'])->name('landing-pages.toggle');
        
        // Leads CRM Routes
        Route::get('landing-page-leads', [LandingPageLeadController::class, 'index'])->name('landing-pages.leads.index');
        Route::post('landing-page-leads/{lead}/status', [LandingPageLeadController::class, 'updateStatus'])->name('landing-pages.leads.status');
        Route::delete('landing-page-leads/{lead}', [LandingPageLeadController::class, 'destroy'])->name('landing-pages.leads.destroy');

        // Marketing ROI API & Spend Routes
        Route::post('landing-page-leads/ad-accounts', [LandingPageLeadController::class, 'storeAdAccount'])->name('landing-pages.leads.store-account');
        Route::post('landing-page-leads/ad-accounts/{account}/toggle', [LandingPageLeadController::class, 'toggleAdAccount'])->name('landing-pages.leads.toggle-account');
        Route::delete('landing-page-leads/ad-accounts/{account}', [LandingPageLeadController::class, 'destroyAdAccount'])->name('landing-pages.leads.destroy-account');
        Route::post('landing-page-leads/ad-accounts/sync', [LandingPageLeadController::class, 'syncAdMetrics'])->name('landing-pages.leads.sync-accounts');
        Route::post('landing-page-leads/manual-spend', [LandingPageLeadController::class, 'storeManualSpend'])->name('landing-pages.leads.store-manual-spend');
        Route::delete('landing-page-leads/manual-spend/{report}', [LandingPageLeadController::class, 'destroyManualSpend'])->name('landing-pages.leads.destroy-manual-spend');
        Route::get('landing-page-leads/export-pdf', [LandingPageLeadController::class, 'exportPDF'])->name('landing-pages.leads.export-pdf');
        Route::get('landing-page-leads/export-csv', [LandingPageLeadController::class, 'exportCSV'])->name('landing-pages.leads.export-csv');

        Route::get('/logs', [\App\Http\Controllers\Admin\LogController::class, 'index'])->name('logs');
        Route::delete('/logs', [\App\Http\Controllers\Admin\LogController::class, 'clear'])->name('logs.clear');

        Route::get('/settings', [SiteSettingController::class, 'index'])->name('settings');
        Route::post('/settings', [SiteSettingController::class, 'update'])->name('settings.update');

        Route::get('/marketing-settings', [SiteSettingController::class, 'marketingIndex'])->name('marketing-settings');
        Route::post('/marketing-settings', [SiteSettingController::class, 'marketingUpdate'])->name('marketing-settings.update');
    });
});
