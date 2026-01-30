<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="country_id" class="form-label">{{ __('Country Id') }}</label>
            <input type="text" name="country_id" class="form-control @error('country_id') is-invalid @enderror" value="{{ old('country_id', $currency?->country_id) }}" id="country_id" placeholder="Country Id">
            {!! $errors->first('country_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $currency?->name) }}" id="name" placeholder="Name">
            {!! $errors->first('name', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="code" class="form-label">{{ __('Code') }}</label>
            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $currency?->code) }}" id="code" placeholder="Code">
            {!! $errors->first('code', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="precision" class="form-label">{{ __('Precision') }}</label>
            <input type="text" name="precision" class="form-control @error('precision') is-invalid @enderror" value="{{ old('precision', $currency?->precision) }}" id="precision" placeholder="Precision">
            {!! $errors->first('precision', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="symbol" class="form-label">{{ __('Symbol') }}</label>
            <input type="text" name="symbol" class="form-control @error('symbol') is-invalid @enderror" value="{{ old('symbol', $currency?->symbol) }}" id="symbol" placeholder="Symbol">
            {!! $errors->first('symbol', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="symbol_native" class="form-label">{{ __('Symbol Native') }}</label>
            <input type="text" name="symbol_native" class="form-control @error('symbol_native') is-invalid @enderror" value="{{ old('symbol_native', $currency?->symbol_native) }}" id="symbol_native" placeholder="Symbol Native">
            {!! $errors->first('symbol_native', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="symbol_first" class="form-label">{{ __('Symbol First') }}</label>
            <input type="text" name="symbol_first" class="form-control @error('symbol_first') is-invalid @enderror" value="{{ old('symbol_first', $currency?->symbol_first) }}" id="symbol_first" placeholder="Symbol First">
            {!! $errors->first('symbol_first', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="decimal_mark" class="form-label">{{ __('Decimal Mark') }}</label>
            <input type="text" name="decimal_mark" class="form-control @error('decimal_mark') is-invalid @enderror" value="{{ old('decimal_mark', $currency?->decimal_mark) }}" id="decimal_mark" placeholder="Decimal Mark">
            {!! $errors->first('decimal_mark', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="thousands_separator" class="form-label">{{ __('Thousands Separator') }}</label>
            <input type="text" name="thousands_separator" class="form-control @error('thousands_separator') is-invalid @enderror" value="{{ old('thousands_separator', $currency?->thousands_separator) }}" id="thousands_separator" placeholder="Thousands Separator">
            {!! $errors->first('thousands_separator', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>