<?php

namespace App\Http\Requests\Common;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'      => 'sometimes|required|string|max:255',
            'file_name' => 'sometimes|required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Please give the category a name.',
            'file_name.required' => 'Please provide a file name.',
        ];
    }
}
