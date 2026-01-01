@extends('admin.layout.app')

@section('title','Profile')

@section('header')
<div class="page-header-content d-lg-flex">
    <div class="d-flex">
        <h4 class="page-title mb-0">
            Home - <span class="fw-normal">User Profile</span>
        </h4>
    </div>
</div>
@endsection

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">{{ __('Edit Profile') }}</h5>
        </div>
        <div class="card-body">
            {{ html()->form('POST', route('users.profileUpdate'))->attribute('class', 'validate')->attribute('role', 'form')->attribute('enctype', 'multipart/form-data')->open() }}
                @csrf
                {{ html()->hidden('id', Auth::user()->id) }}
                <div class="row">
                    <div class="col-8">
                        <div class="row">
                            <div class="form-group col-lg-6 mb-3">
                                {{ html()->label('Name')->for('name') }}
                                {{ html()->text('name', Auth::user()->name)->class('form-control' . ($errors->has('name') ? ' is-invalid' : ''))->placeholder('Name')->required() }}
                                {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                            <div class="form-group col-lg-6 mb-3">
                                {{ html()->label('Email')->for('email') }}
                                {{ html()->email('email', Auth::user()->email)->class('form-control' . ($errors->has('email') ? ' is-invalid' : ''))->placeholder('Email')->required() }}
                                {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                            <div class="form-group col-lg-6 mb-3">
                                {{ html()->label('Old password')->for('old_password') }}
                                {{ html()->password('old_password')->class('form-control' . ($errors->has('old_password') ? ' is-invalid' : ''))->placeholder('Old Password')->id('old_password') }}
                                {!! $errors->first('old_password', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                            <div class="form-group col-lg-6 mb-3">
                                {{ html()->label('New password')->for('new_password') }}
                                {{ html()->password('new_password')->class('form-control' . ($errors->has('new_password') ? ' is-invalid' : ''))->placeholder('New Password')->id('new_password') }}
                                {!! $errors->first('new_password', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                            <div class="form-group col-lg-6 mb-3">
                                {{ html()->label('Confirm password')->for('confirm_password') }}
                                {{ html()->password('confirm_password')->class('form-control' . ($errors->has('confirm_password') ? ' is-invalid' : ''))->placeholder('Confirm Password') }}
                                {!! $errors->first('confirm_password', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-4 form-group">
                        {{ html()->label('Image')->for('profile_picture') }}
                        {{ html()->file('profile_picture')->class('form-control dropify' . ($errors->has('profile_picture') ? ' is-invalid' : ''))->attribute('accept', 'image/png,image/jpg,image/jpeg')->attribute('data-default-file', secure_file_url(auth()->user()->profile_picture))->attribute('data-height', '200') }}
                        {!! $errors->first('profile_picture', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="col-md-12 d-flex justify-content-end align-items-center mt-3">
                        {{ html()->button('Submit')->class('btn btn-primary ms-3')->attribute('type', 'submit')->attribute('onclick', 'this.form.submit()') }}
                    </div>
                </div>
            {{ html()->form()->close() }}
        </div>
    </div>
</div>
@endsection


@section('script')
<script>
    $(function(){
        var _token = $("input[name='_token']").val();
        var password = $('#new_password');
        var oldpassword = $('#old_password');
        $.validator.addMethod('filesize', function (value, element, param) {
            return this.optional(element) || (element.files[0].size <= param)
        }, 'File size must be less than 1 MB');
        $('.validate').validate({
            errorClass: 'validation-invalid-label',
            successClass: 'validation-valid-label',
            validClass: 'validation-valid-label',
            highlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
                $(element).addClass('is-invalid');
                $(element).removeClass('is-valid');
            },
            unhighlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
                $(element).removeClass('is-invalid');
                $(element).addClass('is-valid');
            },
            success: function(label) {
                label.addClass('validation-valid-label').text('Success.');
            },
            errorPlacement: function(error, element) {
                if (element.hasClass('select2-hidden-accessible')) {
                    error.appendTo(element.parent());
                }else if (element.parents().hasClass('form-control-feedback') || element.parents().hasClass('form-check') || element.parents().hasClass('input-group')) {
                    error.appendTo(element.parent().parent());
                }else {
                    error.insertAfter(element);
                }
            },
            rules:{
                image: {filesize  : 1000000},
                new_password: {
                    required: function(){if (oldpassword.val().length != 0) {return true}else{return false}},
                    minlength:8,
                    maxlength:15
                },
                confirm_password:{
                    required: function(){if (password.val().length != 0) {return true}else{return false}},
                    equalTo: "#new_password"
                },
                email:{
                    "remote":
                    {
                        url: "{{ route('users.checkEmail') }}",
                        type: "POST",
                        data: {
                            _token:_token,
                            id: function() {
                                return $("input[name='id']").val();
                            },
                            email: function() {
                                return $("input[name='email']").val();
                            }
                        },
                    }
                },
                old_password:{
                    "remote":
                    {
                        url: "{{ route('users.checkPassword') }}",
                        type: "POST",
                        data: {
                            _token:_token,
                            id: function() {
                                return $("input[name='id']").val();
                            },
                            old_password: function() {
                                return $("input[name='old_password']").val();
                            }
                        },
                    }
                }
            },
            messages:{
                email:{
                    required: "Please enter a valid email address.",
                    remote: jQuery.validator.format("{0} is already exist.")
                },
                old_password:{
                    remote: jQuery.validator.format("Old password {0} is incorrect.")
                }
            }
        });
    });
    $(document).ready(function() {
        $('.dropify').dropify();
    });
</script>
@endsection
