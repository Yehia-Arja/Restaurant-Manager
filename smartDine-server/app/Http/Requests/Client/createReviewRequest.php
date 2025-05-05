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
            'rating'  => 'required|integer|between:1,5',
            'comment' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'rating.required'  => 'Please provide a rating (1–5).',
            'rating.integer'   => 'Rating must be a number.',
            'rating.between'   => 'Rating must be between 1 and 5.',
            'comment.string'   => 'Comment must be text.',
        ];
    }
}
