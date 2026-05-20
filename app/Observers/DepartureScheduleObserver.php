<?php

namespace App\Observers;

use App\Models\DepartureSchedule;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class DepartureScheduleObserver
{
    public function saved(DepartureSchedule $model): void
    {
        Cache::forget('homepage_schedules');
        Log::channel('activity')->info('Cache busted: homepage_schedules', ['id' => $model->id]);
    }

    public function deleted(DepartureSchedule $model): void
    {
        Cache::forget('homepage_schedules');
    }
}
