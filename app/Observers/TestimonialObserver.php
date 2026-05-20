<?php

namespace App\Observers;

use App\Models\Testimonial;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TestimonialObserver
{
    public function saved(Testimonial $model): void
    {
        Cache::forget('homepage_testimonials');
        Log::channel('activity')->info('Cache busted: homepage_testimonials', ['id' => $model->id]);
    }

    public function deleted(Testimonial $model): void
    {
        Cache::forget('homepage_testimonials');
    }
}
