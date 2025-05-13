<?php

namespace App\Http\Controllers\Common;

<<<<<<< HEAD
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateOrUpdateRestaurantRequest;
use App\Services\Common\RestaurantService;
use App\Http\Resources\Common\RestaurantResource;
use App\Http\Resources\Common\RestaurantHomepageResource;
=======
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Services\Common\RestaurantService;
use App\Http\Resources\Common\RestaurantResource;
use App\Http\Resources\Common\RestaurantHomepageResource;
use App\Http\Requests\Common\ListRestaurantsRequest;
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d

class RestaurantController extends Controller
{
    /**
     * GET  /api/v0.1/common/restaurants
     */
<<<<<<< HEAD
    public function index()
    {
        $all = RestaurantService::getAllRestaurants();

        if ($all->isEmpty()) {
            return $this->error('No restaurants found', 404);
        }
        return $this->success(
            'Restaurants fetched',
            RestaurantResource::collection($all)
        );
=======
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
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
    }

    /**
     * GET  /api/v0.1/common/restaurant/{id}/homepage
     */
    public function show(Request $request, int $id)
    {
<<<<<<< HEAD
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
     * POST /api/v0.1/admin/restaurants
     * PUT  /api/v0.1/admin/restaurants/{id}
     *
     * Both use the same Request + Service::upsert()
     */
    public function store(CreateOrUpdateRestaurantRequest $request)
    {
        $restaurant = RestaurantService::upsert($request->validated());

        if (!$restaurant) {
            return $this->error('Restaurant creation failed', 500);
        }

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
     * DELETE /api/v0.1/admin/restaurants/{id}
     */
    public function destroy(int $id)
    {
        if (!RestaurantService::deleteRestaurant($id)) {
            return $this->error('Not found', 404);
        }

        return $this->success('Restaurant deleted');
=======
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
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
    }
}
