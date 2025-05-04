<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\StaffOrderIndexRequest;
use App\Http\Requests\Staff\StaffOrderStatusRequest;
use App\Http\Resources\Common\OrderResource;
use App\Services\Staff\OrderService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use InvalidArgumentException;

class OrderController extends Controller
{
    /**
     * GET  /api/v0.1/staff/orders
     * @uses StaffOrderIndexRequest for validation
     */
    public function index(StaffOrderIndexRequest $request)
    {
        $data = $request->validated();

        $orders = OrderService::listByTable(
            $data['restaurant_location_id'],
            $data['table_id']
        );

        return $this->success(
            'Orders fetched',
            OrderResource::collection($orders)
        );
    }

    /**
     * PUT  /api/v0.1/staff/orders/{order}/status
     * @uses StaffOrderStatusRequest for validation
     */
    public function changeStatus(StaffOrderStatusRequest $request, int $orderId)
    {
        $data = $request->validated();
        
        try {
            $updated = OrderService::acceptOrReject(
                $orderId,
                $data['action']
            );

            return $this->success(
                'Order status updated',
                new OrderResource($updated)
            );
        } catch (ModelNotFoundException $e) {
            return $this->error('Order not found', 404);
        } catch (InvalidArgumentException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }
}
