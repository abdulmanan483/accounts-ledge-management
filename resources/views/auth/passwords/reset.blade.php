@extends('auth.layout.app')

@section('page_title', 'Reset Password')

@section('page_content')
<form class="login-form needs-validation" method="POST" action="{{ route('password.update') }}" novalidate>
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="card mb-0">
        <div class="card-body">
            <div class="text-center mb-3">
                <div class="d-inline-flex bg-primary bg-opacity-10 text-primary lh-1 rounded-pill p-3 mb-3 mt-1">
                    <i class="ph-arrows-counter-clockwise ph-2x"></i>
                </div>
                <h5 class="mb-0">{{ __('Reset Password') }}</h5>
                <span class="d-block text-muted">{{ __('Please confirm your password before continuing.') }}</span>
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
            <div class="mb-3">
                <label class="form-label">{{ __('Password') }}</label>
                <div class="form-control-feedback form-control-feedback-start">
                    <input type="password" class="form-control" placeholder="Password" name="password" value="{{ old('password') }}" required>
                    <div class="form-control-feedback-icon">
                        <i class="ph-lock text-muted"></i>
                    </div>
                    <div data-lastpass-icon-root="" style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Confirm Password') }}</label>
                <div class="form-control-feedback form-control-feedback-start">
                    <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" value="{{ old('password_confirmation') }}" required>
                    <div class="form-control-feedback-icon">
                        <i class="ph-lock text-muted"></i>
                    </div>
                    <div data-lastpass-icon-root="" style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">
                <i class="ph-arrow-counter-clockwise me-2"></i>
                {{ __('Reset Password') }}
            </button>
        </div>
    </div>
</form>
@endsection
