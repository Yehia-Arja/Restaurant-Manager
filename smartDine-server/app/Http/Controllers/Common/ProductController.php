<?php
// app/Http/Controllers/Common/ProductController.php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Common\ProductRequest;
use App\Services\Common\ProductService;
use App\Http\Resources\Common\ProductResource;

class ProductController extends Controller
{
    /**
     * GET  /api/v0.1/common/products
     * any logged-in user may fetch (and filter/search) products,
     *    see branch overrides, etc.
     */
    public function index(ProductRequest $request)
    {
        try{
            $data = $request->validated();

            $products = ProductService::list(
                $data['restaurant_location_id'] ?? null,
                $data['restaurant_id']          ?? null,
                $data['category_id']            ?? null,
                $data['search']                 ?? null
            );

            if ($products->isEmpty()) {
                return $this->error('No products found', 404);
            }

            return $this->success(
                'Products fetched',
                ProductResource::collection($products)
            );
        }catch(\Throwable $e){
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * GET  /api/v0.1/common/products/{id}
     * fetch a single product by its ID
     */
    public function show(int $id)
    {
        try{
            $product = ProductService::getById($id);

            if (!$product) {
                return $this->error('Product not found', 404);
            }

            return $this->success(
                'Product details',
                new ProductResource($product)
            );
        }catch(\Throwable $e){
            return $this->error($e->getMessage(), 500);
        }
        
    }
}
