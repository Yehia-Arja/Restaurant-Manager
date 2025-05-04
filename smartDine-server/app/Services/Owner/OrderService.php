<?php

namespace App\Services\Owner;

use App\Models\Order;

class OrderService
{
    /**
     * Return order‐counts by status for a whole restaurant or a single branch.
     *
     * @param  int|null  $restaurantId
     * @param  int|null  $branchId
     * @return array{total:int,pending:int,completed:int,cancelled:int}
     */
    public static function stats(?int $restaurantId, ?int $branchId): array
    {
        $base = Order::withTrashed();

        if ($branchId) {
            $base->where('restaurant_location_id', $branchId);
        } else {
            $base->whereHas('location', fn($q) =>
                $q->where('restaurant_id', $restaurantId)
            );
        }

        $total    = (clone $base)->count();
        $pending  = (clone $base)->where('status', 'pending')->count();
        $completed= (clone $base)->where('status', 'completed')->count();
        $cancelled= (clone $base)->where('status', 'cancelled')->count();

        return compact('total','pending','completed','cancelled');
    }
}
