<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePackageRequest;
use App\Http\Requests\Admin\UpdatePackageRequest;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $packages = Package::when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->latest()->paginate(20)->withQueryString();
        return view('admin.packages.index', compact('packages', 'search'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(StorePackageRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = \Illuminate\Support\Str::slug($data['title']) . '-' . uniqid();

        if ($request->hasFile('image')) {
            $data['image'] = \App\Helpers\ImageHelper::uploadAndConvert($request->file('image'), 'assets/img/packages');
        }

        $data['is_active'] = $request->has('is_active');

        Package::create($data);

        Cache::forget('homepage_packages');

        return redirect()->route('admin.packages.index')->with('success', 'Package created successfully!');
    }

    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(UpdatePackageRequest $request, Package $package)
    {
        $data = $request->validated();

        $data['slug'] = \Illuminate\Support\Str::slug($data['title']) . '-' . uniqid();

        if ($request->hasFile('image')) {
            if ($package->image) {
                Storage::disk('public_root')->delete($package->image);
            }
            $data['image'] = \App\Helpers\ImageHelper::uploadAndConvert($request->file('image'), 'assets/img/packages');
        }

        $data['is_active'] = $request->has('is_active');

        $package->update($data);

        Cache::forget('homepage_packages');

        return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully!');
    }

    public function destroy(Package $package)
    {
        if ($package->image) {
            Storage::disk('public_root')->delete($package->image);
        }
        $package->delete();
        Cache::forget('homepage_packages');
        return back()->with('success', 'Package deleted successfully!');
    }
}
