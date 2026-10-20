<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::orderBy('sort_order', 'asc')->orderBy('created_at', 'desc')->get();
        return view('admin.promos.index', compact('promos'));
    }

    public function create()
    {
        return view('admin.promos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'badge' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'details' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif',
            'pdf_file' => 'nullable|file|mimes:pdf',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->input('sort_order', 0);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('promos', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            $validated['pdf_file'] = $request->file('pdf_file')->store('promos/pdf', 'public');
        }

        Promo::create($validated);

        return redirect()->route('admin.promos.index')->with('success', 'Promo / Offering berhasil ditambahkan!');
    }

    public function edit(Promo $promo)
    {
        return view('admin.promos.edit', compact('promo'));
    }

    public function update(Request $request, Promo $promo)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'badge' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'details' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif',
            'pdf_file' => 'nullable|file|mimes:pdf',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->input('sort_order', 0);

        if ($request->hasFile('image')) {
            $this->deleteStoredFile($promo->image);
            $validated['image'] = $request->file('image')->store('promos', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            $this->deleteStoredFile($promo->pdf_file);
            $validated['pdf_file'] = $request->file('pdf_file')->store('promos/pdf', 'public');
        }

        $promo->update($validated);

        return redirect()->route('admin.promos.index')->with('success', 'Promo / Offering berhasil diperbarui!');
    }

    public function destroy(Promo $promo)
    {
        $this->deleteStoredFile($promo->image);
        $this->deleteStoredFile($promo->pdf_file);
        $promo->delete();
        return redirect()->route('admin.promos.index')->with('success', 'Promo / Offering berhasil dihapus!');
    }

    private function deleteStoredFile(?string $path): void
    {
        if (! $path) {
            return;
        }

        $path = ltrim($path, '/');
        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, 8);
        }

        Storage::disk('public')->delete($path);
    }
}
