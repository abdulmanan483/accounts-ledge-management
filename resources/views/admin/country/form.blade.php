<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="iso2" class="form-label">{{ __('Iso2') }}</label>
            <input type="text" name="iso2" class="form-control @error('iso2') is-invalid @enderror" value="{{ old('iso2', $country?->iso2) }}" id="iso2" placeholder="Iso2">
            {!! $errors->first('iso2', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $country?->name) }}" id="name" placeholder="Name">
            {!! $errors->first('name', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="status" class="form-label">{{ __('Status') }}</label>
            <input type="text" name="status" class="form-control @error('status') is-invalid @enderror" value="{{ old('status', $country?->status) }}" id="status" placeholder="Status">
            {!! $errors->first('status', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="phone_code" class="form-label">{{ __('Phone Code') }}</label>
            <input type="text" name="phone_code" class="form-control @error('phone_code') is-invalid @enderror" value="{{ old('phone_code', $country?->phone_code) }}" id="phone_code" placeholder="Phone Code">
            {!! $errors->first('phone_code', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="iso3" class="form-label">{{ __('Iso3') }}</label>
            <input type="text" name="iso3" class="form-control @error('iso3') is-invalid @enderror" value="{{ old('iso3', $country?->iso3) }}" id="iso3" placeholder="Iso3">
            {!! $errors->first('iso3', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="region" class="form-label">{{ __('Region') }}</label>
            <input type="text" name="region" class="form-control @error('region') is-invalid @enderror" value="{{ old('region', $country?->region) }}" id="region" placeholder="Region">
            {!! $errors->first('region', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="subregion" class="form-label">{{ __('Subregion') }}</label>
            <input type="text" name="subregion" class="form-control @error('subregion') is-invalid @enderror" value="{{ old('subregion', $country?->subregion) }}" id="subregion" placeholder="Subregion">
            {!! $errors->first('subregion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>