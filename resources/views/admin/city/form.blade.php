<div class="row">
    <div class="form-group col-lg-6 mb-3">
        {{ html()->label('State')->for('state_id') }}
        {{ html()->select('state_id', states(country_id:settings('default_country_id')), $city->state_id)->class('form-control form-select')->placeholder('--Select--')->required() }}
    </div>
    <div class="form-group col-lg-6 mb-3">

        {{ html()->label('Name')->for('name') }}
        {{ html()->text('name', $city->name)->class('form-control')->placeholder('Name')->required() }}
    </div>
	<div class="col-md-12 d-flex justify-content-end align-items-center mt-3">
		<button type="submit" class="btn btn-primary ms-3">
			Submit <i class="ph-paper-plane-tilt ms-2"></i>
		</button>
	</div>
</div>
