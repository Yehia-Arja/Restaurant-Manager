<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateRestaurantRequest extends FormRequest
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
<<<<<<< HEAD
            'owner_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'file_name' => 'required|string|max:255',
=======
            'owner_id'    => 'required|exists:users,id',
            'name'        => 'required|string|max:255',
            'image'       => 'required|file|image|mimes:jpg,jpeg,png,webp|max:5120',
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
            'description' => 'sometimes|string',
        ];
    }

    public function messages(): array
    {
        return [
<<<<<<< HEAD
            'owner_id.required'  => 'An owner is required.',
            'owner_id.exists'    => 'Selected owner not found.',
            'name.required'      => 'Name is required.',
            'file_name.required' => 'File name is required.',
=======
            'owner_id.required' => 'An owner is required.',
            'owner_id.exists'   => 'Selected owner not found.',
            'name.required'     => 'Name is required.',
            'image.required'    => 'An image is required.',
            'image.image'       => 'The file must be an image.',
            'image.mimes'       => 'Only JPG, JPEG, PNG, and WEBP files are allowed.',
            'image.max'         => 'Image must not exceed 5MB.',
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
        ];
    }
}
