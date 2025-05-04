<?php

namespace App\Services\Common;

use App\Models\Order;
use Illuminate\Support\Collection;

class OrderService
{
    /**
     * List orders.
     *
     * - If $clientId is given: only that user’s (non-deleted) orders.
     * - Else if $branchId is given: all orders at that branch.
     * - Else if $restaurantId is given: all orders at any branch of that restaurant.
     */
    public static function listOrders(
        ?int $clientId = null,
        ?int $branchId = null,
        ?int $restaurantId = null
    ): Collection {
        $q = Order::query()->whereNull('deleted_at');

        if ($clientId) {
            $q->where('user_id', $clientId);
        } elseif ($branchId) {
            $q->where('restaurant_location_id', $branchId);
        } elseif ($restaurantId) {
            $q->whereIn('restaurant_location_id', function($sub) use ($restaurantId) {
                $sub->select('id')
                    ->from('restaurant_locations')
                    ->where('restaurant_id', $restaurantId);
            });
        }

        return $q->get();
    }

    /**
     * Create a new order.
     */
    public static function createOrder(array $data): Order
    {
        return Order::create($data);
    }

    /**
     * “Soft-remove” an order from a client’s history.
     * Returns true if found & deleted, false otherwise.
     */
    public static function removeOrder(int $orderId, int $clientId): bool
    {
        $order = Order::where('id', $orderId)
                      ->where('user_id', $clientId)
                      ->first();

        if (!$order) {
            return false;
        }

        return (bool) $order->delete();
    }
}
