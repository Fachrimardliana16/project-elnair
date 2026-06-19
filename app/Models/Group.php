<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'departure_schedule_id',
        'name',
        'muthowif',
        'pembimbing',
        'bus_number',
        'booking_code',
        'flight_code',
        'flight_departure_time',
        'flight_transit',
        'flight_terminal',
        'capacity',
    ];

    protected $casts = [
        'flight_departure_time' => 'datetime',
    ];

    public function departureSchedule()
    {
        return $this->belongsTo(DepartureSchedule::class);
    }

    public function jamaahs()
    {
        return $this->hasMany(Jamaah::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
