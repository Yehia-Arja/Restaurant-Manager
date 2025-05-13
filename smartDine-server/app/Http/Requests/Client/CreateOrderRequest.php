<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'restaurant_location_id' => 'required|exists:restaurant_locations,id',
            'product_id'             => 'required|exists:products,id',
            'table_number'           => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'restaurant_location_id.required' => 'Branch is required.',
            'restaurant_location_id.exists'   => 'Branch not found.',
            'product_id.required'             => 'Product is required.',
            'product_id.exists'               => 'Product not found.',
            'table_number.required'           => 'Table number is required.',
        ];
    }
}
