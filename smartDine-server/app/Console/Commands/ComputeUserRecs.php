<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use Carbon\Carbon;

class ComputeUserRecs extends Command
{
    protected $signature = 'compute:user-recs {--user=}';
    protected $description = 'Cache personalized recs per user';

    public function handle()
    {
        $users = $this->option('user')
            ? [(int)$this->option('user')]
            : DB::table('users')->pluck('id')->toArray();

        foreach ($users as $userId) {
            $favCat = DB::table('orders')
                ->join('products','orders.product_id','=','products.id')
                ->where('orders.user_id',$userId)
                ->select('products.category_id', DB::raw('COUNT(*) as cnt'))
                ->groupBy('products.category_id')
                ->orderByDesc('cnt')
                ->value('category_id');

            $ordered = DB::table('orders')
                ->where('user_id',$userId)
                ->pluck('product_id')
                ->toArray();

            $query = Product::query();
            if ($favCat) {
                $query->where('category_id', $favCat);
            }
            $recs = $query
                ->whereNotIn('id', $ordered)
                ->orderByDesc('popularity_score')
                ->limit(10)
                ->get();

            Cache::put(
                "user:{$userId}:recs",
                $recs,
                Carbon::now()->addMinutes(30)
            );

            $this->info("Cached recs for user {$userId}");
        }
    }
}
