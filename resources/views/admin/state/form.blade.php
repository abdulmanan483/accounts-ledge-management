<div class="row">
    {{-- <div class="form-group col-lg-6 mb-3">
        {{ html()->label('Province')->for('province_id') }}
        {{ html()->select('province_id', provinces(), $state->province_id)->class('form-control form-select')->placeholder('--Select--')->required() }}
    </div> --}}
    <div class="form-group col-lg-6 mb-3">
        {{ html()->hidden('country_id', settings('default_country_id'))->required() }}
        {{ html()->hidden('country_code', country(settings('default_country_id'))?->iso2??0)->required() }}
        {{ html()->hidden('data_source', old('data_srouce',\App\Enums\Generic\DataSource::CUSTOM->value))->required() }}
        {{ html()->label('Name')->for('name') }}
        {{ html()->text('name', $state->name)->class('form-control')->placeholder('Name')->required() }}
    </div>
	<div class="col-md-12 d-flex justify-content-end align-items-center mt-3">
		<button type="submit" class="btn btn-primary ms-3">
			Submit <i class="ph-paper-plane-tilt ms-2"></i>
		</button>
	</div>
</div>
