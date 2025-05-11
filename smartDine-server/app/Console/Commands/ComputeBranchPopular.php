<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use Carbon\Carbon;

class ComputeBranchPopular extends Command
{
    protected $signature = 'compute:branch-popular {--branch=}';
    protected $description = 'Cache top products per branch';

    public function handle()
    {
        $branches = $this->option('branch')
            ? [(int)$this->option('branch')]
            : DB::table('restaurant_locations')->pluck('id')->toArray();

        foreach ($branches as $branchId) {
            $topIds = DB::table('orders')
                ->where('restaurant_location_id', $branchId)
                ->select('product_id', DB::raw('COUNT(*) as cnt'))
                ->groupBy('product_id')
                ->orderByDesc('cnt')
                ->limit(10)
                ->pluck('product_id')
                ->toArray();

            $products = Product::whereIn('id', $topIds)->get();

            Cache::put(
                "branch:{$branchId}:popular",
                $products,
                Carbon::now()->addMinutes(30)
            );

            $this->info("Cached popular for branch {$branchId}");
        }
    }
}
