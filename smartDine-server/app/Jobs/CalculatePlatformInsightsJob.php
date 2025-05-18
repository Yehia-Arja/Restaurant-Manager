<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\User;
use App\Models\Restaurant;
use App\Models\Product;
use App\Models\Table;
use App\Models\Order;
use App\Models\PlatformInsight;
use Carbon\Carbon;

class CalculatePlatformInsightsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    protected string $month;
    protected string $prevMonth;

    public function __construct(?string $month = null)
    {
        $this->month     = $month ?: now()->format('Y-m');
        $this->prevMonth = Carbon::createFromFormat('Y-m', $this->month)->subMonth()->format('Y-m');
    }

    public function handle(): void
    {
        $ownersCount  = User::where('user_type_id', 2)->count();
        $clientsCount = User::where('user_type_id', 4)->count();

        [$y, $m] = explode('-', $this->month);

        $newClients = User::where('user_type_id', 4)
                          ->whereYear('created_at', $y)
                          ->whereMonth('created_at', $m)
                          ->count();

        $restaurantsCount = Restaurant::count();
        $newRestaurants   = Restaurant::whereYear('created_at', $y)
                                      ->whereMonth('created_at', $m)
                                      ->count();

        $productsCount       = Product::count();
        $occupiedTablesCount = Table::where('is_occupied', true)->count();

        $ordersThisMonth = Order::whereYear('created_at', $y)
                                ->whereMonth('created_at', $m)
                                ->get();

        $totalOrdersCount     = $ordersThisMonth->count();
        $completedOrdersCount = $ordersThisMonth->where('status', 'completed')->count();
        $ordersCompletionPct  = $totalOrdersCount
            ? round(($completedOrdersCount / $totalOrdersCount) * 100, 2)
            : null;

        $ordersThisMonth->load('product');
        $revenue = 0;

        foreach ($ordersThisMonth as $order) {
            $productId  = $order->product_id;
            $locationId = $order->restaurant_location_id;

            $overridePrice = DB::table('locationables')
                ->where('locationable_type', 'App\\Models\\Product')
                ->where('locationable_id', $productId)
                ->where('restaurant_location_id', $locationId)
                ->value('override_price');

            $productPrice = optional($order->product)->price ?? 0;
            $price        = $overridePrice ?? $productPrice;

            $revenue += $price;
        }

        $prevInsight = PlatformInsight::where('month', $this->prevMonth)->first();

        $clientsGrowth = ($prevInsight && $prevInsight->clients_count > 0)
            ? round((($clientsCount - $prevInsight->clients_count) / $prevInsight->clients_count) * 100, 2)
            : null;

        $restaurantsGrowth = ($prevInsight && $prevInsight->restaurants_count > 0)
            ? round((($restaurantsCount - $prevInsight->restaurants_count) / $prevInsight->restaurants_count) * 100, 2)
            : null;

        $revenueGrowth = ($prevInsight && $prevInsight->total_revenue > 0)
            ? round((($revenue - $prevInsight->total_revenue) / $prevInsight->total_revenue) * 100, 2)
            : null;

        PlatformInsight::updateOrCreate(
            ['month' => $this->month],
            [
                'owners_count'             => $ownersCount,
                'clients_count'            => $clientsCount,
                'new_clients_count'        => $newClients,
                'clients_growth_pct'       => $clientsGrowth,

                'restaurants_count'        => $restaurantsCount,
                'new_restaurants_count'    => $newRestaurants,
                'restaurants_growth_pct'   => $restaurantsGrowth,

                'products_count'           => $productsCount,
                'occupied_tables_count'    => $occupiedTablesCount,

                'total_orders_count'       => $totalOrdersCount,
                'completed_orders_count'   => $completedOrdersCount,
                'orders_completion_pct'    => $ordersCompletionPct,

                'total_revenue'            => $revenue,
                'revenue_growth_pct'       => $revenueGrowth,
            ]
        );

        Log::info("Platform insights for {$this->month} saved.");
    }

    public function failed(\Throwable $e): void
    {
        Log::error("CalculatePlatformInsightsJob failed: {$e->getMessage()}");
    }
}
