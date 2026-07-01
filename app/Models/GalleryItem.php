<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    protected $fillable = ['gallery_folder_id', 'image', 'title'];

    public function folder()
    {
        return $this->belongsTo(GalleryFolder::class, 'gallery_folder_id');
    }
}
