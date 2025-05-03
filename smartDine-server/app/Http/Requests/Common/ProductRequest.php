<?php

namespace App\Http\Requests\Common;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'restaurant_location_id' => 'sometimes|exists:restaurant_locations,id',
            'restaurant_id'          => 'sometimes|exists:restaurants,id',
            'category_id'            => 'sometimes|exists:categories,id',
            'search'                 => 'sometimes|string',
        ];
    }

    public function messages(): array
    {
        return [
            'restaurant_location_id.exists' => 'Branch not found.',
            'restaurant_id.exists'          => 'Restaurant not found.',
            'category_id.exists'            => 'Category not found.',
        ];
    }
}
