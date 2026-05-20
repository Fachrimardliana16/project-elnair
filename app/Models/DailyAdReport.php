<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyAdReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'landing_page_id',
        'ad_account_id',
        'report_date',
        'ad_spend',
        'impressions',
        'clicks',
        'is_manual',
    ];

    protected $casts = [
        'report_date' => 'date',
        'ad_spend' => 'decimal:2',
        'impressions' => 'integer',
        'clicks' => 'integer',
        'is_manual' => 'boolean',
    ];

    /**
     * Belongs-To relation with LandingPage.
     */
    public function landingPage()
    {
        return $this->belongsTo(LandingPage::class);
    }

    /**
     * Belongs-To relation with AdAccount.
     */
    public function adAccount()
    {
        return $this->belongsTo(AdAccount::class);
    }
}
