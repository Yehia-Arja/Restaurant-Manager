<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Client\CreateOrderRequest;
use App\Http\Requests\Client\OrderStatusRequest;
use App\Http\Resources\Common\OrderResource;
use App\Services\Client\OrderService;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    /**
     * GET  /api/v0.1/common/orders
     * Clients see only their own (optionally scoped to branch).
     */
    public function index(Request $request)
    {
        $clientId  = Auth::id();
        $branchId  = $request->query('restaurant_location_id');

        $orders = OrderService::listOwn($clientId, $branchId);

        if ($orders->isEmpty()) {
            return $this->error('No orders found', Response::HTTP_NOT_FOUND);
        }

        return $this->success(
            'Your orders',
            OrderResource::collection($orders)
        );
    }

    /**
     * POST /api/v0.1/common/orders
     * (clients place new orders)
     */
    public function store(CreateOrderRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $order = OrderService::place($data);

        return $this->success(
            'Order placed',
            new OrderResource($order),
            Response::HTTP_CREATED
        );
    }

    /**
     * PUT /api/v0.1/common/orders/{order}/status
     * (clients may only cancel within window)
     */
    public function status(int $orderId, OrderStatusRequest $request)
    {
        $clientId = Auth::id();
        $action   = $request->validated()['action'];

        try {
            $order = OrderService::changeStatus($orderId, $clientId, $action);

            return $this->success(
                'Order status updated',
                new OrderResource($order)
            );
        } catch (\RuntimeException $e) {
            return $this->error($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * DELETE /api/v0.1/common/orders/{order}
     * (soft‐remove from client history)
     */
    public function destroy(int $orderId)
    {
        $clientId = Auth::id();

        OrderService::remove($orderId, $clientId);

        return $this->success('Order removed from your history');
    }
}
