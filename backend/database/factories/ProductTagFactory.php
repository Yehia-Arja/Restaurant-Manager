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
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $productIds = null;
        static $tagIds = null;

        if (is_null($productIds)) {
            $productIds = Product::pluck('id')->toArray();
        }

        if (is_null($tagIds)) {
            $tagIds = Tag::pluck('id')->toArray();
        }

        return [
            'product_id' => $productIds[array_rand($productIds)],
            'tag_id' => $tagIds[array_rand($tagIds)],
        ];
    }
}