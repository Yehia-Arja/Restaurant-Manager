<?php

namespace Database\Factories;

use App\Models\RestaurantLocation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
	{
		static $locationIds = null;

		if (is_null($locationIds)) {
			$locationIds = RestaurantLocation::pluck('id')->toArray();
		}

		return [
			'name' => $this->faker->word(),
			'file_name' => $this->faker->word() . '.jpg',
			'restaurant_location_id' => $locationIds[array_rand($locationIds)],
		];
	}
}
