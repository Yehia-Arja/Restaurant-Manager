<?php

namespace App\Services\Owner;

use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryService
{
    /**
     * Create or update a category in one go.
     *
     * If 'id' is present in $data, it will update that record;
     * otherwise it will insert a new one.
     *
     * @param  array  $data  [
     *     'id'            => (int|null), 
     *     'restaurant_id' => int,
     *     'name'          => string,
     *     'file_name'     => string,
     * ]
     * @return Category
     */
    public static function upsert(array $data): Category
    {
        return Category::updateOrCreate(
            // find by id if given, else create
            ['id' => $data['id'] ?? null],
            [
                'restaurant_id' => $data['restaurant_id'],
                'name'          => $data['name'],
                'file_name'     => $data['file_name'],
            ]
        );
    }

    /**
     * Delete a category by ID.
     */
    public static function deleteCategory(int $id): bool
    {
        return Category::destroy($id) > 0;
    }
}
