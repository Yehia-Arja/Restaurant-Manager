<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\CreateOrUpdateProductRequest;
use App\Services\Common\MediaService;
use App\Services\Owner\ProductService;
use App\Http\Resources\Common\ProductResource;

class ProductController extends Controller
{
    public function store(CreateOrUpdateProductRequest $request,  MediaService $media) 
    {
        // Upload image and get back the stored filename
        $filename = $media->upload($request->file('image'));

        // Merge filename into validated data
        $data = array_merge(
            $request->validated(),
            ['file_name' => $filename]
        );

        // Create the product
        $product = ProductService::upsert($data);

        if (!$product) {
            return $this->error('Failed to save product', 500);
        }

        return $this->success(
            'Product saved',
            new ProductResource($product)
        );
    }

    public function update(CreateOrUpdateProductRequest $request,int $id,MediaService $media) 
    {
        // Upload new image
        $filename = $media->upload($request->file('image'));

        // Merge id + filename into data
        $data = array_merge(
            $request->validated(),
            ['id' => $id, 'file_name' => $filename]
        );

        // Update the product
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
