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
        try {
            $all = RestaurantService::getAllRestaurants();

            if ($all->isEmpty()) {
                return $this->error('No restaurants found', 404);
            }
            return $this->success(
                'Restaurants fetched',
                RestaurantResource::collection($all)
            );
        }catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * GET  /api/v0.1/common/restaurant/{id}/homepage
     */
    public function show(Request $request, int $id)
    {
        try {
            $branchOverride = $request->query('restaurant_location_id');
            $payload = RestaurantService::getRestaurantHomepage($id, $branchOverride);

            if (!$payload) {
                return $this->error('Not found', 404);
            }

            return $this->success(
                'Homepage data',
                new RestaurantHomepageResource($payload)
            );
        }catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * POST /api/v0.1/admin/restaurants
     * PUT  /api/v0.1/admin/restaurants/{id}
     *
     * Both use the same Request + Service::upsert()
     */
    public function store(CreateOrUpdateRestaurantRequest $request)
    {
        try {
            $restaurant = RestaurantService::upsert($request->validated());

            if (!$restaurant) {
                return $this->error('Restaurant creation failed', 500);
            }

            return $this->success(
                'Restaurant saved',
                new RestaurantResource($restaurant)
            );
        }catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
        
    }

    public function update(CreateOrUpdateRestaurantRequest $request, int $id)
    {
        try {
            $data = $request->validated();
            $data['id'] = $id;

            $restaurant = RestaurantService::upsert($data);

            return $this->success(
                'Restaurant saved',
                new RestaurantResource($restaurant)
            );
        }catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
        
    }

    /**
     * DELETE /api/v0.1/admin/restaurants/{id}
     */
    public function destroy(int $id)
    {
        try {       
            if (!RestaurantService::deleteRestaurant($id)) {
                return $this->error('Not found', 404);
            }

            return $this->success('Restaurant deleted');
        }catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
        
    }
}
