<?php

namespace App\Observers;

use App\Models\HeroSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class HeroSettingObserver
{
    public function saved(HeroSetting $model): void
    {
        Cache::forget('homepage_hero');
        Log::channel('activity')->info('Cache busted: homepage_hero', ['id' => $model->id]);
    }

    public function deleted(HeroSetting $model): void
    {
        Cache::forget('homepage_hero');
    }
}
