<?php

namespace App\Services\Common;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ProductService
{
    /**
     * Create a new product for the current owner's first restaurant.
     */
    public static function createProduct(array $data): Product
    {
        $data['restaurant_id'] = Auth::user()
            ->restaurants()
            ->first()
            ->id;

        return Product::create($data);
    }

    /**
     * Update an existing product.
     */
    public static function updateProduct(Product $product, array $data): Product
    {
        $product->update($data);
        return $product;
    }

    /**
     * Fetch every product in a given restaurant (owner view).
     */
    public static function forOwner(int $restaurantId): Collection
    {
        return Product::where('restaurant_id', $restaurantId)
                      ->get();
    }

    /**
     * Fetch products available at a branch, with optional category & search filters.
     * Always returns override_price & override_description from the pivot.
     */
    public static function forBranch(
        int     $branchId,
        ?int    $categoryId = null,
        ?string $search     = null
    ): Collection {
        $q = Product::select([
                'products.*',
                'loc.override_price',
                'loc.override_description',
            ])
            ->join('locationables as loc', function($join) use ($branchId) {
                $join->on('loc.locationable_id', '=', 'products.id')
                     ->where('loc.locationable_type',       'Product')
                     ->where('loc.restaurant_location_id', $branchId);
            });

        if ($categoryId) {
            $q->where('products.category_id', $categoryId);
        }

        if ($search) {
            $q->where(function($sub) use ($search) {
                $sub->where('products.name', 'like', "%{$search}%")
                    ->orWhereIn('products.id', function($inner) use ($search) {
                        $inner->select('product_id')
                              ->from('product_tags')
                              ->join('tags', 'tags.id', '=', 'product_tags.tag_id')
                              ->where('tags.name', 'like', "%{$search}%");
                    });
            });
        }

        return $q->get();
    }
}
