<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::all();
        return view('admin.gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'image' => 'required|image|max:2048',
            'category' => 'nullable|string',
        ]);

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

    public function update(Request $request, Gallery $gallery)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'category' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = \App\Helpers\ImageHelper::uploadAndConvert($request->file('image'), 'assets/img/gallery');
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item updated!');
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return back()->with('success', 'Gallery item deleted!');
    }
}
