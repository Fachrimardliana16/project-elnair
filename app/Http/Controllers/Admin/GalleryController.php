<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGalleryRequest;
use App\Http\Requests\Admin\UpdateGalleryRequest;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $selectedCategory = $request->input('category');

        $categories = Gallery::whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category')
            ->toArray();

        $galleries = Gallery::when($selectedCategory, fn ($q) => $q->where('category', $selectedCategory))
            ->latest()
            ->paginate(24)
            ->withQueryString();

        return view('admin.gallery.index', compact('galleries', 'categories', 'selectedCategory'));
    }

    public function create()
    {
        $categories = Gallery::whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category')
            ->toArray();

        return view('admin.gallery.create', compact('categories'));
    }

    public function store(StoreGalleryRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = ImageHelper::uploadAndConvert($request->file('image'), 'assets/img/gallery');
        }

        Gallery::create($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item added!');
    }

    public function edit(Gallery $gallery)
    {
        $categories = Gallery::whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category')
            ->toArray();

        return view('admin.gallery.edit', compact('gallery', 'categories'));
    }

    public function update(UpdateGalleryRequest $request, Gallery $gallery)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($gallery->image) {
                Storage::disk('public_root')->delete($gallery->image);
            }
            $data['image'] = ImageHelper::uploadAndConvert($request->file('image'), 'assets/img/gallery');
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
