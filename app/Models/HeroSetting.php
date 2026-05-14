<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSetting extends Model
{
    protected $fillable = ['tagline', 'title', 'subtitle', 'btn_primary_text', 'btn_primary_url', 'btn_secondary_text', 'btn_secondary_url', 'background_image'];
}
