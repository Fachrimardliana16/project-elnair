<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Article;
use App\Models\LandingPage;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $packages = Package::where('is_active', true)->get();
        // Assuming Article and LandingPage models exist based on previous grep
        $articles = [];
        if (class_exists('\App\Models\Article')) {
            $articles = \App\Models\Article::all();
        }
        $landingPages = LandingPage::all();

        return response()->view('public.sitemap', [
            'packages' => $packages,
            'articles' => $articles,
            'landingPages' => $landingPages,
        ])->header('Content-Type', 'text/xml');
    }
}
