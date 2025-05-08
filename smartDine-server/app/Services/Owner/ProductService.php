<?php

namespace App\Services\Owner;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ProductService
{
    /**
     * Create a new or update product.
     */
    public static function upsert(array $data): Product
    {
        // Create or update the product
        return Product::updateOrCreate(
            ['id' => $data['id'] ?? null],
            [
                'restaurant_id'    => $data['restaurant_id'],
                'name'             => $data['name'],
                'description'      => $data['description'] ?? null,
                'time_to_deliver'  => $data['time_to_deliver'] ?? null,
                'ingredients'      => $data['ingredients'] ?? null,
                'file_name'        => $data['file_name'] ?? null,
                'category_id'      => $data['category_id'] ?? null,
                'price'            => $data['price'],
            ]
        );
    }

    
    public static function delete(int $id): bool
    {
        // Delete the product by ID
        return Product::destroy($id) > 0;
    }

}