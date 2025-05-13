<?php
namespace App\Services\Client;

use App\Models\Order;
use Illuminate\Support\Collection;
use App\Models\Table;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use RuntimeException;

class OrderService
{   
    public static function place(array $data): Order
    {
        // Find the correct table ID based on number + location
        $table = Table::where('number', $data['table_number'])
                    ->where('restaurant_location_id', $data['restaurant_location_id'])
                    ->first();

        if (!$table) {
            throw new ModelNotFoundException("Table not found.");
        }

        // Replace table_number with table_id in the order data
        $data['table_id'] = $table->id;
        unset($data['table_number']);

        return Order::create($data);
    }


    public static function listOwn(int $clientId, int $branchId): Collection
    {
        return Order::with('product')
                    ->where('user_id', $clientId)
                    ->where('restaurant_location_id', $branchId)
                    ->whereNull('deleted_at')
                    ->get();
    }

    public static function changeStatus(int $orderId, int $clientId, string $action): Order
    {
        $order = Order::where('id',$orderId)
                      ->where('user_id',$clientId)
                      ->firstOrFail();

        if ($action==='cancel') {
            $minutes = intval($order->product->time_to_deliver);
            $deadline = $order->created_at->addMinutes($minutes);
            if (now()->greaterThan($deadline)) {
                throw new RuntimeException("Cancellation window expired.");
            }
            $order->status = 'cancelled';
        } else {
            $order->status = $action; 
        }

        $order->save();
        return $order;
    }

    public static function remove(int $orderId, int $clientId): void
    {
        $order = Order::where('id',$orderId)
                      ->where('user_id',$clientId)
                      ->firstOrFail();

        // Soft delete the order
        $order->delete();
    }
}
