<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'title', 'slug', 'price_label', 'price_value', 'description', 
        'image', 'is_active', 'itinerary', 'hotel_makkah', 
        'hotel_madinah', 'maskapai', 'fasilitas'
    ];
}
