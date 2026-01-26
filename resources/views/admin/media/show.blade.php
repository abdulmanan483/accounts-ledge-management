@extends('admin.layout.app')

@section('title')
    {{ $media->name ?? __('Show') . ' Media' }}
@endsection

@section('header')
<div class="page-header-content d-lg-flex">
    <div class="d-flex">
        <h4 class="page-title mb-0">
            Home - <span class="fw-normal">Media Management</span>
        </h4>
    </div>
    <div class="d-lg-block my-lg-auto ms-lg-auto">
        <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3 gap-2">
            <a href="{{ route('media.index') }}" class="btn btn-outline-primary btn-labeled btn-labeled-start rounded-pill">
                <span class="btn-labeled-icon bg-primary text-white rounded-pill">
                    <i class="ph-arrow-circle-left"></i>
                </span>
                {{ __('Back') }}
            </a>
            <a href="{{ route('media.create') }}" class="btn btn-outline-primary btn-labeled btn-labeled-start rounded-pill">
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
            <h5 class="mb-0">{{ __('Show') }} Media</h5>
            <a  title="Edit" class="" href="{{ route('media.edit', $media->id) }}"><i class="ph-pencil"></i></a>
        </div>
        <div class="card-body">

                                <div class="form-group mb-2 mb20">
                                    <strong>File Name:</strong>
                                    {{ $media->file_name }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>File Path:</strong>
                                    {{ $media->file_path }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Mime Type:</strong>
                                    {{ $media->mime_type }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>File Size:</strong>
                                    {{ $media->file_size }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Type:</strong>
                                    {{ $media->type }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Mediable Type:</strong>
                                    {{ $media->mediable_type }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Mediable Id:</strong>
                                    {{ $media->mediable_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Created By:</strong>
                                    {{ $media->created_by }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Updated By:</strong>
                                    {{ $media->updated_by }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Deleted By:</strong>
                                    {{ $media->deleted_by }}
                                </div>

        </div>
    </div>
</div>
@endsection
