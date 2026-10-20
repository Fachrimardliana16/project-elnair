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
            $data['image'] = \App\Helpers\ImageHelper::uploadAndConvert($request->file('image'), 'assets/img/packages', 82, 1920);
        }

        if ($request->hasFile('itinerary_pdf')) {
            $path = $request->file('itinerary_pdf')->store('packages/pdf', 'public');
            $data['itinerary_pdf'] = 'storage/' . $path;
        }

        if ($request->hasFile('flyer_pdf')) {
            $flyerFile = $request->file('flyer_pdf');
            $flyerExt = strtolower($flyerFile->getClientOriginalExtension());
            if (in_array($flyerExt, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                // Kompres gambar flyer di belakang layar secara otomatis
                $data['flyer_pdf'] = \App\Helpers\ImageHelper::uploadAndConvert($flyerFile, 'assets/img/packages/flyers', 85, 2560);
            } else {
                $path = $flyerFile->store('packages/pdf', 'public');
                $data['flyer_pdf'] = 'storage/' . $path;
            }
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
            $data['image'] = \App\Helpers\ImageHelper::uploadAndConvert($request->file('image'), 'assets/img/packages', 82, 1920);
        }

        if ($request->boolean('delete_itinerary_pdf')) {
            if ($package->itinerary_pdf) {
                Storage::disk('public')->delete(str_replace('storage/', '', $package->itinerary_pdf));
                Storage::disk('public_root')->delete($package->itinerary_pdf);
            }
            $data['itinerary_pdf'] = null;
        } elseif ($request->hasFile('itinerary_pdf')) {
            if ($package->itinerary_pdf) {
                Storage::disk('public')->delete(str_replace('storage/', '', $package->itinerary_pdf));
                Storage::disk('public_root')->delete($package->itinerary_pdf);
            }
            $path = $request->file('itinerary_pdf')->store('packages/pdf', 'public');
            $data['itinerary_pdf'] = 'storage/' . $path;
        }

        if ($request->boolean('delete_flyer_pdf')) {
            if ($package->flyer_pdf) {
                Storage::disk('public')->delete(str_replace('storage/', '', $package->flyer_pdf));
                Storage::disk('public_root')->delete($package->flyer_pdf);
            }
            $data['flyer_pdf'] = null;
        } elseif ($request->hasFile('flyer_pdf')) {
            if ($package->flyer_pdf) {
                Storage::disk('public')->delete(str_replace('storage/', '', $package->flyer_pdf));
                Storage::disk('public_root')->delete($package->flyer_pdf);
            }
            $flyerFile = $request->file('flyer_pdf');
            $flyerExt = strtolower($flyerFile->getClientOriginalExtension());
            if (in_array($flyerExt, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                // Kompres gambar flyer di belakang layar secara otomatis
                $data['flyer_pdf'] = \App\Helpers\ImageHelper::uploadAndConvert($flyerFile, 'assets/img/packages/flyers', 85, 2560);
            } else {
                $path = $flyerFile->store('packages/pdf', 'public');
                $data['flyer_pdf'] = 'storage/' . $path;
            }
        }

        $data['is_active'] = $request->has('is_active');

        $package->update($data);

        Cache::forget('homepage_packages');

        return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully!');
    }

    public function deleteFile(Package $package, string $type)
    {
        if ($type === 'itinerary') {
            if ($package->itinerary_pdf) {
                Storage::disk('public')->delete(str_replace('storage/', '', $package->itinerary_pdf));
                Storage::disk('public_root')->delete($package->itinerary_pdf);
                $package->update(['itinerary_pdf' => null]);
            }
            Cache::forget('homepage_packages');
            return back()->with('success', 'File Itinerary berhasil dihapus.');
        }

        if ($type === 'flyer') {
            if ($package->flyer_pdf) {
                Storage::disk('public')->delete(str_replace('storage/', '', $package->flyer_pdf));
                Storage::disk('public_root')->delete($package->flyer_pdf);
                $package->update(['flyer_pdf' => null]);
            }
            Cache::forget('homepage_packages');
            return back()->with('success', 'File Flyer berhasil dihapus.');
        }

        return back()->with('error', 'Tipe file tidak dikenali.');
    }

    public function destroy(Package $package)
    {
        if ($package->image) {
            Storage::disk('public_root')->delete($package->image);
        }
        if ($package->itinerary_pdf) {
            Storage::disk('public')->delete(str_replace('storage/', '', $package->itinerary_pdf));
            Storage::disk('public_root')->delete($package->itinerary_pdf);
        }
        if ($package->flyer_pdf) {
            Storage::disk('public')->delete(str_replace('storage/', '', $package->flyer_pdf));
            Storage::disk('public_root')->delete($package->flyer_pdf);
        }
        $package->delete();
        Cache::forget('homepage_packages');
        return back()->with('success', 'Package deleted successfully!');
    }
}
