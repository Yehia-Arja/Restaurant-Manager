<?php

namespace App\Services\IntentHandlers;

use App\Models\Product;
use Illuminate\Support\Collection;

class ProductIntentHandler
{
    public static function handle(array $data): string
    {
        $query = Product::query();

        // Filter by product name
        if (!empty($data['product_name'])) {
            $query->where('name', 'LIKE', '%' . $data['product_name'] . '%');
        }

        // Filter by tags
        if (!empty($data['tags'])) {
            $tags = array_map('trim', explode(',', $data['tags']));
            $query->whereHas('tags', fn($q) => $q->whereIn('name', $tags));
        }

        // Filter by category
        if (!empty($data['category'])) {
            $query->whereHas('category', fn($q) =>
                $q->where('name', 'LIKE', '%' . $data['category'] . '%')
            );
        }

        // Filter by branch location via polymorphic 'locations'
        if (!empty($data['branch_id'])) {
            $query->whereHas('locations', fn($q) =>
                $q->where('restaurant_location_id', $data['branch_id'])
            );
        }

        $products = $query->with('tags', 'category')->take(3)->get();

        if ($products->isEmpty()) {
            return "Sorry, I couldn’t find anything matching that.";
        }

        $names = $products->pluck('name')->implode(", ");
        return "Here’s what I found: {$names}";
    }
}
