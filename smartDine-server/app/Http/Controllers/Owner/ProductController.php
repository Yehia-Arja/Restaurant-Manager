<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\CreateOrUpdateProductRequest;
use Illuminate\Http\Request;
use App\Services\Owner\ProductService;
use App\Http\Resources\Common\ProductResource;

class ProductController extends Controller
{
    public function store(CreateOrUpdateProductRequest $request)
    {
        $data = $request->validated();
        
        $product = ProductService::upsert($data);

        if (!$product) {
            return $this->error('Failed to save product', 500);
        }

        return $this->success(
            'Product saved',
            new ProductResource($product)
        );
    }

    public function update(CreateOrUpdateProductRequest $request, int $id)
    {
        $data = $request->validated();
        $data['id'] = $id; // Ensure the ID is included in the data
        
        $product = ProductService::upsert($data);

        if (!$product) {
            return $this->error('Failed to update product', 500);
        }

        return $this->success(
            'Product updated',
            new ProductResource($product)
        );
    }

    public function destroy(int $id)
    {
        $deleted = ProductService::delete($id);

        if (!$deleted) {
            return $this->error('Failed to delete product', 500);
        }

        return $this->success('Product deleted');
    }
}
