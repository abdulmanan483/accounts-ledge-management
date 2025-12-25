<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $permission?->name) }}" id="name" placeholder="Name">
            {!! $errors->first('name', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="guard_name" class="form-label">{{ __('Guard Name') }}</label>
            <input type="text" name="guard_name" class="form-control @error('guard_name') is-invalid @enderror" value="{{ old('guard_name', $permission?->guard_name) }}" id="guard_name" placeholder="Guard Name">
            {!! $errors->first('guard_name', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="display_name" class="form-label">{{ __('Display Name') }}</label>
            <input type="text" name="display_name" class="form-control @error('display_name') is-invalid @enderror" value="{{ old('display_name', $permission?->display_name) }}" id="display_name" placeholder="Display Name">
            {!! $errors->first('display_name', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="group" class="form-label">{{ __('Group') }}</label>
            <input type="text" name="group" class="form-control @error('group') is-invalid @enderror" value="{{ old('group', $permission?->group) }}" id="group" placeholder="Group">
            {!! $errors->first('group', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="display_group" class="form-label">{{ __('Display Group') }}</label>
            <input type="text" name="display_group" class="form-control @error('display_group') is-invalid @enderror" value="{{ old('display_group', $permission?->display_group) }}" id="display_group" placeholder="Display Group">
            {!! $errors->first('display_group', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="type" class="form-label">{{ __('Type') }}</label>
            <input type="text" name="type" class="form-control @error('type') is-invalid @enderror" value="{{ old('type', $permission?->type) }}" id="type" placeholder="Type">
            {!! $errors->first('type', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="display_type" class="form-label">{{ __('Display Type') }}</label>
            <input type="text" name="display_type" class="form-control @error('display_type') is-invalid @enderror" value="{{ old('display_type', $permission?->display_type) }}" id="display_type" placeholder="Display Type">
            {!! $errors->first('display_type', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>