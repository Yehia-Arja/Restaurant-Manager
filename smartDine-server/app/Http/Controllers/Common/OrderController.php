<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\OrderRequest;
use App\Http\Requests\Client\CreateOrderRequest;
use App\Http\Requests\Common\OrderStatusRequest;
use App\Http\Resources\Common\OrderResource;
use App\Services\Common\OrderService;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderController extends Controller
{
    /**
     * GET /api/v0.1/common/orders
     * - Clients get only their own
     * - Owners/Admins may pass branch_id or restaurant_id
     */
    public function index(OrderRequest $request)
    {
        $user        = Auth::user();
        $isClient    = $user->user_type_id === 4;

        $orders = OrderService::list(
            $isClient ? $user->id : null,
            $request->query('restaurant_location_id'),
            $request->query('restaurant_id')
        );

        if ($orders->isEmpty()) {
            return $this->error('No orders found', 404);
        }

        return $this->success(
            'Orders fetched',
            OrderResource::collection($orders)
        );
    }

    /**
     * POST /api/v0.1/common/orders
     * (clients place orders)
     */
    public function store(CreateOrderRequest $request)
    {
        $data = array_merge(
            $request->validated(),
            ['user_id' => Auth::id()]
        );

        $order = OrderService::create($data);

        return $this->success(
            'Order placed',
            new OrderResource($order)
        );
    }

    /**
     * PUT /api/v0.1/common/orders/{order}/status
     * (for complete or cancel)
     */
    public function status($orderId, OrderStatusRequest $request)
    {
        try {
            $order = Order::findOrFail($orderId);

            // authorize here or via middleware

            $action = $request->validated()['action'];

            if ($action === 'cancel') {
                $order = OrderService::cancel($order);
            } else {
                $order = OrderService::updateStatus($order, $action);
            }

            return $this->success(
                'Order status updated',
                new OrderResource($order)
            );
        } catch (ModelNotFoundException $e) {
            return $this->error('Order not found', 404);
        } catch (\RuntimeException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    /**
     * DELETE /api/v0.1/common/orders/{order}
     * (soft-delete from user history)
     */
    public function destroy($orderId)
    {
        try {
            $order = Order::findOrFail($orderId);
            OrderService::remove($order);

            return $this->success('Order removed');
        } catch (ModelNotFoundException $e) {
            return $this->error('Order not found', 404);
        }
    }
}
