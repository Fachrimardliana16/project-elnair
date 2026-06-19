<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'jamaah_id',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function jamaah()
    {
        return $this->belongsTo(Jamaah::class);
    }
}
