<?php

namespace App\Services\Common;

use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;

class RestaurantService
{

    public static function filterRestaurants(?string $search = null, bool $favoritesOnly = false)
    {
        $query = Restaurant::whereHas('locations');

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($favoritesOnly && Auth::check()) {
            $userId = Auth::id();
            $query->whereHas('favorites', fn ($q) => $q->where('user_id', $userId));
        }

        return $query->get();
    }
    public static function getRestaurantHomepage(int $restaurantId, ?int $branchId = null): ?array
    {
        $restaurant = Restaurant::with('locations')->find($restaurantId);

        if (!$restaurant || $restaurant->locations->isEmpty()) {
            return null;
        }

        $branches = $restaurant->locations;
        $selected = $branchId
            ? $branches->firstWhere('id', $branchId)
            : $branches->first();

        if (!$selected) {
            return null;
        }

        $products   = ProductService::list($selected->id);
        $categories = CategoryService::list($selected->id);

        return [
            'restaurant'      => $restaurant,
            'branches'        => $branches,
            'selected_branch' => $selected,
            'categories'      => $categories,
            'products'        => $products,
        ];
    }
}
