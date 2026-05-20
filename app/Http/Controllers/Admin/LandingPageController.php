<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLandingPageRequest;
use App\Http\Requests\Admin\UpdateLandingPageRequest;
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

    public function store(StoreLandingPageRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = empty($data['slug']) ? Str::slug($data['title']) : Str::slug($data['slug']);
        
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

    public function update(UpdateLandingPageRequest $request, LandingPage $landingPage)
    {
        $data = $request->validated();

        $data['slug'] = empty($data['slug']) ? Str::slug($data['title']) : Str::slug($data['slug']);

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

    public function toggleStatus(LandingPage $landingPage)
    {
        $newStatus = !$landingPage->is_active;

        // Jika diaktifkan, matikan versi halaman lama yang memiliki slug yang sama secara otomatis
        if ($newStatus && !empty($landingPage->slug)) {
            LandingPage::where('slug', $landingPage->slug)
                ->where('id', '!=', $landingPage->id)
                ->update(['is_active' => false]);
        }

        $landingPage->update(['is_active' => $newStatus]);
        return back()->with('success', 'Status Landing Page berhasil diperbarui! Konten versi aktif otomatis dialihkan.');
    }
}
