<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Package;
use App\Models\SiteSetting;

class PublicPackageController extends Controller
{
    public function index()
    {
        $packages = Package::where('is_active', true)->paginate(6);
        $settings = SiteSetting::pluck('value', 'key')->toArray();
        
        $page_title = 'Daftar Paket Haji & Umroh';
        $meta_description = 'Pilihan paket haji dan umroh terbaik untuk menemani perjalanan ibadah Anda.';

        return view('landing.packages.index', compact('packages', 'settings', 'page_title', 'meta_description'));
    }

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
