<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\OrderStatsRequest;
use App\Services\Owner\OrderService;

class OrderController extends Controller
{
    /**
     * GET /api/v0.1/owner/orders/stats
     *
     * Return counts of total, pending, completed and cancelled orders
     * for either a whole restaurant or a single branch.
     *
     * Request must include either:
     *   - restaurant_id
     *   - restaurant_location_id
     *
     * @param  OrderStatsRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function stats(OrderStatsRequest $request)
    {
        try {
            $data = $request->validated();

            $restaurantId = $data['restaurant_id']            ?? null;
            $branchId     = $data['restaurant_location_id']   ?? null;

            $counts = OrderService::stats($restaurantId, $branchId);

            return $this->success(
                'Order statistics fetched successfully',
                $counts
            );
        }catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
        
    }
}
