<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartureScheduleController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\GuideController;
use App\Http\Controllers\Admin\HeroController;
use App\Http\Controllers\Admin\JamaahController;
use App\Http\Controllers\Admin\LandingPageController;
use App\Http\Controllers\Admin\LandingPageLeadController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\MarketingAdController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\JemaahAuthController;
use App\Http\Controllers\JemaahDashboardController;
use App\Http\Controllers\PublicArticleController;
use App\Http\Controllers\PublicHomeController;
use App\Http\Controllers\PublicJamaahController;
use App\Http\Controllers\PublicLandingPageController;
use App\Http\Controllers\PublicPackageController;
use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', [SitemapController::class, 'index']);

Route::get('/', [PublicHomeController::class, 'index'])->name('home');

Route::get('/p/{slug}', [PublicLandingPageController::class, 'show'])->name('landing.page');
Route::get('/p/{slug}/whatsapp-redirect', [PublicLandingPageController::class, 'whatsappRedirect'])->name('landing.whatsapp-redirect');
Route::post('/p/{slug}/lead', [PublicLandingPageController::class, 'storeLead'])->middleware('throttle:5,1')->name('landing.store-lead');
Route::get('/paket', [PublicPackageController::class, 'index'])->name('paket.index');
Route::get('/paket/{slug}', [PublicPackageController::class, 'show'])->name('paket.show');
Route::get('/jadwal', [App\Http\Controllers\PublicScheduleController::class, 'index'])->name('jadwal.index');
Route::get('/jadwal/{id}', [App\Http\Controllers\PublicScheduleController::class, 'show'])->name('jadwal.show');
Route::get('/tentang-kami', [PublicPageController::class, 'about'])->name('about');
Route::get('/artikel', [PublicArticleController::class, 'index'])->name('artikel.index');
Route::get('/artikel/{slug}', [PublicArticleController::class, 'show'])->name('artikel.show');
Route::get('/pendaftaran', [PublicJamaahController::class, 'create'])->name('pendaftaran.create');
Route::post('/pendaftaran', [PublicJamaahController::class, 'store'])->name('pendaftaran.store');

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

        Route::resource('guides', GuideController::class)->names('guides');

        Route::resource('features', FeatureController::class)->names('features');
        Route::resource('packages', PackageController::class)->names('packages');
        Route::resource('schedules', DepartureScheduleController::class)->names('schedules');
        Route::resource('testimonials', TestimonialController::class)->names('testimonials');

        Route::resource('users', UserController::class)->names('users');
        Route::resource('roles', RoleController::class)->names('roles');
        Route::resource('gallery', GalleryController::class)->names('gallery');
        Route::resource('articles', ArticleController::class)->names('articles');
        Route::resource('ads', MarketingAdController::class)->names('ads');
        Route::resource('jamaahs', JamaahController::class)->names('jamaahs');
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

        Route::get('/logs', [LogController::class, 'index'])->name('logs');
        Route::delete('/logs', [LogController::class, 'clear'])->name('logs.clear');

        Route::get('/settings', [SiteSettingController::class, 'index'])->name('settings');
        Route::post('/settings', [SiteSettingController::class, 'update'])->name('settings.update');

        Route::get('/marketing-settings', [SiteSettingController::class, 'marketingIndex'])->name('marketing-settings');
        Route::post('/marketing-settings', [SiteSettingController::class, 'marketingUpdate'])->name('marketing-settings.update');

        // ERP & CRM Jamaah Routes
        // Groups (Rombongan)
        Route::resource('groups', GroupController::class)->names('groups');
        Route::post('groups/{group}/add-jamaah', [GroupController::class, 'addJamaah'])->name('groups.add-jamaah');
        Route::delete('groups/{group}/remove-jamaah/{jamaah}', [GroupController::class, 'removeJamaah'])->name('groups.remove-jamaah');
        Route::post('groups/{group}/update-flight', [GroupController::class, 'updateFlight'])->name('groups.update-flight');
        Route::post('groups/{group}/add-room', [GroupController::class, 'addRoom'])->name('groups.add-room');
        Route::post('groups/{group}/assign-room', [GroupController::class, 'assignRoomMember'])->name('groups.assign-room');
        Route::delete('groups/{group}/remove-room-member/{member}', [GroupController::class, 'removeRoomMember'])->name('groups.remove-room-member');
        Route::delete('groups/{group}/destroy-room/{room}', [GroupController::class, 'destroyRoom'])->name('groups.destroy-room');
        Route::get('groups/{group}/export-manifest', [GroupController::class, 'exportManifest'])->name('groups.export-manifest');
        Route::post('groups/{group}/auto-rooms', [GroupController::class, 'autoRooms'])->name('groups.auto-rooms');
        Route::post('groups/{group}/move-room', [GroupController::class, 'moveRoomMember'])->name('groups.move-room');

        // Payments (Cicilan & Outstanding)
        Route::resource('payments', PaymentController::class)->names('payments');
        Route::post('payments/{payment}/status', [PaymentController::class, 'updateStatus'])->name('payments.status');
        Route::get('payments/{payment}/invoice', [PaymentController::class, 'exportInvoice'])->name('payments.export-invoice');

        // Documents (Vaksin, Foto, Passport Warning, Visa)
        Route::get('documents', [DocumentController::class, 'index'])->name('documents.index');
        Route::get('documents/{jamaah}', [DocumentController::class, 'show'])->name('documents.show');
        Route::post('documents/{jamaah}/upload', [DocumentController::class, 'upload'])->name('documents.upload');
        Route::post('documents/{jamaah}/visa', [DocumentController::class, 'updateVisa'])->name('documents.visa');
    });
});

// Jemaah Portal Routes
Route::name('jemaah.')->prefix('jemaah')->group(function () {
    Route::get('/login', [JemaahAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [JemaahAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [JemaahAuthController::class, 'logout'])->name('logout');

    Route::middleware(['jemaah.auth'])->group(function () {
        Route::get('/dashboard', [JemaahDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [JemaahDashboardController::class, 'profile'])->name('profile');
        Route::get('/payments', [JemaahDashboardController::class, 'payments'])->name('payments');
        Route::post('/payments', [JemaahDashboardController::class, 'uploadPayment'])->name('payments.upload');
        Route::get('/documents', [JemaahDashboardController::class, 'documents'])->name('documents');
        Route::post('/documents', [JemaahDashboardController::class, 'uploadDocument'])->name('documents.upload');
    });
});
