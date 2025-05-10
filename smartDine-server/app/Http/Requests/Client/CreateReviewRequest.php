<?php
namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class CreateReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reviewable_type' => 'required|string|in:product,restaurant,branch,waiter',
            'reviewable_id'   => 'required|integer',
            'rating'          => 'required|integer|min:1|max:5',
            'comment'         => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'reviewable_type.in' => 'reviewable_type must be one of: product, restaurant, branch or waiter.',
            'reviewable_id.required' => 'You must specify the ID of the item being reviewed.',
            'rating.min' => 'Rating must be at least 1 star.',
            'rating.max' => 'Rating cannot exceed 5 stars.',
        ];
    }
}
