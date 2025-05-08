<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\CreateOrUpdateProductRequest;
use App\Services\Owner\ProductService;
use App\Http\Resources\Common\ProductResource;
use Illuminate\Support\Facades\Log;
use Exception;

class ProductController extends Controller
{
    /**
     * Create a new product (with image).
     */
    public function store(CreateOrUpdateProductRequest $request)
    {
        try {
            $product = ProductService::createWithImage(
                $request->validated(),
                $request->file('image')
            );

            if (!$product) {
                return $this->error('Failed to save product', 500);
            }

            return $this->success('Product saved', new ProductResource($product));

        } catch (Exception $e) {
            Log::error('Error in ProductController@store', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->error('Failed to save product', 500);
        }
    }

    /**
     * Update an existing product (with image).
     */
    public function update(CreateOrUpdateProductRequest $request, int $id)
    {
        try {
            $product = ProductService::updateWithImage(
                $id,
                $request->validated(),
                $request->file('image')
            );

            if (!$product) {
                return $this->error('Failed to update product', 500);
            }

            return $this->success('Product updated', new ProductResource($product));

        } catch (Exception $e) {
            Log::error('Error in ProductController@update', [
                'product_id' => $id,
                'error'      => $e->getMessage(),
                'trace'      => $e->getTraceAsString(),
            ]);
            return $this->error('Failed to update product', 500);
        }
    }

    /**
     * Delete a product and its image.
     */
    public function destroy(int $id)
    {
        try {
            $deleted = ProductService::deleteWithImage($id);

            if (!$deleted) {
                return $this->error('Failed to delete product', 500);
            }

            return $this->success('Product deleted');

        } catch (Exception $e) {
            Log::error('Error in ProductController@destroy', [
                'product_id' => $id,
                'error'      => $e->getMessage(),
                'trace'      => $e->getTraceAsString(),
            ]);
            return $this->error('Failed to delete product', 500);
        }
    }
}
