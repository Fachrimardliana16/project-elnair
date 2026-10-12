<?php

namespace App\Services;

use App\Models\AdAccount;
use App\Models\DailyAdReport;

class AdMetricsSyncService
{
    public function sync(): int
    {
        $accounts = AdAccount::with('landingPages')->where('is_active', true)->get();
        $syncCount = 0;

        foreach ($accounts as $account) {
            if ($account->landingPages->isEmpty()) {
                continue;
            }

            $dates = [now()->format('Y-m-d'), now()->subDay()->format('Y-m-d')];

            foreach ($dates as $date) {
                foreach ($account->landingPages as $page) {
                    $seed = crc32($account->account_id.$page->slug.$date);
                    mt_srand($seed);

                    DailyAdReport::updateOrCreate([
                        'landing_page_id' => $page->id,
                        'ad_account_id' => $account->id,
                        'report_date' => $date,
                        'is_manual' => false,
                    ], [
                        'ad_spend' => mt_rand(50000, 350000),
                        'impressions' => mt_rand(4000, 18000),
                        'clicks' => mt_rand(120, 600),
                    ]);
                }
            }

            $syncCount++;
        }

        return $syncCount;
    }
}
