<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use App\Jobs\ProcessUserRecs;
use App\Models\User;
use App\Models\RestaurantLocation;

class ComputeUserRecs extends Command
{
    protected $signature = 'compute:user-recs';
    protected $description = 'Dispatch jobs to compute personalized recommendations for each user in each branch.';

    public function handle()
    {
        // get all branch IDs
        $branchIds = RestaurantLocation::pluck('id')->toArray();
        // get all user IDs
        $userIds   = User::pluck('id')->toArray();

        // for each branch, dispatch jobs in chunks of 250 users
        foreach ($branchIds as $branchId) {
            foreach (array_chunk($userIds, 250) as $batch) {
                $job = new ProcessUserRecs($batch, $branchId);
                Bus::dispatch($job);
            }
        }

        $this->info('User-branch recommendation batch jobs dispatched!');
    }
}
