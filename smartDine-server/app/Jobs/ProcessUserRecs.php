<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Services\Common\ProductService;

class ProcessUserRecs implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected array $userIds;
    protected int   $branchId;

    public function __construct(array $userIds, int $branchId)
    {
        $this->userIds  = $userIds;
        $this->branchId = $branchId;
    }

    public function handle()
    {
        $popular = Cache::get("branch:{$this->branchId}:popular", collect());
        $branchProducts = ProductService::list($this->branchId);

        foreach ($this->userIds as $userId) {
            // find favorite category
            $favCat = DB::table('orders')
                ->join('products','orders.product_id','=','products.id')
                ->where('orders.user_id', $userId)
                ->select('products.category_id', DB::raw('COUNT(*) as cnt'))
                ->groupBy('products.category_id')
                ->orderByDesc('cnt')
                ->value('category_id');

            // products already ordered in this branch
            $ordered = DB::table('orders')
                ->where('user_id', $userId)
                ->where('restaurant_location_id', $this->branchId)
                ->pluck('product_id')
                ->toArray();

            // filter and take up to 10
            $candidates = $branchProducts
                ->filter(fn($p) => (
                    (!$favCat || $p->category_id === $favCat)
                    && ! in_array($p->id, $ordered)
                ))
                ->take(10);

            $recs = $candidates->isEmpty() ? $popular : $candidates;
            Cache::put("user:{$userId}:branch:{$this->branchId}:recs", $recs, now()->addMinutes(30));
        }
    }
}
