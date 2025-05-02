<?php

namespace App\Services\Owner;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductService
{
    public static function createProduct(array $data): ?Product
    {
        $data['restaurant_id'] = Auth::user()->restaurant->id;
        return Product::create($data);
    }

    public static function updateProduct(Product $product, array $data): Product
    {
        $product->update($data);
        return $product;
    }
}
