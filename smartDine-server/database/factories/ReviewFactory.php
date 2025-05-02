<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    public function definition(): array
    {
        static $orders = null;
        static $restaurants = null;

        if (is_null($orders)) {
            $orders = Order::with(['user'])->get(); // preload users and waiter
        }

        if (is_null($restaurants)) {
            $restaurants = Restaurant::pluck('id')->toArray();
        }

        $order = $orders->random();
        $clientId = $order->user_id;

        $type = $this->faker->randomElement(['product', 'order', 'restaurant', 'waiter']);

        return [
            'user_id' => $clientId,
            'reviewable_id'  => match ($type) {
                'product'    => $order->product_id,
                'order'      => $order->id,
                'restaurant' => $this->faker->randomElement($restaurants),
                'waiter'     => $order->waiter_id,
            },
            'reviewable_type' => match ($type) {
                'product'     => Product::class,
                'order'       => Order::class,
                'restaurant'  => Restaurant::class,
                'waiter'      => User::class,
            },
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->optional()->sentence(),
        ];
    }
}
