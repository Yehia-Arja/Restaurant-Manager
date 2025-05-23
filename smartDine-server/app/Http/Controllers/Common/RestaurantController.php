<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Services\Common\RestaurantService;
use App\Http\Resources\Common\RestaurantResource;
use App\Http\Resources\Common\RestaurantHomepageResource;
use App\Http\Requests\Common\ListRestaurantsRequest;

class RestaurantController extends Controller
{
    /**
     * GET  /api/v0.1/common/restaurants
     */
    public function index(ListRestaurantsRequest $request)
    {
        try {
            $search = $request->query('search');
            $favoritesOnly = $request->boolean('favorites');
            $perPage = $request->validated()['per_page'] ?? 10;

            $paginator = RestaurantService::filterRestaurants($search, $favoritesOnly, $perPage);

            if ($paginator->isEmpty()) {
                return $this->error('No restaurants found', 404);
            }

            $resourceCollection = RestaurantResource::collection($paginator->items());

            return $this->paginatedResponse(
                'Restaurants fetched',
                $resourceCollection,
                $paginator
            );
            
        } catch (Exception $e) {
            Log::error('Error fetching restaurants', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->error('Failed to fetch restaurants', 500);
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
                return $this->error('Homepage not found', 404);
            }

            return $this->success(
                'Homepage data',
                new RestaurantHomepageResource($payload)
            );
        } catch (Exception $e) {
            Log::error("Error fetching homepage for restaurant {$id}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->error('Failed to fetch homepage data', 500);
        }
    }
}
