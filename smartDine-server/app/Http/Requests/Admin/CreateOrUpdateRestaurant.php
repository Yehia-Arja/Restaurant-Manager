<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateRestaurant extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'owner_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'file_name' => 'required|string|max:255',
            'description' => 'sometimes|string',
        ];
    }

    public function messages(): array
    {
        return [
            'owner_id.required'  => 'An owner is required.',
            'owner_id.exists'    => 'Selected owner not found.',
            'name.required'      => 'Name is required.',
            'file_name.required' => 'File name is required.',
        ];
    }
}
