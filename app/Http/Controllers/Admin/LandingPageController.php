<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LandingPageController extends Controller
{
    public function index()
    {
        $pages = LandingPage::all();
        return view('admin.landing-pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.landing-pages.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'nullable|string',
            'custom_wa_number' => 'nullable|string',
            'custom_wa_message' => 'nullable|string',
            'hero_image' => 'nullable|image|max:2048',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ]);

        $data['slug'] = Str::slug($data['title']);
        
        if ($request->hasFile('hero_image')) {
            $data['hero_image'] = \App\Helpers\ImageHelper::uploadAndConvert($request->file('hero_image'), 'assets/img/landing');
        }

        LandingPage::create($data);

        return redirect()->route('admin.landing-pages.index')->with('success', 'Landing page created!');
    }

    public function edit(LandingPage $landingPage)
    {
        return view('admin.landing-pages.edit', compact('landingPage'));
    }

    public function update(Request $request, LandingPage $landingPage)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'nullable|string',
            'custom_wa_number' => 'nullable|string',
            'custom_wa_message' => 'nullable|string',
            'hero_image' => 'nullable|image|max:2048',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ]);

        $data['slug'] = Str::slug($data['title']);

        if ($request->hasFile('hero_image')) {
            $data['hero_image'] = \App\Helpers\ImageHelper::uploadAndConvert($request->file('hero_image'), 'assets/img/landing');
        }

        $landingPage->update($data);

        return redirect()->route('admin.landing-pages.index')->with('success', 'Landing page updated!');
    }

    public function destroy(LandingPage $landingPage)
    {
        $landingPage->delete();
        return back()->with('success', 'Landing page deleted!');
    }
}
