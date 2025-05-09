<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateRestaurantLocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'restaurant_id' => 'required|exists:restaurants,id',
            'location_name' => 'required|string|max:255',
            'address'       => 'required|string|max:500',
            'city'          => 'required|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'restaurant_id.required' => 'Restaurant is required.',
            'restaurant_id.exists'   => 'Restaurant not found.',
            'location_name.required' => 'Branch name is required.',
            'address.required'       => 'Address is required.',
            'city.required'          => 'City is required.',
        ];
    }
}
