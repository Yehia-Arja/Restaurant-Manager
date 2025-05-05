<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use App\Jobs\ProccessProductInsight;
use App\Models\Restaurant;
use App\Models\RestaurantLocation;
use App\Models\Product;

class RefreshProductInsights extends Command
{
    protected $signature = <<<'SIG'
app:refresh-product-insights
    {--restaurant_id= : Refresh only this restaurant}
    {--branch_id=     : Refresh only this branch}
SIG;
    protected $description = 'Recalculate product_insights per-branch (and thus per-restaurant)';

    public function handle()
    {
        $month        = now()->format('Y-m');
        $branchId     = $this->option('branch_id');
        $restaurantId = $this->option('restaurant_id');

        // build [ branch_id => restaurant_id ] map
        if ($branchId) {
            $branch = RestaurantLocation::find($branchId);
            if (! $branch) {
                return $this->error("Branch #{$branchId} not found.");
            }
            $map = [ $branch->id => $branch->restaurant_id ];

        } elseif ($restaurantId) {
            $restaurant = Restaurant::with('locations')->find($restaurantId);
            if (! $restaurant) {
                return $this->error("Restaurant #{$restaurantId} not found.");
            }
            $map = $restaurant
                ->locations
                ->pluck('restaurant_id','id') // [ branch_id => restaurant_id ]
                ->all();

        } else {
            // all restaurants
            $map = Restaurant::with('locations')
                ->get()
                ->flatMap(function($r) {
                    return $r->locations->pluck('restaurant_id','id');
                })
                ->all();
        }

        if (empty($map)) {
            return $this->warn('Nothing to process.');
        }

        foreach ($map as $bId => $rId) {
            $ids = Product::where('restaurant_id', $rId)
                          ->pluck('id')
                          ->toArray();

            if (empty($ids)) {
                $this->warn("Rest #{$rId} has no products; skipping branch #{$bId}.");
                continue;
            }

            foreach (array_chunk($ids, 200) as $chunk) {
                Bus::dispatch(new ProccessProductInsight($chunk, $bId, $month));
            }

            $this->info("Dispatched jobs for branch #{$bId} (rest #{$rId}).");
        }

        return $this->info('All product-insight jobs dispatched.');
    }
}
