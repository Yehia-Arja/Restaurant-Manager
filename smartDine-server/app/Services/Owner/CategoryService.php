<?php

namespace App\Services\Owner;

use App\Models\Category;
use App\Services\Common\MediaService;
use Illuminate\Http\UploadedFile;

class CategoryService
{
    /**
     * Create a new category with uploaded image.
     */
    public static function create(array $data, UploadedFile $image): Category
    {
        $filename = MediaService::upload($image, 'categories');

        if (!$filename) {
            throw new \Exception('Failed to upload image');
        }
        
        return Category::create([
            'restaurant_id' => $data['restaurant_id'],
            'name'          => $data['name'],
            'file_name'     => $filename,
        ]);
    }

    /**
     * Update an existing category and replace image.
     */
    public static function update(int $id, array $data, UploadedFile $image)
    {
        $category = self::getById($id);
        if (!$category) {
            return null;
        }

        // delete old image
        if ($category->file_name) {
            MediaService::delete($category->file_name, 'categories');
        }

        // upload new image
        $filename = MediaService::upload($image, 'categories');

        $category->update([
            'restaurant_id' => $data['restaurant_id'],
            'name'          => $data['name'],
            'file_name'     => $filename,
        ]);

        return $category;
    }

    /**
     * Delete a category and its image.
     */
    public static function delete(int $id): bool
    {
        $category = self::getById($id);
        if (! $category) {
            return false;
        }

        if ($category->file_name) {
            MediaService::delete($category->file_name, 'categories');
        }

        return $category->delete();
    }

    /**
     * Fetch a single category by ID.
     */
    public static function getById(int $id)
    {
        return Category::find($id);
    }
}
