@extends('admin.layout.app')

@section('title', 'Blocks')

@section('header')
<div class="page-header-content d-lg-flex">
    <div class="d-flex">
        <h4 class="page-title mb-0">
            Home - <span class="fw-normal">Block Management</span>
        </h4>
    </div>
    @can('blocks-create')
    <div class="d-lg-block my-lg-auto ms-lg-auto">
        <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3">
            <a href="{{ route('blocks.create') }}" class="btn btn-outline-primary btn-labeled btn-labeled-start rounded-pill">
                <span class="btn-labeled-icon bg-primary text-white rounded-pill">
                    <i class="ph-plus"></i>
                </span>
                Create
            </a>
        </div>
    </div>
    @endcan
</div>
@endsection

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Blocks</h5>
        </div>
        <table class="table datatable-basic">
            <thead class="thead">
                <tr>
                    <th>No</th>
                    
									<th >Code</th>
									<th >Name</th>
									<th >Description</th>

                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($blocks as $key => $block)
                    <tr>
                        <td>{{ ++$key }}</td>
                        
										<td >{{ $block->code }}</td>
										<td >{{ $block->name }}</td>
										<td >{{ $block->description }}</td>

                        <td class="text-center">@include('admin.block.actions')</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $blocks->appends(request()->query())->links('vendor.pagination.bordered-rounded') }}
    </div>
</div>
@endsection

@section('script')
<script>
    $(function () {
        const swalInit = swal.mixin({
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-light'
            }
        });
        $(".sa-confirm").click(function (event) {
            event.preventDefault();
            swalInit.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                }
            }).then((result) => {
                if (result.isConfirmed) $(this).closest("form").submit();
            });
        });
    });
</script>
@endsection
