<div class="row">
    <div class="form-group col-lg-6 mb-3">
        {!! html()->label('Name')->for('name') !!}
        {!! html()->text('name', $user->name)
            ->class('form-control' . ($errors->has('name') ? ' is-invalid' : ''))
            ->placeholder('Name')
            ->required() !!}
        {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="form-group col-lg-6 mb-3">
        {!! html()->label('Email')->for('email') !!}
        {!! html()->text('email', $user->email)
            ->class('form-control' . ($errors->has('email') ? ' is-invalid' : ''))
            ->placeholder('Email')
            ->required() !!}
        {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="form-group col-lg-6 mb-3">
        {!! html()->label('Password')->for('password') !!}
        {!! html()->password('password')
            ->class('form-control' . ($errors->has('password') ? ' is-invalid' : ''))
            ->placeholder('Password')
            ->id('password') !!}
        {!! $errors->first('password', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="form-group col-lg-6 mb-3">
        {!! html()->label('Confirm Password')->for('confirm_password') !!}
        {!! html()->password('confirm_password')
            ->class('form-control' . ($errors->has('confirm_password') ? ' is-invalid' : ''))
            ->placeholder('Confirm Password') !!}
        {!! $errors->first('confirm_password', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="form-group col-lg-12">
        {!! html()->label('Roles')->for('roles') !!}
        {!! html()->select('roles[]', roles(), $user->roles)
            ->class('form-control select m-b-10 select2-multiple' . ($errors->has('roles') ? ' is-invalid' : ''))
            ->attribute('data-placeholder', '--Select--')
            ->multiple()
            ->required() !!}
        {!! $errors->first('roles', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="col-md-12 d-flex justify-content-end align-items-center mt-3">
        {!! html()->submit('Submit')
            ->class('btn btn-primary ms-3')
            ->attribute('aria-label', 'Submit Form')
            ->html('Submit <i class="ph-paper-plane-tilt ms-2"></i>') !!}
    </div>
</div>
