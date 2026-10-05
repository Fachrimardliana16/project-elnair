<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PublicPromoController extends Controller
{
    /**
     * Display all active promos.
     */
    public function index()
    {
        $promos = Promo::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('landing.promo.index', compact('promos'));
    }

    /**
     * Show detailed page for a specific promo / offering.
     */
    public function show($slug)
    {
        $promo = Promo::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $otherPromos = Promo::where('id', '!=', $promo->id)
            ->where('is_active', true)
            ->take(3)
            ->get();

        $settings = Cache::remember('homepage_settings', 300, fn () => SiteSetting::pluck('value', 'key')->toArray());

        return view('landing.promo.show', compact('promo', 'otherPromos', 'settings'));
    }
}
