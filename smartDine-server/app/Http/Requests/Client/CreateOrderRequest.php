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
            'product_id'              => 'required|exists:products,id',
            'table_id'                => 'required|exists:tables,id',
            'restaurant_location_id'  => 'required|exists:restaurant_locations,id',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Please select a product.',
            'product_id.exists'   => 'That product does not exist.',
            'table_id.required'   => 'Please select a table.',
            'table_id.exists'     => 'That table does not exist.',
            'restaurant_location_id.required' => 'Branch is required.',
            'restaurant_location_id.exists'   => 'That branch does not exist.',
        ];
    }
}
