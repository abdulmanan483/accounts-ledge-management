@extends('admin.layout.app')

@section('title')
    {{ $user->name ?? __('Show') . ' User' }}
@endsection

@section('header')
<div class="page-header-content d-lg-flex">
    <div class="d-flex">
        <h4 class="page-title mb-0">
            Home - <span class="fw-normal">User Management</span>
        </h4>
    </div>
    <div class="d-lg-block my-lg-auto ms-lg-auto">
        <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3 gap-2">
            <a href="{{ route('users.index') }}" class="btn btn-outline-primary btn-labeled btn-labeled-start rounded-pill">
                <span class="btn-labeled-icon bg-primary text-white rounded-pill">
                    <i class="ph-arrow-circle-left"></i>
                </span>
                {{ __('Back') }}
            </a>
            <a href="{{ route('users.create') }}" class="btn btn-outline-primary btn-labeled btn-labeled-start rounded-pill">
                <span class="btn-labeled-icon bg-primary text-white rounded-pill">
                    <i class="ph-plus"></i>
                </span>
                Create
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="mb-0">{{ __('Show') }} User</h5>
            <a  title="Edit" class="" href="{{ route('users.edit', $user->id) }}"><i class="ph-pencil"></i></a>
        </div>
        <div class="card-body">
           
                                <div class="form-group mb-2 mb20">
                                    <strong>Name:</strong>
                                    {{ $user->name }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Email:</strong>
                                    {{ $user->email }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Image:</strong>
                                    {{ $user->image }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>User Type:</strong>
                                    {{ $user->user_type }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Is Active:</strong>
                                    {{ $user->is_active }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Created By:</strong>
                                    {{ $user->created_by }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Updated By:</strong>
                                    {{ $user->updated_by }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Deleted By:</strong>
                                    {{ $user->deleted_by }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Registration Date:</strong>
                                    {{ $user->registration_date }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Gender:</strong>
                                    {{ $user->gender }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Profile Picture:</strong>
                                    {{ $user->profile_picture }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>External Profile Pic:</strong>
                                    {{ $user->external_profile_pic }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Cnic:</strong>
                                    {{ $user->cnic }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Mobile No:</strong>
                                    {{ $user->mobile_no }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Cnic Front:</strong>
                                    {{ $user->cnic_front }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>External Cnic Front:</strong>
                                    {{ $user->external_cnic_front }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Cnic Back:</strong>
                                    {{ $user->cnic_back }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>External Cnic Back:</strong>
                                    {{ $user->external_cnic_back }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Current City:</strong>
                                    {{ $user->current_city }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Current City Id:</strong>
                                    {{ $user->current_city_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Current Address:</strong>
                                    {{ $user->current_address }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Permanent Country Id:</strong>
                                    {{ $user->permanent_country_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Permanent City Id:</strong>
                                    {{ $user->permanent_city_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Permanent Address:</strong>
                                    {{ $user->permanent_address }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Current Country:</strong>
                                    {{ $user->current_country }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Current Country Id:</strong>
                                    {{ $user->current_country_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Educational Qualifications:</strong>
                                    {{ $user->educational_qualifications }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Skills:</strong>
                                    {{ $user->skills }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Data Source:</strong>
                                    {{ $user->data_source }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Form No:</strong>
                                    {{ $user->form_no }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Is Pakistani:</strong>
                                    {{ $user->is_pakistani }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Is Approved:</strong>
                                    {{ $user->is_approved }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Is Added:</strong>
                                    {{ $user->is_added }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Status:</strong>
                                    {{ $user->status }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Comments:</strong>
                                    {{ $user->comments }}
                                </div>

        </div>
    </div>
</div>
@endsection
