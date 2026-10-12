<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'title', 'slug', 'price_label', 'price_value', 'description',
        'image', 'itinerary_pdf', 'flyer_pdf', 'is_active', 'itinerary', 'hotel_makkah',
        'hotel_madinah', 'maskapai', 'fasilitas',
    ];

    /**
     * Get the clean numeric float value of price_value.
     */
    public function getPriceNumericAttribute(): float
    {
        return self::parsePrice($this->price_value ?? '0');
    }

    public static function parsePrice(?string $rawPrice): float
    {
        if (! $rawPrice) {
            return 0.0;
        }

        $normalized = strtolower(trim($rawPrice));
        $usesMillionLabel = str_contains($normalized, 'jt') || str_contains($normalized, 'juta');

        if ($usesMillionLabel && preg_match('/(\d+(?:[\.,]\d+)?)/', $normalized, $matches)) {
            $millionValue = (float) str_replace(',', '.', $matches[1]);

            return $millionValue * 1000000;
        }

        return (float) preg_replace('/[^0-9]/', '', $normalized);
    }
}
