<?php

namespace App\Observers;

use App\Models\Feature;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class FeatureObserver
{
    public function saved(Feature $model): void
    {
        Cache::forget('homepage_features');
        Log::channel('activity')->info('Cache busted: homepage_features', ['id' => $model->id]);
    }

    public function deleted(Feature $model): void
    {
        Cache::forget('homepage_features');
    }
}
