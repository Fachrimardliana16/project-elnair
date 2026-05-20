<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DepartureSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id',
        'departure_date',
        'available_seats',
        'status',
        'is_active',
    ];

    protected $casts = [
        'departure_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
