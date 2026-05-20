<?php

namespace App\Observers;

use App\Models\Article;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ArticleObserver
{
    public function saved(Article $model): void
    {
        Cache::forget('homepage_articles');
        Log::channel('activity')->info('Cache busted: homepage_articles', ['id' => $model->id, 'title' => $model->title]);
    }

    public function deleted(Article $model): void
    {
        Cache::forget('homepage_articles');
    }
}
