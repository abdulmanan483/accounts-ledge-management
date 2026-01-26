<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
			'type' => 'required',
			'opening_balance' => 'required',
			'current_balance' => 'required',
			'total_debit' => 'required',
			'total_credit' => 'required',
			'created_by' => 'nullable',
			'updated_by' => 'nullable',
			'deleted_by' => 'nullable',
        ];
    }
}
