<?php

namespace App\Http\Requests\Common;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // list for a branch or for a whole restaurant
            'restaurant_location_id' => 'sometimes|exists:restaurant_locations,id',
            'restaurant_id'          => 'sometimes|exists:restaurants,id',
        ];
    }

    public function messages(): array
    {
        return [
            'restaurant_location_id.exists' => 'Branch not found.',
            'restaurant_id.exists'          => 'Restaurant not found.',
        ];
    }
}
