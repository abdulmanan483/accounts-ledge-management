<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
			'name' => 'required|string',
			'email' => 'nullable|string',
			'image' => 'nullable|string',
			'user_type' => 'required',
			'is_active' => 'required',
			'created_by' => 'nullable',
			'updated_by' => 'nullable',
			'deleted_by' => 'nullable',
			'registration_date' => 'nullable',
			'gender' => 'nullable',
			'profile_picture' => 'nullable|string',
			'external_profile_pic' => 'nullable|string',
			'cnic' => 'nullable|string',
			'mobile_no' => 'nullable|string',
			'cnic_front' => 'nullable|string',
			'external_cnic_front' => 'nullable|string',
			'cnic_back' => 'nullable|string',
			'external_cnic_back' => 'nullable|string',
			'current_city' => 'nullable|string',
			'current_city_id' => 'nullable',
			'current_address' => 'nullable|string',
			'permanent_country_id' => 'nullable',
			'permanent_city_id' => 'nullable',
			'permanent_address' => 'nullable|string',
			'current_country' => 'nullable|string',
			'current_country_id' => 'nullable',
			'educational_qualifications' => 'nullable|string',
			'skills' => 'nullable|string',
			'data_source' => 'nullable',
			'form_no' => 'nullable',
			'is_pakistani' => 'required',
			'is_approved' => 'required',
			'is_added' => 'required',
			'status' => 'required|string',
			'comments' => 'nullable|string',
        ];
    }
}
