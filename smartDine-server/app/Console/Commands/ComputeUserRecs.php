<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Services\Common\ProductService;
use Carbon\Carbon;

class ComputeUserRecs extends Command
{
    /**
     * Compute and cache personalized recs per user *and* branch.
     *
     * @var string
     */
    protected $signature = 'compute:user-recs
                            {--user= : ID of a single user}
                            {--branch= : ID of a single branch}';

    protected $description = 'Cache personalized recommendations for each user in each branch';

    public function handle()
    {
        // Determine users to process
        $users = $this->option('user')
            ? [(int)$this->option('user')]
            : DB::table('users')->pluck('id')->toArray();

        // Determine branches to process
        $branches = $this->option('branch')
            ? [(int)$this->option('branch')]
            : DB::table('restaurant_locations')->pluck('id')->toArray();

        foreach ($branches as $branchId) {
            // Fetch the branch’s popular fallback (must have been computed already)
            $popular = Cache::get("branch:{$branchId}:popular", collect());

            // Load this branch’s full menu once per branch
            $branchProducts = ProductService::list($branchId);

            // IDs the user has already ordered at this branch
            foreach ($users as $userId) {
                // Favorite category across *all* user orders
                $favCat = DB::table('orders')
                    ->join('products','orders.product_id','=','products.id')
                    ->where('orders.user_id', $userId)
                    ->select('products.category_id', DB::raw('COUNT(*) as cnt'))
                    ->groupBy('products.category_id')
                    ->orderByDesc('cnt')
                    ->value('category_id');

                // Which products this user ordered in this branch
                $orderedAtBranch = DB::table('orders')
                    ->where('user_id', $userId)
                    ->where('restaurant_location_id', $branchId)
                    ->pluck('product_id')
                    ->toArray();

                // Filter branchProducts by favorite category & exclude ordered
                $candidates = $branchProducts
                    ->filter(fn($p) => (
                        (!$favCat || $p->category_id === $favCat)
                        && ! in_array($p->id, $orderedAtBranch)
                    ))
                    ->take(10);

                // Fallback to popular if no personalized picks
                $toCache = $candidates->isEmpty() ? $popular : $candidates;

                // Cache under a user+branch key
                $cacheKey = "user:{$userId}:branch:{$branchId}:recs";
                Cache::put($cacheKey, $toCache, Carbon::now()->addMinutes(30));

                $this->info("Cached recs for user {$userId} at branch {$branchId}");
            }
        }
    }
}
