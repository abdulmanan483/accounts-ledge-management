@extends('admin.layout.app')

@section('title', 'Cities')

@section('header')
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0">
                Home - <span class="fw-normal">City Management</span>
            </h4>
        </div>
        @can('cities-create')
            <div class="d-lg-block my-lg-auto ms-lg-auto">
                <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3">
                    <a href="{{ route('cities.create') }}"
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
                <h5 class="mb-0">Cities</h5>
            </div>
            <div class="p-3 pb-0">
                <form method="GET" class="mb-3">
                    <label for="pagination_mode">Pagination Mode:</label>
                    <select name="pagination_mode" id="pagination_mode" onchange="this.form.submit()"
                        class="form-select w-auto d-inline-block ms-2">
                        <option value="server"
                            {{ request('pagination_mode') == '' || request('pagination_mode') === 'server' ? 'selected' : '' }}>
                            Server-side
                        </option>
                        <option value="client" {{ request('pagination_mode') === 'client' ? 'selected' : '' }}>Client-side
                        </option>
                    </select>
                </form>
            </div>
            <table class="table datatable-basic">
                <thead class="thead">
                    <tr>
                        <th>No</th>

                        <th>Country Id</th>
                        <th>State Id</th>
                        <th>Name</th>
                        <th>Country Code</th>

                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cities as $key => $city)
                        <tr>
                            <td>{{ ++$key }}</td>

                            <td>{{ $city->country_id }}</td>
                            <td>{{ $city->state_id }}</td>
                            <td>{{ $city->name }}</td>
                            <td>{{ $city->country_code }}</td>

                            <td class="text-center">@include('admin.city.actions')</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if (request('pagination_mode') == '' || request('pagination_mode') === 'server')
                {{ $cities->appends(request()->query())->links('vendor.pagination.flat-rounded') }}
            @endif
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
