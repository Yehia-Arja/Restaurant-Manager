<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Product;
use App\Models\Table;
use App\Models\RestaurantLocation;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $userIds = null;
        static $productIds = null;
        static $tableIds = null;
        static $locationIds = null;

        if (is_null($userIds)) {
            $userIds = User::pluck('id')->toArray();
        }

        if (is_null($productIds)) {
            $productIds = Product::pluck('id')->toArray();
        }

        if (is_null($tableIds)) {
            $tableIds = Table::pluck('id')->toArray();
        }

        if (is_null($locationIds)) {
            $locationIds = RestaurantLocation::pluck('id')->toArray();
        }

        return [
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']),
            'user_id' => $userIds[array_rand($userIds)],
            'product_id' => $productIds[array_rand($productIds)],
            'table_id' => $tableIds[array_rand($tableIds)],
            'restaurant_location_id' => $locationIds[array_rand($locationIds)],
        ];
    }
}
