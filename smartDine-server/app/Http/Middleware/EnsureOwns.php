<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Restaurant;
use App\Models\RestaurantLocation;

class EnsureOwns
{
    public function handle(Request $request, Closure $next): Response
    {
        $userId = $request->user()->id;

        // If restaurant_id is present, check ownership
        if ($request->has('restaurant_id')) {
            $restaurant = Restaurant::find($request->restaurant_id);
            if (!$restaurant || $restaurant->owner_id !== $userId) {
                return response()->json(['message' => 'Unauthorized. You do not own this restaurant.'], 403);
            }
        }

        // If location_id is present, check ownership through restaurant
        if ($request->has('location_id')) {
            $location = RestaurantLocation::with('restaurant')->find($request->location_id);
            if (
                !$location ||
                !$location->restaurant ||
                $location->restaurant->owner_id !== $userId
            ) {
                return response()->json(['message' => 'Unauthorized. You do not own this location.'], 403);
            }
        }

        return $next($request);
    }
}
