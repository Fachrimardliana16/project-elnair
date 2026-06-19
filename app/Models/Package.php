<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'title', 'slug', 'price_label', 'price_value', 'description',
        'image', 'is_active', 'itinerary', 'hotel_makkah',
        'hotel_madinah', 'maskapai', 'fasilitas',
    ];

    /**
     * Get the clean numeric float value of price_value.
     */
    public function getPriceNumericAttribute(): float
    {
        $rawPrice = $this->price_value ?? '0';
        $priceNumber = (float) preg_replace('/[^0-9]/', '', $rawPrice);
        if (str_contains(strtolower($rawPrice), 'jt') || str_contains(strtolower($rawPrice), 'juta')) {
            $priceNumber *= 1000000;
        }

        return $priceNumber;
    }
}
