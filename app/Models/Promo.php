<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset($this->publicPath($this->image)) : null;
    }

    public function getPdfUrlAttribute(): ?string
    {
        return $this->pdf_file ? asset($this->publicPath($this->pdf_file)) : null;
    }

    private function publicPath(string $path): string
    {
        return str_starts_with($path, 'storage/') ? $path : 'storage/'.$path;
    }

    protected $fillable = [
        'title',
        'slug',
        'badge',
        'description',
        'details',
        'image',
        'pdf_file',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
