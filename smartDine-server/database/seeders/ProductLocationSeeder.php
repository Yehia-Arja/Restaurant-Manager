<?php

namespace Database\Seeders;

use App\Models\ProductLocation;
use App\Models\ProductTag;
use App\Models\RestaurantLocation;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productIds = Product::pluck('id')->toArray();
        $locationIds = RestaurantLocation::pluck('id')->toArray();

        $used = [];

        for ($i = 0; $i < 50; $i++) {
            do {
                $productId = $productIds[array_rand($productIds)];
                $locationId = $locationIds[array_rand($locationIds)];
                $key = $productId . '-' . $locationId;
            } while (in_array($key, $used));

            $used[] = $key;

            ProductLocation::factory()->create([
                'product_id' => $productId,
                'restaurant_location_id' => $locationId,
            ]);
        }
    }
}
