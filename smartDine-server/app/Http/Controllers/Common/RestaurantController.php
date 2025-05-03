<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateOrUpdateRestaurantRequest;
use App\Services\Common\RestaurantService;
use App\Http\Resources\Common\RestaurantResource;
use App\Http\Resources\Common\RestaurantHomepageResource;

class RestaurantController extends Controller
{
    /**
     * GET  /api/v0.1/common/restaurants
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
     * GET  /api/v0.1/common/restaurant/{id}/homepage
     */
    public function show(Request $request, int $id)
    {
        $branchOverride = $request->query('restaurant_location_id');
        $payload = RestaurantService::getRestaurantHomepage($id, $branchOverride);

        if (!$payload) {
            return $this->error('Not found', 404);
        }

        return $this->success(
            'Homepage data',
            new RestaurantHomepageResource($payload)
        );
    }

    /**
     * POST /api/v0.1/common/restaurants
     * PUT  /api/v0.1/common/restaurants/{id}
     *
     * Both use the same Request + Service::upsert()
     */
    public function store(CreateOrUpdateRestaurantRequest $request)
    {
        $restaurant = RestaurantService::upsert($request->validated());

        return $this->success(
            'Restaurant saved',
            new RestaurantResource($restaurant)
        );
    }

    public function update(CreateOrUpdateRestaurantRequest $request, int $id)
    {
        $data = $request->validated();
        $data['id'] = $id;

        $restaurant = RestaurantService::upsert($data);

        return $this->success(
            'Restaurant saved',
            new RestaurantResource($restaurant)
        );
    }

    /**
     * DELETE /api/v0.1/common/restaurants/{id}
     */
    public function destroy(int $id)
    {
        if (!RestaurantService::deleteRestaurant($id)) {
            return $this->error('Not found', 404);
        }

        return $this->success('Restaurant deleted');
    }
}
