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
    public function store(ProductRequest $request)
    {
        try {
            $data = $request->validated();

            $product = ProductService::upsert($data);

            if (!$product) {
                return $this->error('Failed to save product', 500);
            }

            return $this->success(
                'Product saved',
                new ProductResource($product)
            );
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
        
    }

    public function update(ProductRequest $request, int $id)
    {
        try {
            $data = $request->validated();
            $data['id'] = $id;

            $product = ProductService::upsert($data);

            if (!$product) {
                return $this->error('Failed to update product', 500);
            }

            return $this->success(
                'Product updated',
                new ProductResource($product)
            );
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
        
    }

    public function destroy(int $id)
    {
        try {
            $deleted = ProductService::delete($id);

            if (!$deleted) {
                return $this->error('Failed to delete product', 500);
            }

            return $this->success('Product deleted');
            
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
        
    }
}
