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

<<<<<<< HEAD
        // Seed product favorites
=======
        // Product favorites
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
        for ($i = 0; $i < 50; $i++) {
            do {
                $userId = $userIds[array_rand($userIds)];
                $productId = $productIds[array_rand($productIds)];
<<<<<<< HEAD
                $key = "$userId-$productId";
=======
                $key = "$userId-product-$productId";
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
            } while (in_array($key, $usedProductKeys));
            $usedProductKeys[] = $key;

            Favorite::create([
                'user_id' => $userId,
<<<<<<< HEAD
                'product_id' => $productId,
                'restaurant_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Seed restaurant favorites
=======
                'favoritable_id' => $productId,
                'favoritable_type' => Product::class,
            ]);
        }

        // Restaurant favorites
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
        for ($i = 0; $i < 30; $i++) {
            do {
                $userId = $userIds[array_rand($userIds)];
                $restaurantId = $restaurantIds[array_rand($restaurantIds)];
<<<<<<< HEAD
                $key = "$userId-$restaurantId";
=======
                $key = "$userId-restaurant-$restaurantId";
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
            } while (in_array($key, $usedRestaurantKeys));
            $usedRestaurantKeys[] = $key;

            Favorite::create([
                'user_id' => $userId,
<<<<<<< HEAD
                'product_id' => null,
                'restaurant_id' => $restaurantId,
                'created_at' => now(),
                'updated_at' => now(),
=======
                'favoritable_id' => $restaurantId,
                'favoritable_type' => Restaurant::class,
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
            ]);
        }
    }
}
