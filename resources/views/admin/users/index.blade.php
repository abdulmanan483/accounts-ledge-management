@extends('admin.layout.app')

@section('title', 'Users')

@section('header')
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0">
                Home - <span class="fw-normal">User Managment</span>
            </h4>
        </div>
        <div class="d-lg-block my-lg-auto ms-lg-auto">
            <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3">
                @can('users-create')
                    <a href="{{ route('users.create') }}"
                        class="btn btn-outline-primary btn-labeled btn-labeled-start rounded-pill">
                        <span class="btn-labeled-icon bg-primary text-white rounded-pill">
                            <i class="ph-plus"></i>
                        </span>
                        Create New
                    </a>
                @endcan
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">User</h5>
            </div>
            <div class="p-3 pb-0">
                <form method="GET" class="mb-3">
                    <label for="pagination_mode">Pagination Mode:</label>
                    <select name="pagination_mode" id="pagination_mode" onchange="this.form.submit()"
                        class="form-select w-auto d-inline-block ms-2">
                        <option value="server" {{ request('pagination_mode') === 'server' ? 'selected' : '' }}>Server-side
                        </option>
                        <option value="client"
                            {{ request('pagination_mode') == '' || request('pagination_mode') === 'client' ? 'selected' : '' }}>
                            Client-side
                        </option>
                    </select>
                </form>
            </div>
            <div class=" overflow-auto">
                <table class="table datatable-basic">
                    <thead class="thead">
                        <tr>
                            <th>No</th>
                            <th>Prof. Pic</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Active</th>
                            <th class="text-center" style="min-width:110px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $user)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>
                                    @if ($user->profile_picture)
                                        {{-- <img src="{{ asset('storage/' . $user->external_profile_pic) }}" alt="Profile Picture"
                                        width="50" height="50"> --}}
                                        <img class="m-auto w-100 h-100 rounded-circle"
                                            style="height: 50px !important;width:50px !important;"
                                            src="{{ route('secure.file', urlencode(Crypt::encryptString($user->profile_picture))) }}" />
                                    @else
                                        N/A
                                    @endif
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="text-center">
                                    @if (!empty($user->getRoleNames()))
                                        @foreach ($user->getRoleNames() as $v)
                                            <x-admin.badges.primary :message="$v" />
                                        @endforeach
                                    @endif
                                </td>
                                <td><x-admin.statuses.active-badge :status="$user->is_active" /></td>
                                <td class="text-center">@include('admin.users.actions')</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if (request('pagination_mode') === 'server')
                {{ $users->appends(request()->query())->links('vendor.pagination.flat-rounded') }}
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function() {
            $('.show-filter').click(function() {
                $('.filter-wrapper').toggleClass('d-none');
            });
            const swalInit = swal.mixin({
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-light',
                    denyButton: 'btn btn-light',
                    input: 'form-control'
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
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    }
                }).then((result) => {
                    if (result.value === true) $(this).closest("form").submit();
                });
            });
        });
    </script>
@endsection
