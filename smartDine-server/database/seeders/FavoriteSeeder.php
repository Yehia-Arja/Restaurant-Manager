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

        // Product favorites
        for ($i = 0; $i < 50; $i++) {
            do {
                $userId = $userIds[array_rand($userIds)];
                $productId = $productIds[array_rand($productIds)];
                $key = "$userId-product-$productId";
            } while (in_array($key, $usedProductKeys));
            $usedProductKeys[] = $key;

            Favorite::create([
                'user_id' => $userId,
                'favoritable_id' => $productId,
                'favoritable_type' => Product::class,
            ]);
        }

        // Restaurant favorites
        for ($i = 0; $i < 30; $i++) {
            do {
                $userId = $userIds[array_rand($userIds)];
                $restaurantId = $restaurantIds[array_rand($restaurantIds)];
                $key = "$userId-restaurant-$restaurantId";
            } while (in_array($key, $usedRestaurantKeys));
            $usedRestaurantKeys[] = $key;

            Favorite::create([
                'user_id' => $userId,
                'favoritable_id' => $restaurantId,
                'favoritable_type' => Restaurant::class,
            ]);
        }
    }
}
