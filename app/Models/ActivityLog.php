<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'subject_type',
        'subject_id',
        'action',
        'before',
        'after',
        'ip_address',
        'user_agent',
        'channel',
    ];

    protected $casts = [
        'before' => 'array',
        'after'  => 'array',
    ];

    /**
     * The user who performed the action.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
