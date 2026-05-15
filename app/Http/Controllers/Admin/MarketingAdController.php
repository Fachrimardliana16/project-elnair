<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarketingAd;
use Illuminate\Http\Request;

class MarketingAdController extends Controller
{
    public function index()
    {
        $ads = MarketingAd::all();
        return view('admin.ads.index', compact('ads'));
    }

    public function create()
    {
        return view('admin.ads.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'image' => 'required|image|max:2048',
            'link' => 'required|url',
            'is_active' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('assets/img/ads', 'public_root');
        }

        MarketingAd::create($data);

        return redirect()->route('admin.ads.index')->with('success', 'Marketing ad created!');
    }

    public function edit(MarketingAd $ad)
    {
        return view('admin.ads.edit', compact('ad'));
    }

    public function update(Request $request, MarketingAd $ad)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'link' => 'required|url',
            'is_active' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('assets/img/ads', 'public_root');
        }

        $ad->update($data);

        return redirect()->route('admin.ads.index')->with('success', 'Marketing ad updated!');
    }

    public function destroy(MarketingAd $ad)
    {
        $ad->delete();
        return back()->with('success', 'Ad deleted!');
    }
}
