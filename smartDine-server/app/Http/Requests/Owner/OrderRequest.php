<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'restaurant_id'          => 'sometimes|exists:restaurants,id',
            'restaurant_location_id' => 'sometimes|exists:restaurant_locations,id',
        ];
    }

    public function messages(): array
    {
        return [
            'restaurant_id.exists'           => 'Restaurant not found.',
            'restaurant_location_id.exists'  => 'Branch not found.',
        ];
    }
}
