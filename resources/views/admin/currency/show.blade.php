@extends('admin.layout.app')

@section('title')
    {{ $currency->name ?? __('Show') . ' Currency' }}
@endsection

@section('header')
<div class="page-header-content d-lg-flex">
    <div class="d-flex">
        <h4 class="page-title mb-0">
            Home - <span class="fw-normal">Currency Management</span>
        </h4>
    </div>
    <div class="d-lg-block my-lg-auto ms-lg-auto">
        <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3 gap-2">
            <a href="{{ route('currencies.index') }}" class="btn btn-outline-primary btn-labeled btn-labeled-start rounded-pill">
                <span class="btn-labeled-icon bg-primary text-white rounded-pill">
                    <i class="ph-arrow-circle-left"></i>
                </span>
                {{ __('Back') }}
            </a>
            <a href="{{ route('currencies.create') }}" class="btn btn-outline-primary btn-labeled btn-labeled-start rounded-pill">
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
            <h5 class="mb-0">{{ __('Show') }} Currency</h5>
            <a  title="Edit" class="" href="{{ route('currencies.edit', $currency->id) }}"><i class="ph-pencil"></i></a>
        </div>
        <div class="card-body">
           
                                <div class="form-group mb-2 mb20">
                                    <strong>Country Id:</strong>
                                    {{ $currency->country_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Name:</strong>
                                    {{ $currency->name }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Code:</strong>
                                    {{ $currency->code }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Precision:</strong>
                                    {{ $currency->precision }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Symbol:</strong>
                                    {{ $currency->symbol }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Symbol Native:</strong>
                                    {{ $currency->symbol_native }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Symbol First:</strong>
                                    {{ $currency->symbol_first }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Decimal Mark:</strong>
                                    {{ $currency->decimal_mark }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Thousands Separator:</strong>
                                    {{ $currency->thousands_separator }}
                                </div>

        </div>
    </div>
</div>
@endsection
