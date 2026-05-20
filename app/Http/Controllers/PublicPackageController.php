<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Package;
use App\Models\SiteSetting;

class PublicPackageController extends Controller
{
    public function show($slug)
    {
        $package = Package::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $settings = SiteSetting::pluck('value', 'key')->toArray();

        // SEO Meta overrides for app layout
        $page_title = $package->title;
        $meta_description = \Illuminate\Support\Str::limit(strip_tags($package->description), 160);

        return view('landing.packages.show', compact('package', 'settings', 'page_title', 'meta_description'));
    }
}
