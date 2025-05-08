<?php

namespace App\Services\Admin;

use App\Models\Restaurant;
use App\Services\Common\MediaService;
use Illuminate\Http\UploadedFile;

class RestaurantService
{
    /**
     * Create a new restaurant with uploaded image.
     *
     * @param  array         $data     (validated)
     * @param  UploadedFile  $image
     * @return Restaurant
     */
    public static function create(array $data, UploadedFile $image): Restaurant
    {
        $filename = MediaService::upload($image, 'restaurants');

        return Restaurant::create([
            'owner_id'    => $data['owner_id'],
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
            'file_name'   => $filename,
        ]);
    }

    /**
     * Update an existing restaurant and replace image.
     *
     * @param  int           $id
     * @param  array         $data     (validated)
     * @param  UploadedFile  $image
     */
    public static function update(int $id, array $data, UploadedFile $image)
    {
        $restaurant = self::getById($id);
        if (!$restaurant) {
            return null;
        }

        // Delete old image
        if ($restaurant->file_name) {
            MediaService::delete($restaurant->file_name, 'restaurants');
        }

        // Upload new image
        $filename = MediaService::upload($image, 'restaurants');

        $restaurant->update([
            'owner_id'    => $data['owner_id'],
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
            'file_name'   => $filename,
        ]);

        return $restaurant;
    }

    /**
     * Delete a restaurant and its image.
     *
     * @param  int $id
     * @return bool
     */
    public static function delete(int $id): bool
    {
        $restaurant = self::getById($id);
        if (!$restaurant) {
            return false;
        }

        if ($restaurant->file_name) {
            MediaService::delete($restaurant->file_name, 'restaurants');
        }

        return $restaurant->delete();
    }

    /**
     * Fetch restaurant by ID.
     *
     * @param  int $id
     *
     */
    public static function getById(int $id)
    {
        return Restaurant::find($id);
    }
}
