<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Nnjeim\World\Models\City;

class LocationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    public function prepareForValidation()
    {
        if ($this->city_id) {
            $state_id = City::find($this->city_id)?->state_id; // Safe navigation
            $this->merge([
                'state_id' => $state_id,
            ]);
        }
        // Ensure is_active is always present
        $this->merge([
            'is_active' => $this->has('is_active') ? $this->is_active : false,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'state_id' => 'required',
			'city_id' => 'required',
			'site_id' => 'required',
			'floor_id' => 'required',
			'block_id' => 'required',
			'department_id' => 'required',
			'name' => 'required|string',
			'description' => 'nullable|string',
			'is_active' => 'nullable|boolean',
        ];
    }
}
