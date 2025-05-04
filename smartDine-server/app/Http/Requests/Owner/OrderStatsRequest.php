<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;

class OrderStatsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'restaurant_id'            => 'required_without:restaurant_location_id|integer|exists:restaurants,id',
            'restaurant_location_id'   => 'required_without:restaurant_id|integer|exists:restaurant_locations,id',
        ];
    }

    public function messages(): array
    {
        return [
            'restaurant_id.required_without'          => 'Either restaurant_id or restaurant_location_id is required.',
            'restaurant_location_id.required_without' => 'Either restaurant_location_id or restaurant_id is required.',
            'restaurant_id.exists'                    => 'That restaurant does not exist.',
            'restaurant_location_id.exists'           => 'That branch does not exist.',
        ];
    }
}
