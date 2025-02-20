@extends('admin.layout.app')

@section('title','Show Audit')

@section('header')
<div class="page-header-content d-lg-flex">
    <div class="d-flex">
        <h4 class="page-title mb-0">
            Home - <span class="fw-normal">Audit Managment</span>
        </h4>
    </div>
    <div class="d-lg-block my-lg-auto ms-lg-auto">
        <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3">
            <a href="{{ route('audits.index') }}" class="btn btn-outline-primary btn-labeled btn-labeled-start rounded-pill">
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
            <h5 class="mb-0">{{ __('Show') }} Audit</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4 col-xlg-3 col-md-5">
                    <center class="m-t-30">
                        <img src="{{ $audit->user->image }}" class="img-circle" width="150" />
                        <h4 class="card-title m-t-10">{{ $audit->user->name }}</h4>
                    </center>
                </div>
                <div class="col-lg-8 col-xlg-9 col-md-7">
                    <ul class="nav nav-tabs nav-tabs-highlight nav-justified" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#detail" role="tab">Detail</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#new_value" role="tab">New Value</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#old_value" role="tab">Old Value</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="detail" role="tabpanel">
                            <table class="table no-border d-flex">
                                <tbody>
                                    <tr>
                                        <td class="card-title">Model</td>
                                        <td>{{ $audit->auditable_type }}</td>
                                    </tr>
                                   
                                    <tr>
                                        <td class="card-title">Auditable ID</td>
                                        <td>{{ $audit->auditable_id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="card-title">Time</td>
                                        <td>{{ $audit->created_at }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="new_value" role="tabpanel">
                            <div class="card-body">
                                <div class="table-responsive mt-3">
                                    <table class="table color-table info-table">
                                        @foreach($audit->new_values as $attribute => $value)
                                            <tr>
                                                <td><b>{{ $attribute }}</b></td>
                                                <td>{{ $value }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="old_value" role="tabpanel">
                            <div class="card-body">
                                <div class="table-responsive mt-3">
                                    <table class="table color-table info-table">
                                        @foreach($audit->old_values as $attribute => $value)
                                            <tr>
                                                <td><b>{{ $attribute }}</b></td>
                                                <td>{{ $value }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
