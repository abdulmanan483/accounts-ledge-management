<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $account?->name) }}" id="name" placeholder="Name">
            {!! $errors->first('name', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="type" class="form-label">{{ __('Type') }}</label>
            <input type="text" name="type" class="form-control @error('type') is-invalid @enderror" value="{{ old('type', $account?->type) }}" id="type" placeholder="Type">
            {!! $errors->first('type', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="opening_balance" class="form-label">{{ __('Opening Balance') }}</label>
            <input type="text" name="opening_balance" class="form-control @error('opening_balance') is-invalid @enderror" value="{{ old('opening_balance', $account?->opening_balance) }}" id="opening_balance" placeholder="Opening Balance">
            {!! $errors->first('opening_balance', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="current_balance" class="form-label">{{ __('Current Balance') }}</label>
            <input type="text" name="current_balance" class="form-control @error('current_balance') is-invalid @enderror" value="{{ old('current_balance', $account?->current_balance) }}" id="current_balance" placeholder="Current Balance">
            {!! $errors->first('current_balance', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="total_debit" class="form-label">{{ __('Total Debit') }}</label>
            <input type="text" name="total_debit" class="form-control @error('total_debit') is-invalid @enderror" value="{{ old('total_debit', $account?->total_debit) }}" id="total_debit" placeholder="Total Debit">
            {!! $errors->first('total_debit', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="total_credit" class="form-label">{{ __('Total Credit') }}</label>
            <input type="text" name="total_credit" class="form-control @error('total_credit') is-invalid @enderror" value="{{ old('total_credit', $account?->total_credit) }}" id="total_credit" placeholder="Total Credit">
            {!! $errors->first('total_credit', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="created_by" class="form-label">{{ __('Created By') }}</label>
            <input type="text" name="created_by" class="form-control @error('created_by') is-invalid @enderror" value="{{ old('created_by', $account?->created_by) }}" id="created_by" placeholder="Created By">
            {!! $errors->first('created_by', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="updated_by" class="form-label">{{ __('Updated By') }}</label>
            <input type="text" name="updated_by" class="form-control @error('updated_by') is-invalid @enderror" value="{{ old('updated_by', $account?->updated_by) }}" id="updated_by" placeholder="Updated By">
            {!! $errors->first('updated_by', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="deleted_by" class="form-label">{{ __('Deleted By') }}</label>
            <input type="text" name="deleted_by" class="form-control @error('deleted_by') is-invalid @enderror" value="{{ old('deleted_by', $account?->deleted_by) }}" id="deleted_by" placeholder="Deleted By">
            {!! $errors->first('deleted_by', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>