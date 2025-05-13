<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Product;
use App\Models\RestaurantLocation;

class LocationableSeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds = Category::pluck('id')->toArray();
        $productIds = Product::pluck('id')->toArray();
        $locationIds = RestaurantLocation::pluck('id')->toArray();

        $used = [];

        // Seed categories per branch
        for ($i = 0; $i < 50; $i++) {
            do {
                $categoryId = $categoryIds[array_rand($categoryIds)];
                $locationId = $locationIds[array_rand($locationIds)];
                $key = "$categoryId-Category-$locationId";
            } while (in_array($key, $used));
            $used[] = $key;

            DB::table('locationables')->insert([
                'locationable_id' => $categoryId,
<<<<<<< HEAD
                'locationable_type' => 'Category',
=======
                'locationable_type' => Category::class,
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
                'restaurant_location_id' => $locationId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Seed products per branch with override
        for ($i = 0; $i < 100; $i++) {
            do {
                $productId = $productIds[array_rand($productIds)];
                $locationId = $locationIds[array_rand($locationIds)];
                $key = "$productId-Product-$locationId";
            } while (in_array($key, $used));
            $used[] = $key;

            DB::table('locationables')->insert([
                'locationable_id' => $productId,
<<<<<<< HEAD
                'locationable_type' => 'Product',
=======
                'locationable_type' => Product::class,
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
                'restaurant_location_id' => $locationId,
                'override_price' => rand(10, 50),
                'override_description' => 'Custom description for this branch.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
