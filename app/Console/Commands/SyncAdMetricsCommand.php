<?php

namespace App\Console\Commands;

use App\Services\AdMetricsSyncService;
use Illuminate\Console\Command;

class SyncAdMetricsCommand extends Command
{
    protected $signature = 'ads:sync-metrics';

    protected $description = 'Sync active ad account metrics into daily reports';

    public function handle(AdMetricsSyncService $service): int
    {
        $syncCount = $service->sync();

        $this->info("Synced {$syncCount} active ad account(s).");

        return self::SUCCESS;
    }
}
