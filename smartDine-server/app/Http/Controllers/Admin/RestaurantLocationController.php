<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateOrUpdateRestaurantLocationRequest;
use App\Services\Admin\RestaurantLocationService;
use App\Http\Resources\Common\RestaurantLocationResource;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class RestaurantLocationController extends Controller
{
    /**
     * POST /api/v0.1/admin/restaurant-locations
     */
    public function store(CreateOrUpdateRestaurantLocationRequest $request)
    {
        try {
            $loc = RestaurantLocationService::create($request->validated());

            if (!$loc) {
                return $this->error('Failed to create branch', 500);
            }

            return $this->success('Branch created', new RestaurantLocationResource($loc));

        } catch (Exception $e) {
            Log::error('Admin\RestaurantLocationController@store error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->error('Failed to create branch', 500);
        }
    }

    /**
     * PUT /api/v0.1/admin/restaurant-locations/{id}
     */
    public function update(CreateOrUpdateRestaurantLocationRequest $request, int $id)
    {
        try {
            $loc = RestaurantLocationService::update($id, $request->validated());

            if (!$loc) {
                return $this->error('Branch not found', 404);
            }

            return $this->success('Branch updated', new RestaurantLocationResource($loc));
        } catch (Exception $e) {
            Log::error('Admin\RestaurantLocationController@update error', [
                'id'    => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->error('Failed to update branch', 500);
        }
    }

    /**
     * DELETE /api/v0.1/admin/restaurant-locations/{id}
     */
    public function destroy(int $id)
    {
        try {
            $deleted = RestaurantLocationService::delete($id);

            if (!$deleted) {
                return $this->error('Branch not found', 404);
            }

            return $this->success('Branch deleted');
        } catch (Exception $e) {
            Log::error('Admin\RestaurantLocationController@destroy error', [
                'id'    => $id,
                'error' => $e->getMessage(),
            ]);
            return $this->error('Failed to delete branch', 500);
        }
    }
}
