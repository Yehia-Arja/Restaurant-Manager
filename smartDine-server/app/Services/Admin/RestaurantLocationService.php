<?php

namespace App\Services\Admin;

use App\Models\RestaurantLocation;

class RestaurantLocationService
{
    public static function create(array $data): RestaurantLocation
    {
        return RestaurantLocation::create([
            'restaurant_id' => $data['restaurant_id'],
            'location_name' => $data['location_name'],
            'address'       => $data['address'],
            'city'          => $data['city'],
        ]);
    }

    public static function update(int $id, array $data)
    {
        $loc = self::getById($id);
        if (!$loc) {
            return null;
        }

        $loc->update([
            'restaurant_id' => $data['restaurant_id'],
            'location_name' => $data['location_name'],
            'address'       => $data['address'],
            'city'          => $data['city'],
        ]);

        return $loc;
    }

    public static function delete(int $id): bool
    {
        $loc = self::getById($id);
        if (!$loc) {
            return false;
        }

        return $loc->delete();
    }

    public static function getById(int $id)
    {
        return RestaurantLocation::find($id);
    }
}
