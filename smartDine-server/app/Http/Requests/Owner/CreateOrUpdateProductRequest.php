<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'            => 'required|string|max:255',
            'image'           => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description'     => 'required|string',
            'price'           => 'required|numeric|min:0',
            'time_to_deliver' => 'required|string|max:100',
            'ingredients'     => 'required|string',
            'category_id'     => 'required|exists:categories,id',
            'restaurant_id'   => 'required|exists:restaurants,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'            => 'Product name is required.',
            'image.required'           => 'Please upload a product image.',
            'image.image'              => 'The file must be an image.',
            'image.mimes'              => 'Allowed image types: jpeg, png, jpg, gif.',
            'image.max'                => 'Image size must be under 2 MB.',
            'description.required'     => 'Product description is required.',
            'price.required'           => 'Price is required.',
            'price.numeric'            => 'Price must be a valid number.',
            'price.min'                => 'Price must be at least 0.',
            'time_to_deliver.required' => 'Delivery time is required.',
            'ingredients.required'     => 'Ingredients must be provided.',
            'category_id.required'     => 'Category is required.',
            'category_id.exists'       => 'Selected category does not exist.',
            'restaurant_id.required'   => 'Restaurant is required.',
            'restaurant_id.exists'     => 'Selected restaurant does not exist.',
        ];
    }
}
