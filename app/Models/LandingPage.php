<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    protected $fillable = [
        'title', 
        'slug', 
        'content', 
        'custom_wa_number', 
        'custom_wa_message', 
        'hero_image', 
        'meta_title', 
        'meta_description'
    ];
}
