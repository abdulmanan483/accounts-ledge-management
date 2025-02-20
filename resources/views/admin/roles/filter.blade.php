<div class="card-body">
    <form method="get">
        <div class="row">
            <div class="form-group col-md-9">
                {{ Form::text('search', request()->search, ['class' => 'form-control', 'placeholder' => 'Search Name']) }}
            </div>
            <div class="col-lg-3">
                <div class="row p-0">
                    <div class="form-group col-md-6 p-0">
                        <button type="submit" class="btn btn-primary form-control">
                            Search <i class="ph-paper-plane-tilt ms-2"></i>
                        </button>
                    </div>
                    <div class="form-group col-md-6">
                        <a href="{{ route('roles.index') }}" type="reset" class="btn btn-secondary form-control">
                            Clear <i class="ph-trash ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>