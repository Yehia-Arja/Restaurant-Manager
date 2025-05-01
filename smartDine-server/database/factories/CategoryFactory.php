<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Restaurant;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    public function definition(): array
    {
        static $restaurantIds = null;

        if (is_null($restaurantIds)) {
            $restaurantIds = Restaurant::pluck('id')->toArray();
        }

        return [
            'name' => $this->faker->word(),
            'file_name' => $this->faker->word() . '.jpg',
            'restaurant_id' => $this->faker->randomElement($restaurantIds),
        ];
    }
}
