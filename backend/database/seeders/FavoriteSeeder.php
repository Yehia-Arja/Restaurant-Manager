<?php

namespace Database\Seeders;

use App\Models\Favorite;
use App\Models\Product;
use App\Models\RestaurantLocation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = User::pluck('id')->toArray();
        $productIds = Product::pluck('id')->toArray();
        $locationIds = RestaurantLocation::pluck('id')->toArray();

        $used = [];

        for ($i = 0; $i < 50; $i++) {
            do {
                $userId = $userIds[array_rand($userIds)];
                $productId = $productIds[array_rand($productIds)];
                $key = $userId . '-' . $productId;
            } while (in_array($key, $used));

            $used[] = $key;

            Favorite::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'restaurant_location_id' => $locationIds[array_rand($locationIds)],
            ]);
        }
    }
}
