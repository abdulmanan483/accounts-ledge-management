@extends('admin.layout.app')

@section('title','Show User')

@section('header')
<div class="page-header-content d-lg-flex">
    <div class="d-flex">
        <h4 class="page-title mb-0">
            Home - <span class="fw-normal">User Managment</span>
        </h4>
    </div>
    <div class="d-lg-block my-lg-auto ms-lg-auto">
        <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3">
            <a href="{{ route('users.index') }}" class="btn btn-outline-primary btn-labeled btn-labeled-start rounded-pill">
                <span class="btn-labeled-icon bg-primary text-white rounded-pill">
                    <i class="ph-arrow-circle-left"></i>
                </span>
                Back
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">{{ __('Show User') }}</h5>
        </div>
        <div class="card-body d-flex justify-content-around">
            <div class="form-group">
                <img class="rounded-2" src="{{ asset($user->image) }}" width="200px"/>
            </div>
            <div class="form-group d-flex flex-column">
                <h5>User Information</h5>
                <strong>Name:</strong>
                {{ $user->name }}
                <strong>Email:</strong>
                {{ $user->email }}
            </div>
            <div class="form-group d-flex flex-column">
                <h5>User Roles</h5>
                @foreach($user->roles as $role)
                    <span class="badge rounded-pill bg-success mt-1">{{ $role->name }}</span>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection