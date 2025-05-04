<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class OrderStatusRequest extends FormRequest
{
    /**
     * Everyone who can hit the route is already authenticated/authorized
     * (middleware handles user‐type checks), so we simply return true here.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * We only allow the "cancel" action for clients.
     */
    public function rules(): array
    {
        return [
            'action' => 'required|string|in:cancel',
        ];
    }

    /**
     * Custom error messages for clarity.
     */
    public function messages(): array
    {
        return [
            'action.required' => 'You must specify an action.',
            'action.in'       => 'The only allowed action is cancel.',
        ];
    }
}
