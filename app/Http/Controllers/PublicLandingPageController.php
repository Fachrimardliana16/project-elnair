<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class PublicLandingPageController extends Controller
{
    public function show($slug)
    {
        $page = LandingPage::where('slug', $slug)->firstOrFail();
        $settings = SiteSetting::pluck('value', 'key')->toArray();

        return view('landing.page', compact('page', 'settings'));
    }
}
