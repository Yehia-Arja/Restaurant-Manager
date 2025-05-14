<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\Models\Table;

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
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function (Validator $v) {
            $tableId = $this->input('table_id');
            $locationId = $this->input('restaurant_location_id');

            if ($tableId && $locationId) {
                $valid = Table::where('id', $tableId)
                    ->where('restaurant_location_id', $locationId)
                    ->exists();

                if (!$valid) {
                    $v->errors()->add('table_id', 'This table does not belong to the selected branch.');
                }
            }
        });
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
