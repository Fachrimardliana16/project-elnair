<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform',
        'account_name',
        'account_id',
        'access_token',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Many-to-Many relation with Landing Pages.
     */
    public function landingPages()
    {
        return $this->belongsToMany(LandingPage::class, 'landing_page_ad_accounts');
    }

    /**
     * Has-Many relation with Daily Ad Reports.
     */
    public function reports()
    {
        return $this->hasMany(DailyAdReport::class);
    }
}
