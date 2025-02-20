@extends('auth.layout.app')

@section('page_title', 'Login')

@section('page_content')
<form class="login-form validate" method="POST" action="{{ route('login') }}">
    @csrf
    <div class="card mb-0">
        <div class="card-body">
            <div class="text-center mb-3">
                <div class="d-flex flex-column align-items-center justify-content-center mt-2">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="" width="125px">
                    <h1>ADMIN PANEL</h1>
                </div>
                <h5 class="mb-0">Login to your account</h5>
                <span class="d-block text-muted">Enter your credentials below</span>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger border-0 alert-dismissible fade show">
                    @foreach ($errors->all() as $error)
                    <span class="fw-semibold">Oh snap!</span> {{ $error }}
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            <div class="mb-3">
                <label class="form-label">Email</label>
                <div class="form-control-feedback form-control-feedback-start">
                    <input type="email" name="email" class="form-control" placeholder="john@doe.com" required>
                    <div class="form-control-feedback-icon">
                        <i class="ph-user-circle text-muted"></i>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="form-control-feedback form-control-feedback-start">
                    <input type="password" name="password" class="form-control" placeholder="•••••••••••" required>
                    <div class="form-control-feedback-icon">
                        <i class="ph-lock text-muted"></i>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center mb-3">
                <label class="form-check">
                    <input type="checkbox" name="remember" class="form-check-input" checked>
                    <span class="form-check-label">Remember</span>
                </label>
                <a href="{{ route('password.request') }}" class="ms-auto">Forgot password?</a>
            </div>
            <div class="mb-2">
                <button type="submit" class="btn btn-primary w-100">Sign in</button>
            </div>
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
                password: {
                    required: true
                },
                email:{
                    required: true
                }
            },
            messages:{
                password:{
                    required: "Please enter your password.",
                },
                email:{
                    required: "Please enter a valid email address.",
                }
            }
        });
    });
</script>
@endsection
