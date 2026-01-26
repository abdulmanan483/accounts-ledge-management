@extends('auth.layout.app')

@section('page_title', 'Reset Password')

@section('page_content')
<form class="login-form validate" method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="card mb-0">
        <div class="card-body">
            <div class="text-center mb-3">
                <div class="d-inline-flex bg-primary bg-opacity-10 text-primary lh-1 rounded-pill p-3 mb-3 mt-1">
                    <i class="ph-arrows-counter-clockwise ph-2x"></i>
                </div>
                <h5 class="mb-0">{{ __('Reset Password') }}</h5>
                <span class="d-block text-muted">We'll send you instructions in email</span>
            </div>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger border-0 alert-dismissible fade show">
                    @foreach ($errors->all() as $error)
                    <span class="fw-semibold">Oh snap!</span> {{ $error }}
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            <div class="mb-3">
                <label class="form-label">{{ __('Email Address') }}</label>
                <div class="form-control-feedback form-control-feedback-start">
                    <input type="email" class="form-control" placeholder="john@doe.com" name="email" value="{{ old('email') }}" required>
                    <div class="form-control-feedback-icon">
                        <i class="ph-at text-muted"></i>
                    </div>
                    <div data-lastpass-icon-root="" style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">
                <i class="ph-arrow-counter-clockwise me-2"></i>
                {{ __('Send Password Reset Link') }}
            </button>
        </div>
        <div class="text-center my-3">
            <a href="{{ route('login') }}" class="text-muted">
                <i class="ph-arrow-left me-1"></i>{{ __('Back to Login') }}
            </a>
        </div>
    </div>
</form>
@endsection

@section('page_script')
<script>
    $(function(){
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
                email:{
                    required: true
                }
            },
            messages:{
                email:{
                    required: "Please enter a valid email address.",
                }
            }
        });
    });
</script>
@endsection
