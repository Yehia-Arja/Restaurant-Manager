<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // handled in middleware
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'file_name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'time_to_deliver' => 'sometimes|string|max:100',
            'ingredients' => 'sometimes|string',
            'category_id' => 'sometimes|exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Product name must be a string.',
            'file_name.string' => 'Image file name must be a string.',
            'description.string' => 'Description must be text.',
            'price.numeric' => 'Price must be a valid number.',
            'price.min' => 'Price must be at least 0.',
            'time_to_deliver.string' => 'Delivery time must be a string.',
            'ingredients.string' => 'Ingredients must be a string.',
            'category_id.exists' => 'Selected category does not exist.',
        ];
    }
}
