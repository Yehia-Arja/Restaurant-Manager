<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Common\RestaurantService;

class RestaurantController extends Controller
{
    public function index()
    {
        // Fetch all restaurants
        $restaurants = RestaurantService::getAllRestaurants();

        if (!$restaurants) {
            return $this->error('No restaurants found', 404);
        }

        return $this->success('Restaurants fetched successfully', $restaurants);
    }

    public function show($id)
    {
        // Fetch a specific restaurant by ID
        $restaurant = RestaurantService::getRestaurantBranchDetails($id);

        if (!$restaurant) {
            return $this->error('Restaurant not found', 404);
        }

        return $this->success('Restaurant fetched successfully', $restaurant);
    }
}
