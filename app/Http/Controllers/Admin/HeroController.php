<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreHeroRequest;
use App\Models\HeroSetting;
use Illuminate\Http\Request;

class HeroController extends Controller
{
    public function index()
    {
        $hero = HeroSetting::first();
        return view('admin.hero.index', compact('hero'));
    }

    public function update(StoreHeroRequest $request)
    {
        $hero = HeroSetting::first() ?? new HeroSetting();
        
        $data = $request->validated();

        if ($request->hasFile('background_image')) {
            $data['background_image'] = \App\Helpers\ImageHelper::uploadAndConvert($request->file('background_image'), 'assets/img');
        }
        if ($request->hasFile('background_image_2')) {
            $data['background_image_2'] = \App\Helpers\ImageHelper::uploadAndConvert($request->file('background_image_2'), 'assets/img');
        }
        if ($request->hasFile('background_image_3')) {
            $data['background_image_3'] = \App\Helpers\ImageHelper::uploadAndConvert($request->file('background_image_3'), 'assets/img');
        }

        $hero->fill($data);
        $hero->save();

        return back()->with('success', 'Hero section updated successfully!');
    }
}
