<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['name', 'role_label', 'quote', 'avatar', 'thumbnail', 'video_url'];
}
