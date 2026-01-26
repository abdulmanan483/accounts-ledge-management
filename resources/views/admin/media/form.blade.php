<div class="row padding-1 p-1">
    <div class="col-md-12">

        <div class="form-group mb-2 mb20">
            <label for="file_name" class="form-label">{{ __('File Name') }}</label>
            <input type="text" name="file_name" class="form-control @error('file_name') is-invalid @enderror" value="{{ old('file_name', $media?->file_name) }}" id="file_name" placeholder="File Name">
            {!! $errors->first('file_name', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="file_path" class="form-label">{{ __('File Path') }}</label>
            <input type="text" name="file_path" class="form-control @error('file_path') is-invalid @enderror" value="{{ old('file_path', $media?->file_path) }}" id="file_path" placeholder="File Path">
            {!! $errors->first('file_path', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="mime_type" class="form-label">{{ __('Mime Type') }}</label>
            <input type="text" name="mime_type" class="form-control @error('mime_type') is-invalid @enderror" value="{{ old('mime_type', $media?->mime_type) }}" id="mime_type" placeholder="Mime Type">
            {!! $errors->first('mime_type', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="file_size" class="form-label">{{ __('File Size') }}</label>
            <input type="text" name="file_size" class="form-control @error('file_size') is-invalid @enderror" value="{{ old('file_size', $media?->file_size) }}" id="file_size" placeholder="File Size">
            {!! $errors->first('file_size', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="type" class="form-label">{{ __('Type') }}</label>
            <input type="text" name="type" class="form-control @error('type') is-invalid @enderror" value="{{ old('type', $media?->type) }}" id="type" placeholder="Type">
            {!! $errors->first('type', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="mediable_type" class="form-label">{{ __('Mediable Type') }}</label>
            <input type="text" name="mediable_type" class="form-control @error('mediable_type') is-invalid @enderror" value="{{ old('mediable_type', $media?->mediable_type) }}" id="mediable_type" placeholder="Mediable Type">
            {!! $errors->first('mediable_type', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="mediable_id" class="form-label">{{ __('Mediable Id') }}</label>
            <input type="text" name="mediable_id" class="form-control @error('mediable_id') is-invalid @enderror" value="{{ old('mediable_id', $media?->mediable_id) }}" id="mediable_id" placeholder="Mediable Id">
            {!! $errors->first('mediable_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="created_by" class="form-label">{{ __('Created By') }}</label>
            <input type="text" name="created_by" class="form-control @error('created_by') is-invalid @enderror" value="{{ old('created_by', $media?->created_by) }}" id="created_by" placeholder="Created By">
            {!! $errors->first('created_by', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="updated_by" class="form-label">{{ __('Updated By') }}</label>
            <input type="text" name="updated_by" class="form-control @error('updated_by') is-invalid @enderror" value="{{ old('updated_by', $media?->updated_by) }}" id="updated_by" placeholder="Updated By">
            {!! $errors->first('updated_by', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="deleted_by" class="form-label">{{ __('Deleted By') }}</label>
            <input type="text" name="deleted_by" class="form-control @error('deleted_by') is-invalid @enderror" value="{{ old('deleted_by', $media?->deleted_by) }}" id="deleted_by" placeholder="Deleted By">
            {!! $errors->first('deleted_by', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>
