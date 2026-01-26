<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="country_id" class="form-label">{{ __('Country Id') }}</label>
            <input type="text" name="country_id" class="form-control @error('country_id') is-invalid @enderror" value="{{ old('country_id', $city?->country_id) }}" id="country_id" placeholder="Country Id">
            {!! $errors->first('country_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="state_id" class="form-label">{{ __('State Id') }}</label>
            <input type="text" name="state_id" class="form-control @error('state_id') is-invalid @enderror" value="{{ old('state_id', $city?->state_id) }}" id="state_id" placeholder="State Id">
            {!! $errors->first('state_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $city?->name) }}" id="name" placeholder="Name">
            {!! $errors->first('name', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="country_code" class="form-label">{{ __('Country Code') }}</label>
            <input type="text" name="country_code" class="form-control @error('country_code') is-invalid @enderror" value="{{ old('country_code', $city?->country_code) }}" id="country_code" placeholder="Country Code">
            {!! $errors->first('country_code', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>