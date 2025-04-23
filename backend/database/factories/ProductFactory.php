<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
	{
		static $categoryIds = null;
        
		if (is_null($categoryIds)) {
			$categoryIds = Category::pluck('id')->toArray();
		}

		return [
			'name' => $this->faker->words(2, true),
			'file_name' => $this->faker->word() . '.jpg',
			'description' => $this->faker->sentence(10),
			'price' => $this->faker->randomFloat(2, 5, 100),
			'time_to_deliver' => $this->faker->numberBetween(10, 60) . ' mins',
			'ingredients' => $this->faker->words(5, true),
			'category_id' => $categoryIds[array_rand($categoryIds)],
		];
	}
}
