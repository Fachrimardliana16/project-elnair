<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'slug', 'content', 'thumbnail', 'author_id', 'status'];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
