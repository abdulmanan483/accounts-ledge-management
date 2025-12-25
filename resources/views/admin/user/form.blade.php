<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user?->name) }}" id="name" placeholder="Name">
            {!! $errors->first('name', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user?->email) }}" id="email" placeholder="Email">
            {!! $errors->first('email', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="image" class="form-label">{{ __('Image') }}</label>
            <input type="text" name="image" class="form-control @error('image') is-invalid @enderror" value="{{ old('image', $user?->image) }}" id="image" placeholder="Image">
            {!! $errors->first('image', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="user_type" class="form-label">{{ __('User Type') }}</label>
            <input type="text" name="user_type" class="form-control @error('user_type') is-invalid @enderror" value="{{ old('user_type', $user?->user_type) }}" id="user_type" placeholder="User Type">
            {!! $errors->first('user_type', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="is_active" class="form-label">{{ __('Is Active') }}</label>
            <input type="text" name="is_active" class="form-control @error('is_active') is-invalid @enderror" value="{{ old('is_active', $user?->is_active) }}" id="is_active" placeholder="Is Active">
            {!! $errors->first('is_active', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="created_by" class="form-label">{{ __('Created By') }}</label>
            <input type="text" name="created_by" class="form-control @error('created_by') is-invalid @enderror" value="{{ old('created_by', $user?->created_by) }}" id="created_by" placeholder="Created By">
            {!! $errors->first('created_by', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="updated_by" class="form-label">{{ __('Updated By') }}</label>
            <input type="text" name="updated_by" class="form-control @error('updated_by') is-invalid @enderror" value="{{ old('updated_by', $user?->updated_by) }}" id="updated_by" placeholder="Updated By">
            {!! $errors->first('updated_by', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="deleted_by" class="form-label">{{ __('Deleted By') }}</label>
            <input type="text" name="deleted_by" class="form-control @error('deleted_by') is-invalid @enderror" value="{{ old('deleted_by', $user?->deleted_by) }}" id="deleted_by" placeholder="Deleted By">
            {!! $errors->first('deleted_by', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="registration_date" class="form-label">{{ __('Registration Date') }}</label>
            <input type="text" name="registration_date" class="form-control @error('registration_date') is-invalid @enderror" value="{{ old('registration_date', $user?->registration_date) }}" id="registration_date" placeholder="Registration Date">
            {!! $errors->first('registration_date', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="gender" class="form-label">{{ __('Gender') }}</label>
            <input type="text" name="gender" class="form-control @error('gender') is-invalid @enderror" value="{{ old('gender', $user?->gender) }}" id="gender" placeholder="Gender">
            {!! $errors->first('gender', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="profile_picture" class="form-label">{{ __('Profile Picture') }}</label>
            <input type="text" name="profile_picture" class="form-control @error('profile_picture') is-invalid @enderror" value="{{ old('profile_picture', $user?->profile_picture) }}" id="profile_picture" placeholder="Profile Picture">
            {!! $errors->first('profile_picture', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="external_profile_pic" class="form-label">{{ __('External Profile Pic') }}</label>
            <input type="text" name="external_profile_pic" class="form-control @error('external_profile_pic') is-invalid @enderror" value="{{ old('external_profile_pic', $user?->external_profile_pic) }}" id="external_profile_pic" placeholder="External Profile Pic">
            {!! $errors->first('external_profile_pic', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="cnic" class="form-label">{{ __('Cnic') }}</label>
            <input type="text" name="cnic" class="form-control @error('cnic') is-invalid @enderror" value="{{ old('cnic', $user?->cnic) }}" id="cnic" placeholder="Cnic">
            {!! $errors->first('cnic', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="mobile_no" class="form-label">{{ __('Mobile No') }}</label>
            <input type="text" name="mobile_no" class="form-control @error('mobile_no') is-invalid @enderror" value="{{ old('mobile_no', $user?->mobile_no) }}" id="mobile_no" placeholder="Mobile No">
            {!! $errors->first('mobile_no', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="cnic_front" class="form-label">{{ __('Cnic Front') }}</label>
            <input type="text" name="cnic_front" class="form-control @error('cnic_front') is-invalid @enderror" value="{{ old('cnic_front', $user?->cnic_front) }}" id="cnic_front" placeholder="Cnic Front">
            {!! $errors->first('cnic_front', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="external_cnic_front" class="form-label">{{ __('External Cnic Front') }}</label>
            <input type="text" name="external_cnic_front" class="form-control @error('external_cnic_front') is-invalid @enderror" value="{{ old('external_cnic_front', $user?->external_cnic_front) }}" id="external_cnic_front" placeholder="External Cnic Front">
            {!! $errors->first('external_cnic_front', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="cnic_back" class="form-label">{{ __('Cnic Back') }}</label>
            <input type="text" name="cnic_back" class="form-control @error('cnic_back') is-invalid @enderror" value="{{ old('cnic_back', $user?->cnic_back) }}" id="cnic_back" placeholder="Cnic Back">
            {!! $errors->first('cnic_back', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="external_cnic_back" class="form-label">{{ __('External Cnic Back') }}</label>
            <input type="text" name="external_cnic_back" class="form-control @error('external_cnic_back') is-invalid @enderror" value="{{ old('external_cnic_back', $user?->external_cnic_back) }}" id="external_cnic_back" placeholder="External Cnic Back">
            {!! $errors->first('external_cnic_back', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="current_city" class="form-label">{{ __('Current City') }}</label>
            <input type="text" name="current_city" class="form-control @error('current_city') is-invalid @enderror" value="{{ old('current_city', $user?->current_city) }}" id="current_city" placeholder="Current City">
            {!! $errors->first('current_city', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="current_city_id" class="form-label">{{ __('Current City Id') }}</label>
            <input type="text" name="current_city_id" class="form-control @error('current_city_id') is-invalid @enderror" value="{{ old('current_city_id', $user?->current_city_id) }}" id="current_city_id" placeholder="Current City Id">
            {!! $errors->first('current_city_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="current_address" class="form-label">{{ __('Current Address') }}</label>
            <input type="text" name="current_address" class="form-control @error('current_address') is-invalid @enderror" value="{{ old('current_address', $user?->current_address) }}" id="current_address" placeholder="Current Address">
            {!! $errors->first('current_address', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="permanent_country_id" class="form-label">{{ __('Permanent Country Id') }}</label>
            <input type="text" name="permanent_country_id" class="form-control @error('permanent_country_id') is-invalid @enderror" value="{{ old('permanent_country_id', $user?->permanent_country_id) }}" id="permanent_country_id" placeholder="Permanent Country Id">
            {!! $errors->first('permanent_country_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="permanent_city_id" class="form-label">{{ __('Permanent City Id') }}</label>
            <input type="text" name="permanent_city_id" class="form-control @error('permanent_city_id') is-invalid @enderror" value="{{ old('permanent_city_id', $user?->permanent_city_id) }}" id="permanent_city_id" placeholder="Permanent City Id">
            {!! $errors->first('permanent_city_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="permanent_address" class="form-label">{{ __('Permanent Address') }}</label>
            <input type="text" name="permanent_address" class="form-control @error('permanent_address') is-invalid @enderror" value="{{ old('permanent_address', $user?->permanent_address) }}" id="permanent_address" placeholder="Permanent Address">
            {!! $errors->first('permanent_address', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="current_country" class="form-label">{{ __('Current Country') }}</label>
            <input type="text" name="current_country" class="form-control @error('current_country') is-invalid @enderror" value="{{ old('current_country', $user?->current_country) }}" id="current_country" placeholder="Current Country">
            {!! $errors->first('current_country', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="current_country_id" class="form-label">{{ __('Current Country Id') }}</label>
            <input type="text" name="current_country_id" class="form-control @error('current_country_id') is-invalid @enderror" value="{{ old('current_country_id', $user?->current_country_id) }}" id="current_country_id" placeholder="Current Country Id">
            {!! $errors->first('current_country_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="educational_qualifications" class="form-label">{{ __('Educational Qualifications') }}</label>
            <input type="text" name="educational_qualifications" class="form-control @error('educational_qualifications') is-invalid @enderror" value="{{ old('educational_qualifications', $user?->educational_qualifications) }}" id="educational_qualifications" placeholder="Educational Qualifications">
            {!! $errors->first('educational_qualifications', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="skills" class="form-label">{{ __('Skills') }}</label>
            <input type="text" name="skills" class="form-control @error('skills') is-invalid @enderror" value="{{ old('skills', $user?->skills) }}" id="skills" placeholder="Skills">
            {!! $errors->first('skills', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="data_source" class="form-label">{{ __('Data Source') }}</label>
            <input type="text" name="data_source" class="form-control @error('data_source') is-invalid @enderror" value="{{ old('data_source', $user?->data_source) }}" id="data_source" placeholder="Data Source">
            {!! $errors->first('data_source', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="form_no" class="form-label">{{ __('Form No') }}</label>
            <input type="text" name="form_no" class="form-control @error('form_no') is-invalid @enderror" value="{{ old('form_no', $user?->form_no) }}" id="form_no" placeholder="Form No">
            {!! $errors->first('form_no', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="is_pakistani" class="form-label">{{ __('Is Pakistani') }}</label>
            <input type="text" name="is_pakistani" class="form-control @error('is_pakistani') is-invalid @enderror" value="{{ old('is_pakistani', $user?->is_pakistani) }}" id="is_pakistani" placeholder="Is Pakistani">
            {!! $errors->first('is_pakistani', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="is_approved" class="form-label">{{ __('Is Approved') }}</label>
            <input type="text" name="is_approved" class="form-control @error('is_approved') is-invalid @enderror" value="{{ old('is_approved', $user?->is_approved) }}" id="is_approved" placeholder="Is Approved">
            {!! $errors->first('is_approved', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="is_added" class="form-label">{{ __('Is Added') }}</label>
            <input type="text" name="is_added" class="form-control @error('is_added') is-invalid @enderror" value="{{ old('is_added', $user?->is_added) }}" id="is_added" placeholder="Is Added">
            {!! $errors->first('is_added', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="status" class="form-label">{{ __('Status') }}</label>
            <input type="text" name="status" class="form-control @error('status') is-invalid @enderror" value="{{ old('status', $user?->status) }}" id="status" placeholder="Status">
            {!! $errors->first('status', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="comments" class="form-label">{{ __('Comments') }}</label>
            <input type="text" name="comments" class="form-control @error('comments') is-invalid @enderror" value="{{ old('comments', $user?->comments) }}" id="comments" placeholder="Comments">
            {!! $errors->first('comments', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>