<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSetting;
use Illuminate\Http\Request;

class HeroController extends Controller
{
    public function index()
    {
        $hero = HeroSetting::first();
        return view('admin.hero.index', compact('hero'));
    }

    public function update(Request $request)
    {
        $hero = HeroSetting::first() ?? new HeroSetting();
        
        $data = $request->validate([
            'tagline' => 'nullable|string',
            'title' => 'required|string',
            'subtitle' => 'nullable|string',
            'btn_primary_text' => 'nullable|string',
            'btn_primary_url' => 'nullable|string',
            'btn_secondary_text' => 'nullable|string',
            'btn_secondary_url' => 'nullable|string',
            'background_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('background_image')) {
            $data['background_image'] = \App\Helpers\ImageHelper::uploadAndConvert($request->file('background_image'), 'assets/img');
        }

        $hero->fill($data);
        $hero->save();

        return back()->with('success', 'Hero section updated successfully!');
    }
}
