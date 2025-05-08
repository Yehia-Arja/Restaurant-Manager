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

    /**
     * Optional month (Y-m), default to now.
     */
    protected string $month;

    /**
     * Create a new job instance.
     *
     * @param  string|null  $month  format "YYYY-MM", defaults to current month
     */
    public function __construct(?string $month = null)
    {
        $this->month = $month ?: now()->format('Y-m');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Fetch all product↔branch entries
        $pairs = DB::table('locationables')
            ->where('locationable_type', 'Product')
            ->select('locationable_id as product_id', 'restaurant_location_id')
            ->get();

        foreach ($pairs as $pair) {
            $productId = $pair->product_id;
            $branchId  = $pair->restaurant_location_id;

            // Order count (all statuses, include soft-deleted)
            $orderCount = Order::withTrashed()
                ->where('product_id', $productId)
                ->where('restaurant_location_id', $branchId)
                ->count();

            // Reviews for that product at that branch
            $reviews = Review::where('reviewable_type', 'App\Models\Product')
                ->where('reviewable_id', $productId)
                ->whereHas('order', fn($q) =>
                    $q->where('restaurant_location_id', $branchId)
                )
                ->get();

            $ratingCount = $reviews->count();
            $avgRating   = $ratingCount
                ? round($reviews->avg('rating'), 2)
                : 0.00;

            // Last 5 comments
            $latestComments = $reviews
                ->sortByDesc('created_at')
                ->take(5)
                ->pluck('comment')
                ->values()
                ->all();

            ProductInsight::updateOrCreate(
                [
                    'product_id'                => $productId,
                    'restaurant_location_id'    => $branchId,
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

        Log::info("Product insights recalculated for {$this->month}.");
    }

    public function failed(\Throwable $exception): void
    {
        Log::error("CalculateProductInsights job failed: {$exception->getMessage()}");
    }
}
