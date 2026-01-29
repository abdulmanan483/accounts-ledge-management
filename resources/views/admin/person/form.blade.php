<div class="row padding-1 p-1">
    <div class="col-md-6">
        <div class="form-group mb-2 mb20">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $person?->name) }}" id="name" placeholder="Name">
            {!! $errors->first('name', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-2 mb20">
            <label for="phone_no" class="form-label">{{ __('Phone No') }}</label>
            <input type="tel" name="phone_no" class="form-control @error('phone_no') is-invalid @enderror"
                   value="{{ old('phone_no', $person?->phone_no) }}" id="phone_no" placeholder="Phone No">
            {!! $errors->first('phone_no', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>
    <div class="col-md-6">
        {{--        <div class="form-group mb-2 mb20">--}}
        {{--            <label for="type" class="form-label">{{ __('Type') }}</label>--}}
        {{--            <input type="text" name="type" class="form-control @error('type') is-invalid @enderror" value="{{ old('type', $person?->type) }}" id="type" placeholder="Type">--}}
        {{--            {!! $errors->first('type', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}--}}
        {{--        </div>--}}
        <div class="form-group mb-2 mb20">
            <label for="type" class="form-label">{{ __('Type') }}</label>
            <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                <option value="">{{ __('Select Type') }}</option>
                @foreach (\App\Enums\Persons\PersonType::toValueNameObjects() as $typeOption)
                    <option value="{{ $typeOption->value }}"
                            {{ old('type', $person?->type) === $typeOption->value ? 'selected' : '' }}>
                        {{ $typeOption->name }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('type', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>