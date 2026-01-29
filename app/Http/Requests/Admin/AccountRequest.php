<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name'           => 'required|string|max:255',

            'bank_name'      => 'nullable|string|max:255',
            'account_title'  => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:100',
            'iban'           => 'nullable|string|max:50',
            'branch_name'    => 'nullable|string|max:255',
            'branch_code'    => 'nullable|string|max:50',
            'swift_code'     => 'nullable|string|max:50',
        ];

        /**
         * Opening balance:
         * - ONLY on create
         * - numeric
         * - negative allowed (overdraft / payable cases)
         */
        if ($this->isMethod('post')) {
            $rules['opening_balance'] = 'required|numeric';
        } else {
            // prevent updating opening balance
            $rules['opening_balance'] = 'prohibited';
        }

        return $rules;
    }
}
