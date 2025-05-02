<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Product;
use App\Models\Table;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        static $clients = null;
        static $waiters = null;
        static $productIds = null;

        if (is_null($clients)) {
            $clients = User::where('user_type_id', 4)->pluck('id')->toArray(); // clients
        }

        if (is_null($waiters)) {
            $waiters = User::where('user_type_id', 3)
                ->whereHas('staffLocations', function ($q) {
                    $q->where('role', 'waiter');
                })
                ->pluck('id')
                ->toArray(); // waiters with role = waiter
        }

        if (is_null($productIds)) {
            $productIds = Product::pluck('id')->toArray();
        }

        $table = Table::inRandomOrder()->first();

        return [
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']),
            'user_id' => $this->faker->randomElement($clients),
            'waiter_id' => $this->faker->randomElement($waiters),
            'product_id' => $this->faker->randomElement($productIds),
            'table_id' => $table->id,
            'restaurant_location_id' => $table->restaurant_location_id,
        ];
    }
}
