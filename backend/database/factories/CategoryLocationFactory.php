<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\RestaurantLocation;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CategoryLocation>
 */
class CategoryLocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $categoryIds = null;
        static $locationIds = null;

        if (is_null($categoryIds)) {
            $categoryIds = Category::pluck('id')->toArray();
        }

        if (is_null($locationIds)) {
            $locationIds = RestaurantLocation::pluck('id')->toArray();
        }

        return [
            'category_id' => $categoryIds[array_rand($categoryIds)],
            'restaurant_location_id' => $locationIds[array_rand($locationIds)],
        ];
    }
}