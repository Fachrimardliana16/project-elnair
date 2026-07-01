<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\GalleryFolder;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $selectedFolder = $request->input('folder_id');

        $folders = GalleryFolder::withCount('items')->latest('id')->get();

        $galleries = GalleryItem::with('folder')
            ->when($selectedFolder, fn ($q) => $q->where('gallery_folder_id', $selectedFolder))
            ->latest()
            ->paginate(24)
            ->withQueryString();

        return view('admin.gallery.index', compact('galleries', 'folders', 'selectedFolder'));
    }

    public function create()
    {
        $folders = GalleryFolder::oldest('id')->get();
        return view('admin.gallery.create', compact('folders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'             => 'required|string|max:255',
            'image'             => 'required|image|max:2048',
            'folder_id'         => 'nullable|exists:gallery_folders,id',
            'new_folder_name'   => 'nullable|string|max:100',
        ]);

        // Tentukan folder
        if ($request->filled('new_folder_name')) {
            $name = trim($request->new_folder_name);
            $folder = GalleryFolder::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        } elseif ($request->filled('folder_id')) {
            $folder = GalleryFolder::findOrFail($request->folder_id);
        } else {
            return back()->withErrors(['folder_id' => 'Pilih album atau buat album baru.'])->withInput();
        }

        $imagePath = ImageHelper::uploadAndConvert($request->file('image'), 'assets/img/gallery');

        GalleryItem::create([
            'gallery_folder_id' => $folder->id,
            'title'             => $request->title,
            'image'             => $imagePath,
        ]);

        return redirect()->route('admin.gallery.index')->with('success', 'Foto berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $gallery = GalleryItem::with('folder')->findOrFail($id);
        $folders = GalleryFolder::oldest('id')->get();
        return view('admin.gallery.edit', compact('gallery', 'folders'));
    }

    public function update(Request $request, $id)
    {
        $gallery = GalleryItem::findOrFail($id);

        $request->validate([
            'title'             => 'required|string|max:255',
            'image'             => 'nullable|image|max:2048',
            'folder_id'         => 'nullable|exists:gallery_folders,id',
            'new_folder_name'   => 'nullable|string|max:100',
        ]);

        // Tentukan folder
        if ($request->filled('new_folder_name')) {
            $name = trim($request->new_folder_name);
            $folder = GalleryFolder::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        } elseif ($request->filled('folder_id')) {
            $folder = GalleryFolder::findOrFail($request->folder_id);
        } else {
            $folder = $gallery->folder;
        }

        if ($request->hasFile('image')) {
            if ($gallery->image && !str_starts_with($gallery->image, 'http')) {
                Storage::disk('public_root')->delete($gallery->image);
            }
            $gallery->image = ImageHelper::uploadAndConvert($request->file('image'), 'assets/img/gallery');
        }

        $gallery->gallery_folder_id = $folder->id;
        $gallery->title = $request->title;
        $gallery->save();

        return redirect()->route('admin.gallery.index')->with('success', 'Foto berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $gallery = GalleryItem::findOrFail($id);
        if ($gallery->image && !str_starts_with($gallery->image, 'http')) {
            Storage::disk('public_root')->delete($gallery->image);
        }
        $gallery->delete();

        return back()->with('success', 'Foto berhasil dihapus!');
    }
}
