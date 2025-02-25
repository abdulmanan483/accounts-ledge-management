@extends('admin.layout.app')

@section('title')
    {{ $block->name ?? __('Show') . ' Block' }}
@endsection

@section('header')
<div class="page-header-content d-lg-flex">
    <div class="d-flex">
        <h4 class="page-title mb-0">
            Home - <span class="fw-normal">Block Management</span>
        </h4>
    </div>
    <div class="d-lg-block my-lg-auto ms-lg-auto">
        <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3 gap-2">
            <a href="{{ route('blocks.index') }}" class="btn btn-outline-primary btn-labeled btn-labeled-start rounded-pill">
                <span class="btn-labeled-icon bg-primary text-white rounded-pill">
                    <i class="ph-arrow-circle-left"></i>
                </span>
                {{ __('Back') }}
            </a>
            <a href="{{ route('blocks.create') }}" class="btn btn-outline-primary btn-labeled btn-labeled-start rounded-pill">
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
            <h5 class="mb-0">{{ __('Show') }} Block</h5>
            <a  title="Edit" class="" href="{{ route('blocks.edit', $block->id) }}"><i class="ph-pencil"></i></a>
        </div>
        <div class="card-body">
           
                                <div class="form-group mb-2 mb20">
                                    <strong>Code:</strong>
                                    {{ $block->code }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Name:</strong>
                                    {{ $block->name }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Description:</strong>
                                    {{ $block->description }}
                                </div>

        </div>
    </div>
</div>
@endsection
