<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\RestaurantLocation;

class ProductInsightsSeeder extends Seeder
{
    public function run(): void
    {
        $productIds = Product::pluck('id')->toArray();
        $locationIds = RestaurantLocation::pluck('id')->toArray();
        $used = [];

        for ($i = 0; $i < 100; $i++) {
            $productId = $productIds[array_rand($productIds)];
            $locationId = $locationIds[array_rand($locationIds)];
            $key = "$productId-$locationId";

            if (in_array($key, $used)) {
                continue;
            }
            $used[] = $key;

            DB::table('product_insights')->insert([
                'product_id' => $productId,
                'restaurant_location_id' => $locationId,
                'order_count' => rand(10, 500),
                'avg_rating' => round(rand(20, 50) / 10, 1), // 2.0 to 5.0
                'rating_count' => rand(5, 100),
                'latest_comments' => json_encode([
                    'Great taste!', 'Too salty.', 'Perfectly cooked.', 'Would order again!', 'A bit dry.'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
