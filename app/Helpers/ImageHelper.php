<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageHelper
{
    public static function uploadAndConvert($file, $folder = 'assets/img', $quality = 80)
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $relativePath = ltrim($folder, '/').'/'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)).'_'.time().'.webp';
        $disk = Storage::disk('public_root');

        // Check if GD library is installed
        if (!extension_loaded('gd')) {
            return $file->store($folder, 'public_root');
        }

        try {
            switch ($extension) {
                case 'jpg':
                case 'jpeg':
                    $image = imagecreatefromjpeg($file);
                    break;
                case 'png':
                    $image = imagecreatefrompng($file);
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                    break;
                case 'gif':
                    $image = imagecreatefromgif($file);
                    break;
                default:
                    return $file->store($folder, 'public_root');
            }

            if ($image) {
                ob_start();
                imagewebp($image, null, $quality);
                imagedestroy($image);
                $contents = ob_get_clean();

                if ($contents !== false && $disk->put($relativePath, $contents)) {
                    return $relativePath;
                }
            }
        } catch (\Exception $e) {
            // Fallback to normal upload if something goes wrong
            return $file->store($folder, 'public_root');
        }

        return $file->store($folder, 'public_root');
    }
}
