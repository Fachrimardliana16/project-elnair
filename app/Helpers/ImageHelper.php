<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageHelper
{
    public static function uploadAndConvert($file, $folder = 'assets/img', $quality = 82, $maxDimension = 2400)
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $origExtTag = in_array($extension, ['png', 'gif']) ? '_orig-png' : '_orig-jpg';
        $relativePath = ltrim($folder, '/').'/'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)).'_'.time().$origExtTag.'.webp';
        $disk = Storage::disk('public_root');

        // Check if GD library is installed
        if (!extension_loaded('gd')) {
            return $file->store($folder, 'public_root');
        }

        // Increase memory limit for processing large high-resolution images
        @ini_set('memory_limit', '512M');

        try {
            $image = null;
            switch ($extension) {
                case 'jpg':
                case 'jpeg':
                    $image = @imagecreatefromjpeg($file);
                    // Fix EXIF orientation if available
                    if ($image && function_exists('exif_read_data')) {
                        try {
                            $exif = @exif_read_data($file->getRealPath());
                            if (!empty($exif['Orientation'])) {
                                switch ($exif['Orientation']) {
                                    case 3:
                                        $rotated = imagerotate($image, 180, 0);
                                        if ($rotated !== false) { imagedestroy($image); $image = $rotated; }
                                        break;
                                    case 6:
                                        $rotated = imagerotate($image, -90, 0);
                                        if ($rotated !== false) { imagedestroy($image); $image = $rotated; }
                                        break;
                                    case 8:
                                        $rotated = imagerotate($image, 90, 0);
                                        if ($rotated !== false) { imagedestroy($image); $image = $rotated; }
                                        break;
                                }
                            }
                        } catch (\Throwable $t) {
                            // ignore exif failure
                        }
                    }
                    break;
                case 'png':
                    $image = @imagecreatefrompng($file);
                    if ($image) {
                        imagepalettetotruecolor($image);
                        imagealphablending($image, true);
                        imagesavealpha($image, true);
                    }
                    break;
                case 'gif':
                    $image = @imagecreatefromgif($file);
                    break;
                case 'webp':
                    if (function_exists('imagecreatefromwebp')) {
                        $image = @imagecreatefromwebp($file);
                    }
                    break;
                default:
                    return $file->store($folder, 'public_root');
            }

            if ($image) {
                // Resize if exceeding max dimensions while preserving aspect ratio
                $origWidth = imagesx($image);
                $origHeight = imagesy($image);

                if ($maxDimension > 0 && ($origWidth > $maxDimension || $origHeight > $maxDimension)) {
                    if ($origWidth >= $origHeight) {
                        $newWidth = $maxDimension;
                        $newHeight = (int) round(($origHeight / $origWidth) * $maxDimension);
                    } else {
                        $newHeight = $maxDimension;
                        $newWidth = (int) round(($origWidth / $origHeight) * $maxDimension);
                    }

                    $scaled = imagescale($image, $newWidth, $newHeight);
                    if ($scaled !== false) {
                        imagedestroy($image);
                        $image = $scaled;
                    }
                }

                // Ensure alpha transparency is preserved before webp export
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);

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
