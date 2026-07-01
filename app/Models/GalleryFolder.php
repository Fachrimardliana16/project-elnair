<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryFolder extends Model
{
    protected $fillable = ['name', 'slug'];

    public function items()
    {
        return $this->hasMany(GalleryItem::class);
    }
}
