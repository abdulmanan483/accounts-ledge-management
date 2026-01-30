<div class="row padding-1 p-1">

    {{-- Account Name --}}
    <div class="col-md-6">
        <div class="form-group mb-2">
            <label class="form-label">Account Name</label>
            <input type="text"
                   name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $account?->name) }}"
                   placeholder="Account Name">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-2">
            <label class="form-label">Currency</label>
            <select name="currency_id" class="form-control select2 @error('currency_id') is-invalid @enderror">
                <option value="">Select Currency</option>
                @foreach($currencies as $currency)
                    <option value="{{ $currency->id }}" {{ old('currency_id', $account?->currency_id) == $currency->id ? 'selected' : '' }}>
                        {{ $currency->name }}
                    </option>
                @endforeach
            </select>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Account Title --}}
    <div class="col-md-6">
        <div class="form-group mb-2">
            <label class="form-label">Account Title</label>
            <input type="text"
                   name="account_title"
                   class="form-control @error('account_title') is-invalid @enderror"
                   value="{{ old('account_title', $account?->account_title) }}"
                   placeholder="Account Title">
            @error('account_title')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Account Number --}}
    <div class="col-md-6">
        <div class="form-group mb-2">
            <label class="form-label">Account Number</label>
            <input type="text"
                   name="account_number"
                   class="form-control @error('account_number') is-invalid @enderror"
                   value="{{ old('account_number', $account?->account_number) }}"
                   placeholder="Account Number">
            @error('account_number')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    {{-- Bank Name --}}
    <div class="col-md-6">
        <div class="form-group mb-2">
            <label class="form-label">Bank Name</label>
            <input type="text"
                   name="bank_name"
                   class="form-control @error('bank_name') is-invalid @enderror"
                   value="{{ old('bank_name', $account?->bank_name) }}"
                   placeholder="Bank Name">
            @error('bank_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- IBAN --}}
    <div class="col-md-6">
        <div class="form-group mb-2">
            <label class="form-label">IBAN</label>
            <input type="text"
                   name="iban"
                   class="form-control @error('iban') is-invalid @enderror"
                   value="{{ old('iban', $account?->iban) }}"
                   placeholder="IBAN">
            @error('iban')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Branch Name --}}
    <div class="col-md-6">
        <div class="form-group mb-2">
            <label class="form-label">Branch Name</label>
            <input type="text"
                   name="branch_name"
                   class="form-control @error('branch_name') is-invalid @enderror"
                   value="{{ old('branch_name', $account?->branch_name) }}"
                   placeholder="Branch Name">
            @error('branch_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Branch Code --}}
    <div class="col-md-6">
        <div class="form-group mb-2">
            <label class="form-label">Branch Code</label>
            <input type="text"
                   name="branch_code"
                   class="form-control @error('branch_code') is-invalid @enderror"
                   value="{{ old('branch_code', $account?->branch_code) }}"
                   placeholder="Branch Code">
            @error('branch_code')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- SWIFT Code --}}
    <div class="col-md-6">
        <div class="form-group mb-2">
            <label class="form-label">SWIFT Code</label>
            <input type="text"
                   name="swift_code"
                   class="form-control @error('swift_code') is-invalid @enderror"
                   value="{{ old('swift_code', $account?->swift_code) }}"
                   placeholder="SWIFT Code">
            @error('swift_code')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    {{-- Opening Balance (Create only) --}}
    <div class="col-md-6">
        <div class="form-group mb-2">
            <label class="form-label">Opening Balance</label>
            <input type="number"
                   step="0.01"
                   @if(!$account->exists)
                   name="opening_balance"
                   @endif
                   class="form-control @error('opening_balance') is-invalid @enderror"
                   value="{{ old('opening_balance', $account?->opening_balance ?? 0) }}"
                   @if($account->exists)
                       disabled
                   @endif
                   placeholder="Opening Balance">
            @error('opening_balance')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Submit --}}
    <div class="col-md-12 mt-3">
        <button type="submit" class="btn btn-primary">
            {{ __('Save Account') }}
        </button>
    </div>

</div>
@push('scripts')
    <script>
        $(function() {
            $('.select2').select2();
        });
    </script>
@endpush
