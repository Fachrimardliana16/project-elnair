<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Package;
use App\Models\SiteSetting;

class PublicPackageController extends Controller
{
    public function index()
    {
        $packages = Package::where('is_active', true)->paginate(6);
        $settings = SiteSetting::pluck('value', 'key')->toArray();
        
        $page_title = 'Daftar Paket Haji & Umroh';
        $meta_description = 'Pilihan paket haji dan umroh terbaik untuk menemani perjalanan ibadah Anda.';

        return view('landing.packages.index', compact('packages', 'settings', 'page_title', 'meta_description'));
    }

    public function show($slug)
    {
        $package = Package::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $settings = SiteSetting::pluck('value', 'key')->toArray();

        // SEO Meta overrides for app layout
        $page_title = $package->title;
        $meta_description = \Illuminate\Support\Str::limit(strip_tags($package->description), 160);

        return view('landing.packages.show', compact('package', 'settings', 'page_title', 'meta_description'));
    }

    public function downloadFlyer($slug)
    {
        $package = Package::where('slug', $slug)->firstOrFail();

        $filePath = $package->flyer_pdf ?: $package->image;
        if (!$filePath) {
            abort(404, 'Flyer paket tidak ditemukan.');
        }

        $filePath = ltrim($filePath, '/');

        if (str_starts_with($filePath, 'storage/')) {
            $fullPath = storage_path('app/public/' . substr($filePath, 8));
        } else {
            $fullPath = public_path($filePath);
        }

        if (!file_exists($fullPath)) {
            abort(404, 'File flyer tidak ditemukan di server.');
        }

        $cleanTitle = \Illuminate\Support\Str::slug($package->title);

        // Jika dokumen PDF, unduh langsung sebagai file PDF
        if (str_ends_with(strtolower($filePath), '.pdf')) {
            return response()->download($fullPath, 'Flyer-' . $cleanTitle . '.pdf', [
                'Content-Type' => 'application/pdf',
            ]);
        }

        // Deteksi format asli: jika PNG maka konversi ke PNG, selain itu kembalikan ke JPG
        $isPng = str_contains(strtolower($filePath), 'orig-png') || str_ends_with(strtolower($filePath), '.png');

        if (str_ends_with(strtolower($filePath), '.webp') && function_exists('imagecreatefromwebp')) {
            @ini_set('memory_limit', '512M');
            $img = @imagecreatefromwebp($fullPath);
            if ($img) {
                if ($isPng) {
                    imagepalettetotruecolor($img);
                    imagealphablending($img, true);
                    imagesavealpha($img, true);
                    return response()->streamDownload(function () use ($img) {
                        imagepng($img, null, 9);
                        imagedestroy($img);
                    }, 'Flyer-' . $cleanTitle . '.png', [
                        'Content-Type' => 'image/png',
                    ]);
                } else {
                    $w = imagesx($img);
                    $h = imagesy($img);
                    $canvas = imagecreatetruecolor($w, $h);
                    $white = imagecolorallocate($canvas, 255, 255, 255);
                    imagefill($canvas, 0, 0, $white);
                    imagecopy($canvas, $img, 0, 0, 0, 0, $w, $h);
                    imagedestroy($img);

                    return response()->streamDownload(function () use ($canvas) {
                        imagejpeg($canvas, null, 95);
                        imagedestroy($canvas);
                    }, 'Flyer-' . $cleanTitle . '.jpg', [
                        'Content-Type' => 'image/jpeg',
                    ]);
                }
            }
        }

        $ext = pathinfo($fullPath, PATHINFO_EXTENSION);
        return response()->download($fullPath, 'Flyer-' . $cleanTitle . '.' . $ext);
    }
}
