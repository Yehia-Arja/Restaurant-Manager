<?php

namespace App\Services\Common;

use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;

class RestaurantService
{

    public static function filterRestaurants(?string $search = null, bool $favoritesOnly = false, int $perPage = 10)
    {
        $query = Restaurant::with('locations');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($favoritesOnly && Auth::check()) {
            $userId = Auth::id();
            $query->whereHas('favorites', fn ($q) => $q->where('user_id', $userId));
        }

        $restaurants = $query->paginate($perPage);

        // Add is_favorite manually
        if (Auth::check()) {
            $userId = Auth::id();
            $favoriteIds = Favorite::where('user_id', $userId)
                ->where('favoritable_type', Restaurant::class)
                ->pluck('favoritable_id')
                ->toArray();

            $restaurants->getCollection()->transform(function ($restaurant) use ($favoriteIds) {
                $restaurant->is_favorite = in_array($restaurant->id, $favoriteIds);
                return $restaurant;
            });
        }

        return $restaurants;
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
