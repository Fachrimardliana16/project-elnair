<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Http\Requests\Admin\StoreGalleryRequest;
use App\Http\Requests\Admin\UpdateGalleryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->paginate(24);
        return view('admin.gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(StoreGalleryRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = \App\Helpers\ImageHelper::uploadAndConvert($request->file('image'), 'assets/img/gallery');
        }

        Gallery::create($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item added!');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(UpdateGalleryRequest $request, Gallery $gallery)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($gallery->image) {
                Storage::disk('public_root')->delete($gallery->image);
            }
            $data['image'] = \App\Helpers\ImageHelper::uploadAndConvert($request->file('image'), 'assets/img/gallery');
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item updated!');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->image) {
            Storage::disk('public_root')->delete($gallery->image);
        }
        $gallery->delete();
        return back()->with('success', 'Gallery item deleted!');
    }
}
