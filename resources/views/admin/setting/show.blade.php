@extends('admin.layout.app')

@section('title')
    {{ $setting->name ?? __('Show') . ' Setting' }}
@endsection

@section('header')
<div class="page-header-content d-lg-flex">
    <div class="d-flex">
        <h4 class="page-title mb-0">
            Home - <span class="fw-normal">Setting Management</span>
        </h4>
    </div>
    <div class="d-lg-block my-lg-auto ms-lg-auto">
        <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3 gap-2">
            <a href="{{ route('settings.index') }}" class="btn btn-outline-primary btn-labeled btn-labeled-start rounded-pill">
                <span class="btn-labeled-icon bg-primary text-white rounded-pill">
                    <i class="ph-arrow-circle-left"></i>
                </span>
                {{ __('Back') }}
            </a>
            <a href="{{ route('settings.create') }}" class="btn btn-outline-primary btn-labeled btn-labeled-start rounded-pill">
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
            <h5 class="mb-0">{{ __('Show') }} Setting</h5>
            <a  title="Edit" class="" href="{{ route('settings.edit', $setting->id) }}"><i class="ph-pencil"></i></a>
        </div>
        <div class="card-body">
           
                                <div class="form-group mb-2 mb20">
                                    <strong>Key:</strong>
                                    {{ $setting->key }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Name:</strong>
                                    {{ $setting->name }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Description:</strong>
                                    {{ $setting->description }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Tab:</strong>
                                    {{ $setting->tab }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Section:</strong>
                                    {{ $setting->section }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Type:</strong>
                                    {{ $setting->type }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Value:</strong>
                                    {{ $setting->value }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Options:</strong>
                                    {{ $setting->options }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Created By:</strong>
                                    {{ $setting->created_by }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Updated By:</strong>
                                    {{ $setting->updated_by }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Deleted By:</strong>
                                    {{ $setting->deleted_by }}
                                </div>

        </div>
    </div>
</div>
@endsection
