<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

use App\Models\User;
use App\Models\Restaurant;
use App\Models\Product;
use App\Models\Table;
use App\Models\Order;
use App\Models\PlatformInsight;

class CalculatePlatformInsightsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    protected string $month;      
    protected string $prevMonth; 

    public function __construct(?string $month = null)
    {
        $this->month     = $month ?: now()->format('Y-m');
        $this->prevMonth = now()->subMonth()->format('Y-m');
    }

    public function handle(): void
    {
        // Owners & Clients
        $ownersCount   = User::where('user_type_id', 2)->count();
        $clientsCount  = User::where('user_type_id', 4)->count();

        // New clients this vs. prev month
        [$y, $m]      = explode('-', $this->month);
        [$py, $pm]    = explode('-', $this->prevMonth);
        $newClients   = User::where('user_type_id', 4)
                            ->whereYear('created_at', $y)
                            ->whereMonth('created_at', $m)
                            ->count();
        $newClientsP  = User::where('user_type_id', 4)
                            ->whereYear('created_at', $py)
                            ->whereMonth('created_at', $pm)
                            ->count();
        $clientsGrowth = $newClientsP
            ? round((($newClients - $newClientsP) / $newClientsP) * 100, 2)
            : null;

        // Restaurants
        $restaurantsCount    = Restaurant::count();
        $newRestaurants      = Restaurant::whereYear('created_at', $y)
                                         ->whereMonth('created_at', $m)
                                         ->count();
        $newRestaurantsPrev  = Restaurant::whereYear('created_at', $py)
                                         ->whereMonth('created_at', $pm)
                                         ->count();
        $restaurantsGrowth   = $newRestaurantsPrev
            ? round((($newRestaurants - $newRestaurantsPrev) / $newRestaurantsPrev) * 100, 2)
            : null;

        // Products & Tables
        $productsCount        = Product::count();
        $occupiedTablesCount  = Table::where('is_occupied', true)->count();

        // Orders & Revenue
        $ordersThisMonth      = Order::whereYear('created_at', $y)
                                     ->whereMonth('created_at', $m)
                                     ->get();
        $totalOrdersCount     = $ordersThisMonth->count();
        $completedOrdersCount = $ordersThisMonth
                                    ->where('status', 'completed')
                                    ->count();
        $ordersCompletionPct  = $totalOrdersCount
            ? round(($completedOrdersCount / $totalOrdersCount) * 100, 2)
            : null;

        // Sum revenue: override_price or product.price
        $revenue = 0;
        $ordersThisMonth->load('product'); 
        foreach ($ordersThisMonth as $order) {
            $revenue += $order->override_price
                ?? ($order->product->price ?? 0);
        }

        // Save insights
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
            ]
        );

        Log::info("Platform insights for {$this->month} saved.");
    }

    public function failed(\Throwable $e): void
    {
        Log::error("CalculatePlatformInsightsJob failed: {$e->getMessage()}");
    }
}
