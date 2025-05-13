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
<<<<<<< HEAD
=======
     * Ensures unique product-tag combinations.
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
<<<<<<< HEAD
        static $productIds = null;
        static $tagIds = null;

        if (is_null($productIds)) {
            $productIds = Product::pluck('id')->toArray();
        }

        if (is_null($tagIds)) {
            $tagIds = Tag::pluck('id')->toArray();
        }

        return [
            'product_id' => $this->faker->randomElement($productIds),
            'tag_id' => $this->faker->randomElement($tagIds),
=======
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
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
        ];
    }
}