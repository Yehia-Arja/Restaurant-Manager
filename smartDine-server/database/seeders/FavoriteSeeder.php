<?php

namespace Database\Seeders;

use App\Models\Favorite;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = User::pluck('id')->toArray();
        $productIds = Product::pluck('id')->toArray();
        $restaurantIds = Restaurant::pluck('id')->toArray();

        $usedProductKeys = [];
        $usedRestaurantKeys = [];

        // Seed product favorites
        for ($i = 0; $i < 50; $i++) {
            do {
                $userId = $userIds[array_rand($userIds)];
                $productId = $productIds[array_rand($productIds)];
                $key = "$userId-$productId";
            } while (in_array($key, $usedProductKeys));
            $usedProductKeys[] = $key;

            Favorite::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'restaurant_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Seed restaurant favorites
        for ($i = 0; $i < 30; $i++) {
            do {
                $userId = $userIds[array_rand($userIds)];
                $restaurantId = $restaurantIds[array_rand($restaurantIds)];
                $key = "$userId-$restaurantId";
            } while (in_array($key, $usedRestaurantKeys));
            $usedRestaurantKeys[] = $key;

            Favorite::create([
                'user_id' => $userId,
                'product_id' => null,
                'restaurant_id' => $restaurantId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
