<?php

namespace App\Services\Common;

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
    public static function delete(int $id): bool
    {
        return Category::destroy($id) > 0;
    }


    /**
     * List categories, filtered optionally by branch or by restaurant.
     *
     * @param  int|null  $branchId
     * @param  int|null  $restaurantId
     * @return Collection|Category[]
     */
    public static function list(
        ?int $branchId     = null,
        ?int $restaurantId = null
    ): Collection {
        $q = Category::query();

        if ($branchId) {
            // only those categories made available at this branch
            $q->select('categories.*')
              ->join('locationables as loc', function($join) use ($branchId) {
                  $join->on('loc.locationable_id', '=', 'categories.id')
                       ->where('loc.locationable_type',  'Category')
                       ->where('loc.restaurant_location_id', $branchId);
              });
        }
        elseif ($restaurantId) {
            // brand level list of all categories for that restaurant
            $q->where('restaurant_id', $restaurantId);
        }

        return $q->get();
    }
}
