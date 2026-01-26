@extends('admin.layout.app')

@section('title', 'Media')

@section('header')
<div class="page-header-content d-lg-flex">
    <div class="d-flex">
        <h4 class="page-title mb-0">
            Home - <span class="fw-normal">Media Management</span>
        </h4>
    </div>
    @can('media-create')
    <div class="d-lg-block my-lg-auto ms-lg-auto">
        <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3">
            <a href="{{ route('media.create') }}" class="btn btn-outline-primary btn-labeled btn-labeled-start rounded-pill">
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
            <h5 class="mb-0">Media</h5>
        </div>
        <table class="table datatable-basic">
            <thead class="thead">
                <tr>
                    <th>No</th>

									<th >File Name</th>
									<th >File Path</th>
									<th >Mime Type</th>
									<th >File Size</th>
									<th >Type</th>
									<th >Mediable Type</th>
									<th >Mediable Id</th>
									<th >Created By</th>
									<th >Updated By</th>
									<th >Deleted By</th>

                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($media as $key => $media)
                    <tr>
                        <td>{{ ++$key }}</td>

										<td >{{ $media->file_name }}</td>
										<td >{{ $media->file_path }}</td>
										<td >{{ $media->mime_type }}</td>
										<td >{{ $media->file_size }}</td>
										<td >{{ $media->type }}</td>
										<td >{{ $media->mediable_type }}</td>
										<td >{{ $media->mediable_id }}</td>
										<td >{{ $media->created_by }}</td>
										<td >{{ $media->updated_by }}</td>
										<td >{{ $media->deleted_by }}</td>

                        <td class="text-center">@include('admin.media.actions')</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $media->appends(request()->query())->links('vendor.pagination.bordered-rounded') }}
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
