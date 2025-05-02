<?php

namespace App\Services;

use App\Models\Restaurant;

class RestaurantService
{
    public static function getAllRestaurants()
    {
        return Restaurant::all();
    }
}