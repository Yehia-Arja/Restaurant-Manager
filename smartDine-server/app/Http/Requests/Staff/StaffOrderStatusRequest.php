<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;

class StaffOrderStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'action' => 'required|in:accepted,rejected',
        ];
    }

    public function messages(): array
    {
        return [
            'action.required'   => 'You must specify accept or reject.',
            'action.in'         => 'Action must be either accepted or rejected.',
        ];
    }
}
