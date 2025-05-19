<?php

namespace App\Services\Common;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use App\Models\Category;

class ProductService
{
    public static function list(
        ?int $branchId = null,
        ?int $restaurantId = null,
        ?int $categoryId = null,
        ?bool $favoritesOnly = false,
        ?string $search = null
    ) {
        $q = Product::query();
    
        if ($categoryId) {
            $q->where('category_id', $categoryId);
        }
    
        if ($branchId) {
            $q->whereHas('locations', function ($query) use ($branchId) {
                $query->where('restaurant_location_id', $branchId);
            });
        }
    
        if ($restaurantId) {
            $q->where('restaurant_id', $restaurantId);
        }
    
        if ($favoritesOnly && Auth::check()) {
            $userId = Auth::id();
            $q->whereHas('favorites', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            });
        }
    
        if ($search) {
            $q->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            });
        }
    
        $q->with([
            'locations' => fn($q) => $q->withPivot(['override_price', 'override_description'])
        ]);
    
        $products = $q->get();
    
        if (Auth::check()) {
            $userId = Auth::id();
            $favoriteIds = Favorite::where('user_id', $userId)
                ->where('favoritable_type', Product::class)
                ->pluck('favoritable_id');
    
            $products->each(fn($product) =>
                $product->setAttribute('is_favorited', $favoriteIds->contains($product->id))
            );
        } else {
            $products->each(fn($product) =>
                $product->setAttribute('is_favorited', false)
            );
        }
    
        return $products;
    }

    public static function getById(int $id): Product
    {
        return Product::with(['locations' => function ($q) {
            $q->withPivot(['override_price', 'override_description']);
        }])->findOrFail($id);
    }
}