<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // handled in middleware
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'file_name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'time_to_deliver' => 'required|string|max:100',
            'ingredients' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Product name is required.',
            'file_name.required' => 'Image file name is required.',
            'description.required' => 'Product description is required.',
            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a valid number.',
            'price.min' => 'Price must be at least 0.',
            'time_to_deliver.required' => 'Delivery time is required.',
            'ingredients.required' => 'Ingredients must be provided.',
            'category_id.required' => 'Category is required.',
            'category_id.exists' => 'Selected category does not exist.',
        ];
    }
}
