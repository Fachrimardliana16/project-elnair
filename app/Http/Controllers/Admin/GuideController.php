<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGuideRequest;
use App\Http\Requests\Admin\UpdateGuideRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Guide;

class GuideController extends Controller
{
    public function index()
    {
        $guides = Guide::orderBy('order')->paginate(20);
        return view('admin.guides.index', compact('guides'));
    }

    public function create()
    {
        return view('admin.guides.create');
    }

    public function store(StoreGuideRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = \App\Helpers\ImageHelper::uploadAndConvert($request->file('image'), 'assets/img/guides');
        }

        $data['is_active'] = $request->has('is_active');

        Guide::create($data);
        return redirect()->route('admin.guides.index')->with('success', 'Guide created successfully!');
    }

    public function edit(Guide $guide)
    {
        return view('admin.guides.edit', compact('guide'));
    }

    public function update(UpdateGuideRequest $request, Guide $guide)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($guide->image) {
                Storage::disk('public_root')->delete($guide->image);
            }
            $data['image'] = \App\Helpers\ImageHelper::uploadAndConvert($request->file('image'), 'assets/img/guides');
        }

        $data['is_active'] = $request->has('is_active');

        $guide->update($data);
        return redirect()->route('admin.guides.index')->with('success', 'Guide updated successfully!');
    }

    public function destroy(Guide $guide)
    {
        if ($guide->image) {
            Storage::disk('public_root')->delete($guide->image);
        }
        $guide->delete();
        return back()->with('success', 'Guide deleted successfully!');
    }
}
