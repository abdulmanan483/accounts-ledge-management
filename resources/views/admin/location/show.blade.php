@extends('admin.layout.app')

@section('title')
    {{ $location->name ?? __('Show') . ' Location' }}
@endsection

@section('header')
<div class="page-header-content d-lg-flex">
    <div class="d-flex">
        <h4 class="page-title mb-0">
            Home - <span class="fw-normal">Location Management</span>
        </h4>
    </div>
    <div class="d-lg-block my-lg-auto ms-lg-auto">
        <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3 gap-2">
            <a href="{{ route('locations.index') }}" class="btn btn-outline-primary btn-labeled btn-labeled-start rounded-pill">
                <span class="btn-labeled-icon bg-primary text-white rounded-pill">
                    <i class="ph-arrow-circle-left"></i>
                </span>
                {{ __('Back') }}
            </a>
            <a href="{{ route('locations.create') }}" class="btn btn-outline-primary btn-labeled btn-labeled-start rounded-pill">
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
            <h5 class="mb-0">{{ __('Show') }} Location</h5>
            <a  title="Edit" class="" href="{{ route('locations.edit', $location->id) }}"><i class="ph-pencil"></i></a>
        </div>
        <div class="card-body">

                                <div class="form-group mb-2 mb20">
                                    <strong>State Id:</strong>
                                    {{ $location->state_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>City Id:</strong>
                                    {{ $location->city_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Site Id:</strong>
                                    {{ $location->site_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Floor Id:</strong>
                                    {{ $location->floor_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Block Id:</strong>
                                    {{ $location->block_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Department Id:</strong>
                                    {{ $location->department_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Name:</strong>
                                    {{ $location->name }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Description:</strong>
                                    {{ $location->description }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Is Active:</strong>
                                    {{ $location->is_active }}
                                </div>

        </div>
    </div>
</div>
@endsection
