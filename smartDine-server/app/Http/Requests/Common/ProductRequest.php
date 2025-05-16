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
            'restaurant_location_id' => 'required_without:restaurant_id|exists:restaurant_locations,id',
            'restaurant_id'          => 'required_without:restaurant_location_id|exists:restaurants,id',
            'category_id'            => 'sometimes|exists:categories,id',
            'search'                 => 'sometimes|string',
            'favorites_only'         => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'restaurant_location_id.required_without' => 'Either branch or restaurant must be provided.',
            'restaurant_location_id.exists'           => 'Branch not found.',
            'restaurant_id.required_without'          => 'Either restaurant or branch must be provided.',
            'restaurant_id.exists'                    => 'Restaurant not found.',
            'category_id.exists'                      => 'Category not found.',
        ];
    }
}
