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
use App\Http\Controllers\PublicLandingPageController;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

Route::get('/', function () {
    $hero = \App\Models\HeroSetting::first();
    $features = \App\Models\Feature::orderBy('order')->get();
    $packages = \App\Models\Package::where('is_active', true)->take(3)->get();
    $testimonials = \App\Models\Testimonial::all();
    $settings = \App\Models\SiteSetting::pluck('value', 'key')->toArray();

    return view('landing.index', compact('hero', 'features', 'packages', 'testimonials', 'settings'));
});

Route::get('/p/{slug}', [PublicLandingPageController::class, 'show'])->name('landing.page');

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

        Route::resource('features', FeatureController::class)->names('features');
        Route::resource('packages', PackageController::class)->names('packages');
        Route::resource('testimonials', TestimonialController::class)->names('testimonials');

        Route::resource('users', UserController::class)->names('users');
        Route::resource('roles', RoleController::class)->names('roles');
        Route::resource('gallery', GalleryController::class)->names('gallery');
        Route::resource('articles', ArticleController::class)->names('articles');
        Route::resource('ads', MarketingAdController::class)->names('ads');
        Route::resource('landing-pages', LandingPageController::class)->names('landing-pages');

        Route::get('/logs', [LogViewerController::class, 'index'])->name('logs');

        Route::get('/settings', [SiteSettingController::class, 'index'])->name('settings');
        Route::post('/settings', [SiteSettingController::class, 'update'])->name('settings.update');
    });
});
