<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Product;
use App\Models\Table;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        static $userIds = null;
        static $productIds = null;

        if (is_null($userIds)) {
            $userIds = User::pluck('id')->toArray();
        }

        if (is_null($productIds)) {
            $productIds = Product::pluck('id')->toArray();
        }

        $table = Table::inRandomOrder()->first(); // get table with location

        return [
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']),
            'user_id' => $this->faker->randomElement($userIds),
            'product_id' => $this->faker->randomElement($productIds),
            'table_id' => $table->id,
            'restaurant_location_id' => $table->restaurant_location_id, // match the table
        ];
    }
}
