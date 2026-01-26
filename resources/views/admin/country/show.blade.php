@extends('admin.layout.app')

@section('title')
    {{ $country->name ?? __('Show') . ' Country' }}
@endsection

@section('header')
<div class="page-header-content d-lg-flex">
    <div class="d-flex">
        <h4 class="page-title mb-0">
            Home - <span class="fw-normal">Country Management</span>
        </h4>
    </div>
    <div class="d-lg-block my-lg-auto ms-lg-auto">
        <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3 gap-2">
            <a href="{{ route('countries.index') }}" class="btn btn-outline-primary btn-labeled btn-labeled-start rounded-pill">
                <span class="btn-labeled-icon bg-primary text-white rounded-pill">
                    <i class="ph-arrow-circle-left"></i>
                </span>
                {{ __('Back') }}
            </a>
            <a href="{{ route('countries.create') }}" class="btn btn-outline-primary btn-labeled btn-labeled-start rounded-pill">
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
            <h5 class="mb-0">{{ __('Show') }} Country</h5>
            <a  title="Edit" class="" href="{{ route('countries.edit', $country->id) }}"><i class="ph-pencil"></i></a>
        </div>
        <div class="card-body">
           
                                <div class="form-group mb-2 mb20">
                                    <strong>Iso2:</strong>
                                    {{ $country->iso2 }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Name:</strong>
                                    {{ $country->name }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Status:</strong>
                                    {{ $country->status }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Phone Code:</strong>
                                    {{ $country->phone_code }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Iso3:</strong>
                                    {{ $country->iso3 }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Region:</strong>
                                    {{ $country->region }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Subregion:</strong>
                                    {{ $country->subregion }}
                                </div>

        </div>
    </div>
</div>
@endsection
