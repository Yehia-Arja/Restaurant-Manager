<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\Review;
use App\Models\ProductInsight;
use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProccessProductInsight implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    protected string $month;
    protected array $productIds;
    protected int $branchId;

    public function __construct(array $productIds, int $branchId, ?string $month = null)
    {
        $this->productIds = $productIds;
        $this->branchId = $branchId;
        $this->month = $month ?: now()->format('Y-m');
    }

    public function handle(): void
    {
        foreach ($this->productIds as $productId) {
            // Order count (all statuses, include soft-deleted)
            $orderCount = Order::withTrashed()
                ->where('product_id', $productId)
                ->where('restaurant_location_id', $this->branchId)
                ->count();

            $reviews = Review::where('reviewable_type', 'App\Models\Product')
                ->where('reviewable_id', $productId)
                ->whereHas('order', fn($q) =>
                    $q->where('restaurant_location_id', $this->branchId)
                )
                ->get();

            $ratingCount = $reviews->count();
            $avgRating   = $ratingCount
                ? round($reviews->avg('rating'), 2)
                : 0.00;

            $latestComments = $reviews
                ->sortByDesc('created_at')
                ->take(5)
                ->pluck('comment')
                ->values()
                ->all();

            ProductInsight::updateOrCreate(
                [
                    'product_id'             => $productId,
                    'restaurant_location_id' => $this->branchId,
                ],
                [
                    'order_count'     => $orderCount,
                    'avg_rating'      => $avgRating,
                    'rating_count'    => $ratingCount,
                    'latest_comments' => json_encode($latestComments),
                    'month'           => $this->month,
                ]
            );
        }

        Log::info("Product insights recalculated for branch {$this->branchId} ({$this->month}).");
    }

    public function failed(\Throwable $exception): void
    {
        Log::error("CalculateProductInsights job failed: {$exception->getMessage()}");
    }
}
