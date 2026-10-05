<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->input('sort_order', 0);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('promos', 'public');
            $validated['image'] = 'storage/' . $path;
        }

        if ($request->hasFile('pdf_file')) {
            $path = $request->file('pdf_file')->store('promos/pdf', 'public');
            $validated['pdf_file'] = 'storage/' . $path;
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->input('sort_order', 0);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('promos', 'public');
            $validated['image'] = 'storage/' . $path;
        }

        if ($request->hasFile('pdf_file')) {
            $path = $request->file('pdf_file')->store('promos/pdf', 'public');
            $validated['pdf_file'] = 'storage/' . $path;
        }

        $promo->update($validated);

        return redirect()->route('admin.promos.index')->with('success', 'Promo / Offering berhasil diperbarui!');
    }

    public function destroy(Promo $promo)
    {
        $promo->delete();
        return redirect()->route('admin.promos.index')->with('success', 'Promo / Offering berhasil dihapus!');
    }
}
