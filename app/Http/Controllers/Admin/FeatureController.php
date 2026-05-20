<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreFeatureRequest;
use App\Http\Requests\Admin\UpdateFeatureRequest;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FeatureController extends Controller
{
    public function index()
    {
        $features = Feature::orderBy('order')->get();
        return view('admin.features.index', compact('features'));
    }

    public function create()
    {
        return view('admin.features.create');
    }

    public function store(StoreFeatureRequest $request)
    {
        $data = $request->validated();

        Feature::create($data);

        Cache::forget('homepage_features');

        return redirect()->route('admin.features.index')->with('success', 'Feature added!');
    }

    public function edit(Feature $feature)
    {
        return view('admin.features.edit', compact('feature'));
    }

    public function update(UpdateFeatureRequest $request, Feature $feature)
    {
        $data = $request->validated();

        $feature->update($data);

        Cache::forget('homepage_features');

        return redirect()->route('admin.features.index')->with('success', 'Feature updated!');
    }

    public function destroy(Feature $feature)
    {
        $feature->delete();
        Cache::forget('homepage_features');
        return back()->with('success', 'Feature deleted!');
    }
}
