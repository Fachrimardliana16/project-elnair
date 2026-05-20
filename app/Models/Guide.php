<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guide extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'description',
        'image',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
