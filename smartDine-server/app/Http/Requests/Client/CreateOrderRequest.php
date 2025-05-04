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
            'table_id'               => 'required|exists:tables,id',
            'status'                 => 'nullable|in:pending,completed,cancelled',
        ];
    }

    public function messages(): array
    {
        return [
            'restaurant_location_id.required' => 'Branch is required.',
            'restaurant_location_id.exists'   => 'Branch not found.',
            'product_id.required'             => 'Product is required.',
            'product_id.exists'               => 'Product not found.',
            'table_id.required'               => 'Table is required.',
            'table_id.exists'                 => 'Table not found.',
        ];
    }
}
