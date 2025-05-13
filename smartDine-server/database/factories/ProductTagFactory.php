<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Tag;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductTag>
 */
class ProductTagFactory extends Factory
{
    /**
     * Define the model's default state.
     * Ensures unique product-tag combinations.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $seen = [];
        static $productIds = null;
        static $tagIds = null;

        // Load IDs once
        $productIds = $productIds ?? Product::pluck('id')->toArray();
        $tagIds = $tagIds ?? Tag::pluck('id')->toArray();

        do {
            $productId = $this->faker->randomElement($productIds);
            $tagId = $this->faker->randomElement($tagIds);
            $key = "{$productId}-{$tagId}";
        } while (in_array($key, $seen));

        // Mark as used
        $seen[] = $key;

        return [
            'product_id' => $productId,
            'tag_id'     => $tagId,
        ];
    }
}