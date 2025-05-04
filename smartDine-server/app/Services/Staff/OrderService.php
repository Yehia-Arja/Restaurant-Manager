<?php
namespace App\Services\Staff;

use App\Models\Order;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use InvalidArgumentException;

class OrderService
{
    /**
     * Fetch all pending OR accepted orders for a specific branch & table.
     *
     * @param  int  $branchId
     * @param  int  $tableId
     * @return Collection<Order>
     */
    public static function listByTable(int $branchId, int $tableId): Collection
    {
        return Order::where('restaurant_location_id', $branchId)
            ->where('table_id', $tableId)
            ->whereNull('deleted_at')
            ->whereIn('status', ['pending', 'accepted'])
            ->get();
    }

    /**
     * Move a single order from 'pending' to 'accepted' or 'rejected'.
     *
     * @param  int     $orderId
     * @param  string  $action    // must be exactly 'accepted' or 'rejected'
     * @return Order
     *
     * @throws ModelNotFoundException
     * @throws InvalidArgumentException
     */
    public static function acceptOrReject(int $orderId, string $action): Order
    {
        if (!in_array($action, ['accepted', 'rejected'], true)) {
            throw new InvalidArgumentException("Invalid action “{$action}”.");
        }

        $order = Order::findOrFail($orderId);

        // only pending orders should be acted upon
        if ($order->status !== 'pending') {
            throw new InvalidArgumentException("Order #{$orderId} is not pending.");
        }

        $order->status = $action;
        $order->save();

        return $order;
    }
}
