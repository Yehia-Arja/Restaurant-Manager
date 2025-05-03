<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'restaurant_id' => 'required|exists:restaurants,id',
            'name'          => 'required|string|max:255',
            'file_name'     => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'restaurant_id.required' => 'You must supply a restaurant to attach this category to.',
            'restaurant_id.exists'   => 'That restaurant does not exist.',
            'name.required'          => 'Please give the category a name.',
            'file_name.required'     => 'Please provide a file name.',
        ];
    }
}
