<?php

namespace App\Observers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SiteSettingObserver
{
    public function saved(SiteSetting $model): void
    {
        Cache::forget('homepage_settings');
        Cache::forget('site_settings_global');
        Log::channel('activity')->info('Cache busted: site_settings', ['key' => $model->key]);
    }

    public function deleted(SiteSetting $model): void
    {
        Cache::forget('homepage_settings');
        Cache::forget('site_settings_global');
    }
}
