<div class="row padding-1 p-1">

    {{-- Transaction Header --}}
    <div class="col-md-4">
        <div class="form-group mb-2 mb20">
            <label for="account_id" class="form-label">{{ __('Account') }}</label>
            <input type="hidden" name="currency_id" id="currency_id" value="{{ old('currency_id', $transaction?->currency_id) }}">
            <select name="account_id" id="account_id" class="form-control @error('account_id') is-invalid @enderror">
                <option value="">{{ __('Select Account') }}</option>
                @foreach ($accounts as $account)
                    <option value="{{ $account->id }}" data-currency-id="{{ $account->currency_id }}" data-currency="{{ $account->currency->symbol_native ?? '' }}"
                        {{ old('account_id') == $account->id ? 'selected' : '' }}>
                        {{ $account->name }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('account_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-2 mb20">
            <label for="transaction_category_id" class="form-label">{{ __('Transaction Category') }}</label>
            <select name="transaction_category_id" id="transaction_category_id"
                class="form-control @error('transaction_category_id') is-invalid @enderror">
                <option value="">{{ __('Select Transaction Category') }}</option>
                @foreach ($transaction_categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('transaction_category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first(
                'transaction_category_id',
                '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>',
            ) !!}
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group mb-2 mb20">
            <label for="person_id" class="form-label">{{ __('Person') }}</label>
            <select name="person_id" id="person_id" class="form-control @error('person_id') is-invalid @enderror">
                <option value="">{{ __('Select Person') }}</option>
                @foreach ($persons as $person)
                    <option value="{{ $person->id }}" {{ old('person_id') == $person->id ? 'selected' : '' }}>
                        {{ $person->name }} ({{ $person->type }})
                    </option>
                @endforeach
            </select>
            {!! $errors->first('person_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-2 mb20">
            <label for="person_id" class="form-label">{{ __('Date') }}</label>
            <input type="date" name="txn_date" class="form-control @error('txn_date') is-invalid @enderror"
                value="{{ old('txn_date', $transaction?->txn_date?->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
                id="txn_date" placeholder="TXN Date">
            {!! $errors->first('txn_date', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-2 mb20">
            <label for="reference" class="form-label">{{ __('Reference No.') }}</label>
            <input type="text" name="reference" class="form-control @error('reference') is-invalid @enderror"
                value="{{ old('reference', $transaction?->reference_no) }}" id="reference" placeholder="Reference no.">
            {!! $errors->first('reference', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    {{-- Transaction Lines --}}
    <div class="col-md-12">
        <table class="table table-bordered" id="transaction-lines">
            <thead>
                <tr>
                    <th>{{ __('Description') }}</th>
                    <th>{{ __('Debit (Amount Out)') }} <span class="currency-symbol text-muted"></span></th>
                    <th>{{ __('Credit (Amount In)') }} <span class="currency-symbol text-muted"></span></th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @if (old('lines'))
                    @foreach (old('lines') as $i => $line)
                        <tr>
                            <td>
                                <input type="text" name="lines[{{ $i }}][description]"
                                    class="form-control" value="{{ $line['description'] ?? '' }}">
                            </td>
                            <td>
                                <input type="number" step="0.01" name="lines[{{ $i }}][debit]"
                                    class="form-control" value="{{ $line['debit'] ?? '0.00' }}">
                            </td>
                            <td>
                                <input type="number" step="0.01" name="lines[{{ $i }}][credit]"
                                    class="form-control" value="{{ $line['credit'] ?? '0.00' }}">
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger remove-line">{{ __('Remove') }}</button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td><input type="text" name="lines[0][description]" class="form-control"></td>
                        <td><input type="number" min="0" step="0.01" name="lines[0][debit]"
                                class="form-control debit" value="0.00"></td>
                        <td><input type="number" min="0" step="0.01" name="lines[0][credit]"
                                class="form-control credit" value="0.00"></td>
                        <td>
                            <button type="button" class="btn btn-danger remove-line">{{ __('Remove') }}</button>
                        </td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
                <tr class="fw-bold">
                    <td class="text-end">{{ __('Total') }}</td>
                    <td>
                        <span class="currency-symbol text-muted"></span>
                        <span id="total-debit">0.00</span>
                    </td>
                    <td>
                        <span class="currency-symbol text-muted"></span>
                        <span id="total-credit">0.00</span>
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        <button type="button" class="mt-2 btn btn-success" id="add-line">{{ __('Add Line') }}</button>
    </div>

    {{-- Submit --}}
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit Transaction') }}</button>
    </div>

</div>

{{-- Scripts for dynamic rows --}}
@push('scripts')
    <script>
        $(function() {
            let lineIndex = {{ old('lines') ? count(old('lines')) : 1 }};

            // Add new line
            $('#add-line').click(function() {
                let row = `
        <tr>
            <td><input type="text" name="lines[${lineIndex}][description]" class="form-control"></td>
            <td><input type="number" step="0.01" min="0" name="lines[${lineIndex}][debit]" class="form-control debit" value="0.00"></td>
            <td><input type="number" step="0.01" min="0" name="lines[${lineIndex}][credit]" class="form-control credit" value="0.00"></td>
            <td><button type="button" class="btn btn-danger remove-line">{{ __('Remove') }}</button></td>
        </tr>
    `;
                $('#transaction-lines tbody').append(row);
                lineIndex++;

                // Trigger input to apply debit/credit logic immediately
                $('#transaction-lines tbody tr:last').find('.debit').trigger('input');
                $('#transaction-lines tbody tr:last').find('.credit').trigger('input');
            });

            // Remove line
            $(document).on('click', '.remove-line', function() {
                $(this).closest('tr').remove();
            });

            // Debit/Credit mutual exclusion
            $(document).on('input', '.debit', function() {
                let $row = $(this).closest('tr');
                let debitVal = parseFloat($(this).val()) || 0;
                let $credit = $row.find('.credit');

                if (debitVal > 0) {
                    $credit.val('0.00').prop('disabled', true);
                } else {
                    $credit.prop('disabled', false);
                }
            });

            $(document).on('input', '.credit', function() {
                let $row = $(this).closest('tr');
                let creditVal = parseFloat($(this).val()) || 0;
                let $debit = $row.find('.debit');

                if (creditVal > 0) {
                    $debit.val('0.00').prop('disabled', true);
                } else {
                    $debit.prop('disabled', false);
                }
            });

            // Initialize all existing rows (including first row) on page load
            $('#transaction-lines tbody tr').each(function() {
                $(this).find('.debit').attr('min', 0).trigger('input');
                $(this).find('.credit').attr('min', 0).trigger('input');
            });

            function updateCurrencySymbol() {
                let symbol = $('#account_id option:selected').data('currency') || '';
                $('.currency-symbol').text(symbol ? `(${symbol})` : '');
                $('#currency_id').val($('#account_id option:selected').data('currency-id'));
            }

            function updateTotals() {
                let totalDebit = 0;
                let totalCredit = 0;

                $('.debit').each(function() {
                    totalDebit += parseFloat($(this).val()) || 0;
                });

                $('.credit').each(function() {
                    totalCredit += parseFloat($(this).val()) || 0;
                });

                $('#total-debit').text(totalDebit.toFixed(2));
                $('#total-credit').text(totalCredit.toFixed(2));
            }

            // Account change → currency update
            $('#account_id').on('change', function() {
                updateCurrencySymbol();
            });

            // Recalculate totals on any amount change
            $(document).on('input', '.debit, .credit', function() {
                updateTotals();
            });

            // Initial load
            updateCurrencySymbol();
            updateTotals();

        });
    </script>
@endpush
