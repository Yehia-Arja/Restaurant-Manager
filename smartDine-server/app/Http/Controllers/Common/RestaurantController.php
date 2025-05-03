<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Common\RestaurantService;
use App\Http\Resources\Common\RestaurantResource;
use App\Http\Resources\Common\BranchResource;
use App\Http\Resources\Common\ProductResource;

class RestaurantController extends Controller
{
    /**
     * GET /api/v0.1/common/restaurant
     */
    public function index()
    {
        $all = RestaurantService::getAllRestaurants();
        return $this->success(
            'Restaurants fetched',
            RestaurantResource::collection($all)
        );
    }

    /**
     * GET /api/v0.1/common/restaurant/{id}/homepage
     * (optionally ?branch_id=)
     */
    public function show(Request $request, $id)
    {
        $payload = RestaurantService::getRestaurantHomepage(
            $id,
            $request->query('branch_id')
        );

        if (!$payload) {
            return $this->error('Not found or no branches', 404);
        }

        return $this->success('Restaurant homepage', [
            'restaurant'      => new RestaurantResource($payload['restaurant']),
            'branches'        => BranchResource::collection($payload['branches']),
            'selected_branch' => new BranchResource($payload['selected_branch']),
            'products'        => ProductResource::collection($payload['products']),
        ]);
    }
}
