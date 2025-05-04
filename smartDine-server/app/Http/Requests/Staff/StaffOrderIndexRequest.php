<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;

class StaffOrderIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'restaurant_location_id' => 'required|exists:restaurant_locations,id',
            'table_id'               => 'required|exists:tables,id',
        ];
    }

    public function messages(): array
    {
        return [
            'restaurant_location_id.required' => 'Branch is required.',
            'restaurant_location_id.exists'   => 'Branch not found.',
            'table_id.required'               => 'Table is required.',
            'table_id.exists'                 => 'Table not found.',
        ];
    }
}
