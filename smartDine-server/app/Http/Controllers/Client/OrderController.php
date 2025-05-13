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
    public function index(Request $request) {
        try {
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
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function store(CreateOrderRequest $request) {
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::id();

            $order = OrderService::place($data);

            return $this->success(
                'Order placed',
                new OrderResource($order),
                Response::HTTP_CREATED
            );
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

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

    public function destroy(int $orderId) {
        try {
            $clientId = Auth::id();

            OrderService::remove($orderId, $clientId);

            return $this->success('Order removed from your history');
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}
