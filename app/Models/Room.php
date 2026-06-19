<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'hotel_name',
        'room_number',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function roomMembers()
    {
        return $this->hasMany(RoomMember::class);
    }
}
