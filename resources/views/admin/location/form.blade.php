{{-- @dd($errors) --}}
<div class="row">
    <div class="form-group col-lg-6 mb-3">
        {{ html()->label('City')->for('city_id') }}
        @php
            $citiesGroupedByState = cities(true, true); // Fetch cities grouped by state
        @endphp

        {{ html()->select('city_id')->placeholder('--Select--')->class('form-control form-select select' . ($errors->has('city_id') ? ' is-invalid' : ''))->children($citiesGroupedByState, function ($cities, $state) use ($location) {
                return html()->select()->value(old('city_id', $location?->city_id))->optgroup($state, $cities);
            }) }}

        {!! $errors->first('city_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
    </div>

    <div class="form-group col-lg-6 mb-3">
        {{ html()->label('Site')->for('site_id') }}
        {{ html()->select('site_id', sites(), old('site_id', $location?->site_id))->class('form-control form-select select' . ($errors->has('site_id') ? ' is-invalid' : ''))->placeholder('--Select--')->required() }}
        {!! $errors->first('site_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
    </div>

    <div class="form-group col-lg-6 mb-3">
        {{ html()->label('Floor')->for('floor_id') }}
        {{ html()->select('floor_id', floors(), old('floor_id', $location?->floor_id))->class('form-control form-select select' . ($errors->has('floor_id') ? ' is-invalid' : ''))->placeholder('--Select--')->required() }}
        {!! $errors->first('floor_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
    </div>

    <div class="form-group col-lg-6 mb-3">
        {{ html()->label('Block')->for('block_id') }}
        {{ html()->select('block_id', blocks(), old('block_id', $location?->block_id))->class('form-control form-select select' . ($errors->has('block_id') ? ' is-invalid' : ''))->placeholder('--Select--')->required() }}
        {!! $errors->first('block_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
    </div>

    <div class="form-group col-lg-6 mb-3">
        {{ html()->label('Department')->for('department_id') }}
        {{ html()->select('department_id', departments(), old('department_id', $location?->department_id))->class('form-control form-select select' . ($errors->has('department_id') ? ' is-invalid' : ''))->placeholder('--Select--')->required() }}
        {!! $errors->first(
            'department_id',
            '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>',
        ) !!}
    </div>

    <div class="form-group col-lg-6 mb-3">
        {{ html()->label('Name')->for('name') }}
        {{ html()->text('name', old('name', $location?->name))->class('form-control' . ($errors->has('name') ? ' is-invalid' : ''))->placeholder('Name') }}
        {!! $errors->first('name', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
    </div>

    <div class="form-group col-lg-6 mb-3">
        {{ html()->label('Description')->for('description') }}
        {{ html()->text('description', old('description', $location?->description))->class('form-control' . ($errors->has('description') ? ' is-invalid' : ''))->placeholder('Description') }}
        {!! $errors->first('description', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
    </div>

    <div class="form-group col-lg-6 mb-3 d-flex flex-column form-switch mt-1">
        {{ html()->label('Is Active') }}
        {{ html()->checkbox('is_active', old('is_active', $location?->is_active), true)
        ->class('form-check-input custom-switch  ' . ($errors->has('is_active') ? ' is-invalid' : ''))->id('is_active') }}
        {!! $errors->first('is_active', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
    </div>

    <div class="col-md-12 d-flex justify-content-end align-items-center mt-3">
        {{ html()->submit('Submit')->class('btn btn-primary ms-3') }}
    </div>
</div>

@section('script')
    <script>
        $(function() {
            $('.select').select2();
        });
    </script>
@endsection
