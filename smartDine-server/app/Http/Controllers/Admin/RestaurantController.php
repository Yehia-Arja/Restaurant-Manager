<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateOrUpdateRestaurantRequest;
use App\Services\Admin\RestaurantService;
use App\Http\Resources\Common\RestaurantResource;
use Illuminate\Support\Facades\Log;
use Exception;

class RestaurantController extends Controller
{
    /**
     * POST /api/v0.1/admin/restaurants
     */
    public function store(CreateOrUpdateRestaurantRequest $request)
    {
        try {
            $restaurant = RestaurantService::create(
                $request->validated(),
                $request->file('image')
            );

            if (!$restaurant) {
                return $this->error('Failed to create restaurant', 500);
            }

            return $this->success(
                'Restaurant created',
                new RestaurantResource($restaurant)
            );

        } catch (Exception $e) {
            Log::error('Admin\RestaurantController@store error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->error('Failed to create restaurant', 500);
        }
    }

    /**
     * PUT /api/v0.1/admin/restaurants/{id}
     */
    public function update(CreateOrUpdateRestaurantRequest $request, int $id)
    {
        try {
            $restaurant = RestaurantService::update($id,$request->validated(),$request->file('image'));

            if (!$restaurant) {
                return $this->error('Restaurant not found', 404);
            }

            return $this->success(
                'Restaurant updated',
                new RestaurantResource($restaurant)
            );

        } catch (Exception $e) {
            Log::error('Admin\RestaurantController@update error', [
                'id'    => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->error('Failed to update restaurant', 500);
        }
    }

    /**
     * DELETE /api/v0.1/admin/restaurants/{id}
     */
    public function destroy(int $id)
    {
        try {
            $deleted = RestaurantService::delete($id);

            if (!$deleted) {
                return $this->error('Restaurant not found', 404);
            }

            return $this->success('Restaurant deleted');

        } catch (Exception $e) {
            Log::error('Admin\RestaurantController@destroy error', [
                'id'    => $id,
                'error' => $e->getMessage(),
            ]);
            return $this->error('Failed to delete restaurant', 500);
        }
    }
}
