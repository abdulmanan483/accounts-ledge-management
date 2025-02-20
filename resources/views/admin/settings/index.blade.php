@extends('admin.layout.app')

@section('title', 'Settings')

@section('header')
<div class="page-header-content d-lg-flex">
    <div class="d-flex">
        <h4 class="page-title mb-0">
            Home - <span class="fw-normal">Settings</span>
        </h4>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">General Settings</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('settings.save') }}" enctype="multipart/form-data">
            @csrf
            <div class="fw-bold border-bottom pb-2 mb-3">SMTP Account</div>

            <div class="row mb-3">
                <div class="col-lg-6 d-flex align-items-center">
                    <label class="col-form-label col-lg-3">Mail Driver</label>
                    <div class="col-lg-9">
                        <input type="text" name="values[mail_driver]" value="{{ settings('mail_driver') }}" class="form-control fw-semibold" placeholder="Mail Driver">
                    </div>
                </div>
                <div class="col-lg-6 d-flex align-items-center">
                    <label class="col-form-label col-lg-3">Mail Host</label>
                    <div class="col-lg-9">
                        <input type="text" name="values[mail_host]" value="{{ settings('mail_host') }}" class="form-control fw-semibold" placeholder="Mail Host">
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-lg-6 d-flex align-items-center">
                    <label class="col-form-label col-lg-3">Mail Port</label>
                    <div class="col-lg-9">
                        <input type="text" name="values[mail_port]" value="{{ settings('mail_port') }}" class="form-control fw-semibold" placeholder="Mail Port">
                    </div>
                </div>
                <div class="col-lg-6 d-flex align-items-center">
                    <label class="col-form-label col-lg-3">Mail Username</label>
                    <div class="col-lg-9">
                        <input type="text" name="values[mail_username]" value="{{ settings('mail_username') }}" class="form-control fw-semibold" placeholder="Mail Username">
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-lg-6 d-flex align-items-center">
                    <label class="col-form-label col-lg-3">Mail Password</label>
                    <div class="col-lg-9">
                        <input type="password" name="values[mail_password]" value="{{ settings('mail_password') }}" class="form-control fw-semibold" placeholder="Mail Password">
                    </div>
                </div>
                <div class="col-lg-6 d-flex align-items-center">
                    <label class="col-form-label col-lg-3">Mail Encryption</label>
                    <div class="col-lg-9">
                        <input type="text" name="values[mail_encryption]" value="{{ settings('mail_encryption') }}" class="form-control fw-semibold" placeholder="Mail Encryption">
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-lg-6 d-flex align-items-center">
                    <label class="col-form-label col-lg-3">Mail From Address</label>
                    <div class="col-lg-9">
                        <input type="text" name="values[mail_from_address]" value="{{ settings('mail_from_address') }}" class="form-control fw-semibold" placeholder="Mail From Address">
                    </div>
                </div>
                <div class="col-lg-6 d-flex align-items-center">
                    <label class="col-form-label col-lg-3">Mail From Name</label>
                    <div class="col-lg-9">
                        <input type="text" name="values[mail_from_name]" value="{{ settings('mail_from_name') }}" class="form-control fw-semibold" placeholder="Mail From Name">
                    </div>
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">Save Changes<i class="ph-paper-plane-tilt ms-2"></i></button>
            </div>
        </form>

    </div>
</div>
@endsection
