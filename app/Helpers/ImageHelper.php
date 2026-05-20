<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class ImageHelper
{
    public static function uploadAndConvert($file, $folder = 'assets/img', $quality = 80)
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '_' . time() . '.webp';
        $destinationPath = public_path($folder);
        $fullPath = $destinationPath . '/' . $fileName;

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

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
                case 'webp':
                    return $file->store($folder, 'public_root');
                default:
                    return $file->store($folder, 'public_root');
            }

            if ($image) {
                imagewebp($image, $fullPath, $quality);
                imagedestroy($image);
                return $folder . '/' . $fileName;
            }
        } catch (\Exception $e) {
            // Fallback to normal upload if something goes wrong
            return $file->store($folder, 'public_root');
        }

        return $file->store($folder, 'public_root');
    }
}
