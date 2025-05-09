<?php

namespace App\Services\Common;

use App\Models\Product;
use Illuminate\Support\Collection;

class ProductService
{
    /**
     * Fetch products with optional filtering by branch (location), restaurant, category, or search term.
     * Uses the 'locations' relation (morph-pivot) to filter by branch and load override pivots.
     */
    public static function list(
        ?int $restaurantLocationId = null,
        ?int $restaurantId        = null,
        ?int $categoryId          = null,
        ?string $search           = null
    ): Collection {
        $query = Product::query();

        // Filter by branch and eager-load pivot overrides
        if ($restaurantLocationId) {
            $query->whereHas('locations', function ($q) use ($restaurantLocationId) {
                $q->where('restaurant_location_id', $restaurantLocationId);
            });
            $query->with(['locations' => function ($q) use ($restaurantLocationId) {
                $q->where('restaurant_location_id', $restaurantLocationId)
                  ->withPivot(['override_price', 'override_description']);
            }]);
        }
        // Otherwise, filter by restaurant
        elseif ($restaurantId) {
            $query->where('restaurant_id', $restaurantId);
        }

        // Category filter
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        // Search by name, description, or tags
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('products.name', 'like', "%{$search}%")
                  ->orWhere('products.description', 'like', "%{$search}%")
                  ->orWhereIn('products.id', function ($inner) use ($search) {
                      $inner->select('product_id')
                            ->from('product_tags')
                            ->join('tags', 'tags.id', '=', 'product_tags.tag_id')
                            ->where('tags.name', 'like', "%{$search}%");
                  });
            });
        }

        return $query->get();
    }
}