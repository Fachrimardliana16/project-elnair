<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    protected $fillable = [
        'title', 
        'slug', 
        'custom_domain',
        'content', 
        'custom_wa_number', 
        'custom_wa_message', 
        'hero_image', 
        'meta_title', 
        'meta_description',
        'pixel_script',
        'fb_pixel_id',
        'fb_capi_token',
        'tiktok_pixel_id',
        'tiktok_capi_token',
        'snack_pixel_id',
        'google_pixel_id',
        'google_conversion_label',
        'ad_event_name',
        'fb_pixel_events',
        'is_active'
    ];

    protected $casts = [
        'fb_pixel_events' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Relationship with LandingPageLeads.
     */
    public function leads()
    {
        return $this->hasMany(LandingPageLead::class);
    }

    /**
     * Relationship with AdAccounts (Many-to-Many).
     */
    public function adAccounts()
    {
        return $this->belongsToMany(AdAccount::class, 'landing_page_ad_accounts');
    }

    /**
     * Relationship with DailyAdReports.
     */
    public function dailyAdReports()
    {
        return $this->hasMany(DailyAdReport::class);
    }
}
