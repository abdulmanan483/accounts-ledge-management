<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            'reference' => 'nullable|string',
            'account_id' => 'required|exists:accounts,id',
            'currency_id' => 'nullable|exists:currencies,id',
            'transaction_category_id' => 'nullable|exists:transaction_categories,id',
            'person_id' => 'nullable|exists:persons,id',
            'txn_date' => 'required|date',
            'lines' => 'required|array|min:1',
            'lines.*.description' => 'required|string',
            'lines.*.debit' => 'nullable|numeric|min:0',
            'lines.*.credit' => 'nullable|numeric|min:0',
            'lines.*' => function ($attribute, $value, $fail) {
                // Custom validation: either debit or credit must be > 0, not both
                $debit = $value['debit'] ?? 0;
                $credit = $value['credit'] ?? 0;

                if (($debit > 0 && $credit > 0) || ($debit == 0 && $credit == 0)) {
                    $fail('Each line must have either debit or credit (not both or neither).');
                }
            },
        ];
    }
}
