<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SiteSetting;
use App\Models\Guide;

class PublicPageController extends Controller
{
    public function about()
    {
        $settings = SiteSetting::pluck('value', 'key')->toArray();
        $guides = Guide::where('is_active', true)->orderBy('order')->get();
        
        $page_title = 'Tentang Kami';
        $meta_description = 'Profil Elnair Travel, Biro Perjalanan Umrah & Haji Khusus Terpercaya dengan layanan Spiritual Luxury.';

        return view('landing.pages.about', compact('settings', 'guides', 'page_title', 'meta_description'));
    }
}
