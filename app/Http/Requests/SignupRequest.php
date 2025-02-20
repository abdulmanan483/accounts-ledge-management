<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SignupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:app_users',
            'password' => [
                'required',
                'string',
                'min:8',
                'max:16',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&#]/',
                'confirmed'
            ],
            'password_confirmation' => 'required|string|min:8|max:16',
        ];
    }

    /**
     * Override the error messages.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',

            'email.required' => 'The email field is required.',
            'email.string' => 'The email must be a string.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email may not be greater than 255 characters.',
            'email.unique' => 'The email has already been taken.',

            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.max' => 'The password may not be greater than 16 characters.',
            'password.regex' => 'The password must contain at least one uppercase letter, one number, and one special character.',
            'password.confirmed' => 'The password confirmation does not match.',

            'password_confirmation.required' => 'The password confirmation field is required.',
            'password_confirmation.string' => 'The password confirmation must be a string.',
            'password_confirmation.min' => 'The password confirmation must be at least 8 characters.',
            'password_confirmation.max' => 'The password confirmation may not be greater than 16 characters.',
        ];
    }

    /**
     * Override the return responce.
     *
     * @return array<string, mixed>
     */
    protected function failedValidation(Validator $validator)
    {
        $response = [
            'success' => false,
            'message' => 'Validation Error.',
            'errors'  => $validator->errors()
        ];

        throw new HttpResponseException(response()->json($response, 422));
    }
}
