<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        static $categoryIds = null;
        static $restaurantIds = null;

        if (is_null($categoryIds)) {
            $categoryIds = Category::pluck('id')->toArray();
        }

        if (is_null($restaurantIds)) {
            $restaurantIds = Restaurant::pluck('id')->toArray();
        }

        return [
            'name' => $this->faker->words(2, true),
            'file_name' => $this->faker->word() . '.jpg',
            'description' => $this->faker->sentence(10),
            'price' => $this->faker->randomFloat(2, 5, 100),
            'time_to_deliver' => $this->faker->numberBetween(10, 60) . ' mins',
            'ingredients' => $this->faker->words(5, true),
            'category_id' => $this->faker->randomElement($categoryIds),
            'restaurant_id' => $this->faker->randomElement($restaurantIds),
        ];
    }
}
