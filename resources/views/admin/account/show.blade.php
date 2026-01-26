@extends('admin.layout.app')

@section('title')
    {{ $account->name ?? __('Show') . ' Account' }}
@endsection

@section('header')
<div class="page-header-content d-lg-flex">
    <div class="d-flex">
        <h4 class="page-title mb-0">
            Home - <span class="fw-normal">Account Management</span>
        </h4>
    </div>
    <div class="d-lg-block my-lg-auto ms-lg-auto">
        <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3 gap-2">
            <a href="{{ route('accounts.index') }}" class="btn btn-outline-primary btn-labeled btn-labeled-start rounded-pill">
                <span class="btn-labeled-icon bg-primary text-white rounded-pill">
                    <i class="ph-arrow-circle-left"></i>
                </span>
                {{ __('Back') }}
            </a>
            <a href="{{ route('accounts.create') }}" class="btn btn-outline-primary btn-labeled btn-labeled-start rounded-pill">
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
            <h5 class="mb-0">{{ __('Show') }} Account</h5>
            <a  title="Edit" class="" href="{{ route('accounts.edit', $account->id) }}"><i class="ph-pencil"></i></a>
        </div>
        <div class="card-body">
           
                                <div class="form-group mb-2 mb20">
                                    <strong>Name:</strong>
                                    {{ $account->name }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Type:</strong>
                                    {{ $account->type }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Opening Balance:</strong>
                                    {{ $account->opening_balance }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Current Balance:</strong>
                                    {{ $account->current_balance }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Total Debit:</strong>
                                    {{ $account->total_debit }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Total Credit:</strong>
                                    {{ $account->total_credit }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Created By:</strong>
                                    {{ $account->created_by }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Updated By:</strong>
                                    {{ $account->updated_by }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Deleted By:</strong>
                                    {{ $account->deleted_by }}
                                </div>

        </div>
    </div>
</div>
@endsection
