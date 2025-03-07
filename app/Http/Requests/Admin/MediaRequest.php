<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MediaRequest extends FormRequest
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
			'file_name' => 'required|string',
			'file_path' => 'required|string',
			'mime_type' => 'required|string',
			'file_size' => 'required',
			'type' => 'nullable|string',
			'mediable_type' => 'nullable|string',
			'mediable_id' => 'nullable',
			'created_by' => 'nullable',
			'updated_by' => 'nullable',
			'deleted_by' => 'nullable',
        ];
    }
}
