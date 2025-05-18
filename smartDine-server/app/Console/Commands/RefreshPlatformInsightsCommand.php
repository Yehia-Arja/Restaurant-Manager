<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CalculatePlatformInsightsJob;

class RefreshPlatformInsightsCommand extends Command
{
    protected $signature = 'refresh:platform-insights
                            {--month= : Month in "YYYY-MM" format (defaults to current month)}';

    protected $description = 'Recalculate and store platform-wide stats (owners, restaurants, products, occupied tables)';

    public function handle()
    {
        $month = $this->option('month') ?: now()->format('Y-m');

        // Dispatch the job that does the actual counting & persistence
        CalculatePlatformInsightsJob::dispatch($month);

        $this->info("Platform‐insights job dispatched for {$month}.");
    }
}
