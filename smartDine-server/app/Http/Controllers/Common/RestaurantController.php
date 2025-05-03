<?php
namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $restaurants = RestaurantService::getAllRestaurants();

        return $this->success(
            'Restaurants fetched successfully',
            RestaurantResource::collection($restaurants)
        );
    }

    /**
     * GET  /api/v0.1/common/restaurant/{id}/homepage
     */
    public function show(Request $request, int $id)
    {
        // optionally pass ?restaurant_location_id=#
        $branchOverride = $request->query('restaurant_location_id');

        $payload = RestaurantService::getRestaurantHomepage($id, $branchOverride);

        if (! $payload) {
            return $this->error('Restaurant or branch not found', 404);
        }

        return $this->success(
            'Restaurant homepage data',
            new RestaurantHomepageResource($payload)
        );
    }

    /**
     * POST  /api/v0.1/common/restaurants
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'owner_id'    => 'required|exists:users,id',
            'name'        => 'required|string',
            'file_name'   => 'required|string',
            'description' => 'nullable|string',
        ]);

        $restaurant = RestaurantService::createRestaurant($data);

        return $this->success(
            'Restaurant created successfully',
            new RestaurantResource($restaurant)
        );
    }

    /**
     * PUT  /api/v0.1/common/restaurants/{id}
     */
    public function update(Request $request, int $id)
    {
        $data = $request->validated();
        $restaurant = RestaurantService::updateRestaurant($id, $data);

        if (! $restaurant) {
            return $this->error('Restaurant not found', 404);
        }

        return $this->success(
            'Restaurant updated successfully',
            new RestaurantResource($restaurant)
        );
    }

    /**
     * DELETE  /api/v0.1/common/restaurants/{id}
     */
    public function destroy(int $id)
    {
        $deleted = RestaurantService::deleteRestaurant($id);

        if (! $deleted) {
            return $this->error('Restaurant not found', 404);
        }

        return $this->success('Restaurant deleted successfully');
    }
}
