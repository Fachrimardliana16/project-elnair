<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class JamaahFileStorage
{
    public const DISK = 'jamaah_private';

    public const DOCUMENT_FIELDS = [
        'ktp_file',
        'passport_file',
        'kk_file',
        'vaccine_file',
        'photo_file',
        'payment_proof_file',
    ];

    public static function isAllowedField(string $field): bool
    {
        return in_array($field, self::DOCUMENT_FIELDS, true);
    }

    public static function store(UploadedFile $file, string $directory): string
    {
        return $file->store($directory, self::DISK);
    }

    public static function delete(?string $path): void
    {
        if (! $path) {
            return;
        }

        $privatePath = self::normalizePrivatePath($path);
        if (Storage::disk(self::DISK)->exists($privatePath)) {
            Storage::disk(self::DISK)->delete($privatePath);

            return;
        }

        $legacyPath = self::normalizeLegacyPublicPath($path);
        if (Storage::disk('public')->exists($legacyPath)) {
            Storage::disk('public')->delete($legacyPath);
        }
    }

    public static function response(?string $path, ?string $downloadName = null): ?StreamedResponse
    {
        if (! $path) {
            return null;
        }

        $privatePath = self::normalizePrivatePath($path);
        if (Storage::disk(self::DISK)->exists($privatePath)) {
            return Storage::disk(self::DISK)->response($privatePath, $downloadName);
        }

        $legacyPath = self::normalizeLegacyPublicPath($path);
        if (Storage::disk('public')->exists($legacyPath)) {
            return Storage::disk('public')->response($legacyPath, $downloadName);
        }

        return null;
    }

    public static function normalizePrivatePath(string $path): string
    {
        $path = ltrim($path, '/');

        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, 8);
        }

        if (str_starts_with($path, 'jamaah_docs/')) {
            $path = substr($path, 12);
        }

        return $path;
    }

    public static function normalizeLegacyPublicPath(string $path): string
    {
        $path = ltrim($path, '/');

        if (str_starts_with($path, 'storage/')) {
            return substr($path, 8);
        }

        return $path;
    }
}
