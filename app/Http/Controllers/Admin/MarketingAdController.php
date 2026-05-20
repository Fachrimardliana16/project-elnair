<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarketingAd;
use App\Http\Requests\Admin\StoreMarketingAdRequest;
use App\Http\Requests\Admin\UpdateMarketingAdRequest;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MarketingAdController extends Controller
{
    public function index()
    {
        $ads = MarketingAd::latest()->paginate(20);
        return view('admin.ads.index', compact('ads'));
    }

    public function create()
    {
        return view('admin.ads.create');
    }

    public function store(StoreMarketingAdRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = ImageHelper::uploadAndConvert($request->file('image'), 'assets/img/ads');
        }

        MarketingAd::create($data);

        return redirect()->route('admin.ads.index')->with('success', 'Marketing ad created!');
    }

    public function edit(MarketingAd $ad)
    {
        return view('admin.ads.edit', compact('ad'));
    }

    public function update(UpdateMarketingAdRequest $request, MarketingAd $ad)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($ad->image) {
                Storage::disk('public_root')->delete($ad->image);
            }
            $data['image'] = ImageHelper::uploadAndConvert($request->file('image'), 'assets/img/ads');
        }

        $ad->update($data);

        return redirect()->route('admin.ads.index')->with('success', 'Marketing ad updated!');
    }

    public function destroy(MarketingAd $ad)
    {
        if ($ad->image) {
            Storage::disk('public_root')->delete($ad->image);
        }
        $ad->delete();
        return back()->with('success', 'Ad deleted!');
    }
}
