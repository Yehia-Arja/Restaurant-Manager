<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\RestaurantLocation;
use App\Models\CategoryLocation;

class CategoryLocationSeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds = Category::pluck('id')->toArray();
        $locationIds = RestaurantLocation::pluck('id')->toArray();
        $used = [];

        for ($i = 0; $i < 50; $i++) {
            do {
                $categoryId = $categoryIds[array_rand($categoryIds)];
                $locationId = $locationIds[array_rand($locationIds)];
                $key = "$categoryId-$locationId";
            } while (in_array($key, $used));

            $used[] = $key;

            CategoryLocation::create([
                'category_id'            => $categoryId,
                'restaurant_location_id' => $locationId,
            ]);
        }
    }
}
