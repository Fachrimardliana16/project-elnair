<?php

namespace App\Observers;

use App\Models\Package;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PackageObserver
{
    public function saved(Package $model): void
    {
        Cache::forget('homepage_packages');
        Log::channel('activity')->info('Cache busted: homepage_packages', ['id' => $model->id, 'title' => $model->title]);
    }

    public function deleted(Package $model): void
    {
        Cache::forget('homepage_packages');
        Log::channel('activity')->info('Cache busted: homepage_packages (deleted)', ['id' => $model->id]);
    }
}
