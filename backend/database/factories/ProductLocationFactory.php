<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\RestaurantLocation;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductLocation>
 */
class ProductLocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $productIds = null;
        static $locationIds = null;

        if (is_null($productIds)) {
            $productIds = Product::pluck('id')->toArray();
        }

        if (is_null($locationIds)) {
            $locationIds = RestaurantLocation::pluck('id')->toArray();
        }

        return [
            'product_id' => $productIds[array_rand($productIds)],
            'restaurant_location_id' => $locationIds[array_rand($locationIds)],
            'override_price' => $this->faker->optional()->randomFloat(2, 5, 40),
            'override_description' => $this->faker->optional()->sentence(),
        ];
    }
}
