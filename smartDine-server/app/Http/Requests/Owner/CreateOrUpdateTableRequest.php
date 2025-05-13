<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateOrUpdateTableRequest extends FormRequest
{
    public function authorize(): bool
    {
        // add any ownership/permission checks here if needed
        return true;
    }

    /**
     * Merge route parameter `tableId` into the request data
     * so we can ignore it in the unique rule on update.
     */
    protected function prepareForValidation(): void
    {
        if ($this->route('tableId')) {
            $this->merge([
                'table_id' => $this->route('tableId'),
            ]);
        }
    }

    public function rules(): array
    {
        $locationId = $this->input('restaurant_location_id');
        $tableId    = $this->input('table_id');

        return [
            'restaurant_location_id' => ['required', 'integer', 'exists:restaurant_locations,id'],
            'number' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('tables', 'number')
                    ->where(fn($q) => $q->where('restaurant_location_id', $locationId))
                    ->ignore($tableId),
            ],
            'floor'    => ['required', 'integer', 'min:0'],
            'position' => ['required', 'array'],
            'position.x' => ['required', 'numeric'],
            'position.y' => ['required', 'numeric']
        ];
    }

    public function messages(): array
    {
        return [
            'restaurant_location_id.required' => 'Branch (location) is required.',
            'restaurant_location_id.exists'   => 'Selected branch does not exist.',
            'number.required'                 => 'Table number is required.',
            'number.unique'                   => 'This table number is already taken at this location.',
            'floor.required'                  => 'Floor is required.',
            'position.required'               => 'Position is required.',
            'position.array'                  => 'Position must be an array with x and y.',
            'position.x.required'             => 'Position.x is required.',
            'position.y.required'             => 'Position.y is required.',
        ];
    }
}
