<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPageLead extends Model
{
    protected $fillable = [
        'landing_page_id',
        'name',
        'phone',
        'package',
        'status',
        // UTM attribution
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_content',
        'utm_term',
        // Forensic tracking
        'ip_address',
        'user_agent',
        'referrer',
    ];

    public function landingPage()
    {
        return $this->belongsTo(LandingPage::class);
    }
}
