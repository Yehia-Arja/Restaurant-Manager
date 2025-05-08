<?php

namespace App\Services\Owner;

use App\Models\Product;
use App\Services\Common\MediaService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class ProductService
{
    /**
     * Create a product and upload its image in one atomic transaction.
     *
     * @param  array         $data
     * @param  UploadedFile  $file
     * @return Product
     */
    public static function createWithImage(array $data, UploadedFile $file): Product
    {
        return DB::transaction(function() use ($data, $file) {
            $filename = MediaService::upload($file, 'products');
            $data['file_name'] = $filename;
            return Product::create($data);
        });
    }

    /**
     * Update a product (by ID) and replace its image.
     *
     * @param  int           $id
     * @param  array         $data
     * @param  UploadedFile  $file
     * @return Product
     */
    public static function updateWithImage(int $id, array $data, UploadedFile $file): Product
    {
        return DB::transaction(function() use ($id, $data, $file) {
            $product = Product::findOrFail($id);

            // delete old image
            MediaService::delete($product->file_name, 'products');

            // upload new
            $filename = MediaService::upload($file, 'products');
            $data['file_name'] = $filename;

            $product->update($data);
            return $product;
        });
    }

    /**
     * Delete a product (by ID) and its image.
     *
     * @param  int  $id
     * @return bool
     */
    public static function deleteWithImage(int $id): bool
    {
        return DB::transaction(function() use ($id) {
            $product = Product::findOrFail($id);
            MediaService::delete($product->file_name, 'products');
            return $product->delete();
        });
    }
}
