@extends('admin.layout.app')

@section('title', 'Locations')

@section('header')
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0">
                Home - <span class="fw-normal">Location Management</span>
            </h4>
        </div>
        @can('locations-create')
            <div class="d-lg-block my-lg-auto ms-lg-auto">
                <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3">
                    <a href="{{ route('locations.create') }}"
                        class="btn btn-outline-primary btn-labeled btn-labeled-start rounded-pill">
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
                <h5 class="mb-0">Locations</h5>
            </div>
            <table class="table datatable-basic">
                <thead class="thead">
                    <tr>
                        <th>No</th>

                        <th>State</th>
                        <th>City</th>
                        <th>Site</th>
                        <th>Floor</th>
                        <th>Block</th>
                        <th>Department</th>
                        <th>Name</th>
                        {{-- <th>Description</th> --}}
                        <th>Active</th>

                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($locations as $key => $location)
                        <tr>
                            <td>{{ ++$key }}</td>

                            <td>{{ $location->state?->name }}</td>
                            <td>{{ $location->city?->name }}</td>
                            <td>{{ $location->site?->name }}</td>
                            <td>{{ $location->floor?->name }}</td>
                            <td>{{ $location->block?->name }}</td>
                            {{-- <td>{{ $location->department?->name }}</td> --}}
                            <td>{{ $location->name }}</td>
                            <td>{{ $location->description }}</td>
                            <td class="text-center">
                                {!! $location->is_active
                                    ? view('components.admin.badges.success', ['message' => 'Active'])
                                    : view('components.admin.badges.danger', ['message' => 'Inactive']) !!}
                            </td>
                            <td class="text-center">@include('admin.location.actions')</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $locations->appends(request()->query())->links('vendor.pagination.bordered-rounded') }}
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function() {
            const swalInit = swal.mixin({
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-light'
                }
            });
            $(".sa-confirm").click(function(event) {
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
