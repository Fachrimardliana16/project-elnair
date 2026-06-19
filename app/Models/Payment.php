<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'jamaah_id',
        'type',
        'amount',
        'payment_date',
        'payment_proof',
        'status',
    ];

    protected $casts = [
        'payment_date' => 'date',
    ];

    public function jamaah()
    {
        return $this->belongsTo(Jamaah::class);
    }
}
