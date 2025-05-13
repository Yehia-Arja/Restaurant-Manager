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
<<<<<<< HEAD
            'restaurant_location_id' => 'sometimes|exists:restaurant_locations,id',
            'restaurant_id'          => 'sometimes|exists:restaurants,id',
=======
            'restaurant_location_id' => 'required_without:restaurant_id|exists:restaurant_locations,id',
            'restaurant_id'          => 'required_without:restaurant_location_id|exists:restaurants,id',
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
            'category_id'            => 'sometimes|exists:categories,id',
            'search'                 => 'sometimes|string',
        ];
    }

    public function messages(): array
    {
        return [
<<<<<<< HEAD
            'restaurant_location_id.exists' => 'Branch not found.',
            'restaurant_id.exists'          => 'Restaurant not found.',
            'category_id.exists'            => 'Category not found.',
=======
            'restaurant_location_id.required_without' => 'Either branch or restaurant must be provided.',
            'restaurant_location_id.exists'           => 'Branch not found.',
            'restaurant_id.required_without'          => 'Either restaurant or branch must be provided.',
            'restaurant_id.exists'                    => 'Restaurant not found.',
            'category_id.exists'                      => 'Category not found.',
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
        ];
    }
}
