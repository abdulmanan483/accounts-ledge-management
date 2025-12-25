@extends('admin.layout.app')

@section('title', 'Users')

@section('header')
<div class="page-header-content d-lg-flex">
    <div class="d-flex">
        <h4 class="page-title mb-0">
            Home - <span class="fw-normal">User Management</span>
        </h4>
    </div>
    @can('users-create')
    <div class="d-lg-block my-lg-auto ms-lg-auto">
        <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3">
            <a href="{{ route('users.create') }}" class="btn btn-outline-primary btn-labeled btn-labeled-start rounded-pill">
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
            <h5 class="mb-0">Users</h5>
        </div>
        <div class="p-3 pb-0">
            <form method="GET" class="mb-3">
                <label for="pagination_mode">Pagination Mode:</label>
                <select name="pagination_mode" id="pagination_mode" onchange="this.form.submit()"
                    class="form-select w-auto d-inline-block ms-2">
                    <option value="server" {{ request('pagination_mode') === 'server' ? 'selected' : '' }}>Server-side
                    </option>
                    <option value="client" {{ request('pagination_mode') == '' || request('pagination_mode') === 'client' ? 'selected' : '' }}>Client-side
                    </option>
                </select>
            </form>
        </div>
        <table class="table datatable-basic">
            <thead class="thead">
                <tr>
                    <th>No</th>
                    
									<th >Name</th>
									<th >Email</th>
									<th >Image</th>
									<th >User Type</th>
									<th >Is Active</th>
									<th >Created By</th>
									<th >Updated By</th>
									<th >Deleted By</th>
									<th >Registration Date</th>
									<th >Gender</th>
									<th >Profile Picture</th>
									<th >External Profile Pic</th>
									<th >Cnic</th>
									<th >Mobile No</th>
									<th >Cnic Front</th>
									<th >External Cnic Front</th>
									<th >Cnic Back</th>
									<th >External Cnic Back</th>
									<th >Current City</th>
									<th >Current City Id</th>
									<th >Current Address</th>
									<th >Permanent Country Id</th>
									<th >Permanent City Id</th>
									<th >Permanent Address</th>
									<th >Current Country</th>
									<th >Current Country Id</th>
									<th >Educational Qualifications</th>
									<th >Skills</th>
									<th >Data Source</th>
									<th >Form No</th>
									<th >Is Pakistani</th>
									<th >Is Approved</th>
									<th >Is Added</th>
									<th >Status</th>
									<th >Comments</th>

                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $key => $user)
                    <tr>
                        <td>{{ ++$key }}</td>
                        
										<td >{{ $user->name }}</td>
										<td >{{ $user->email }}</td>
										<td >{{ $user->image }}</td>
										<td >{{ $user->user_type }}</td>
										<td >{{ $user->is_active }}</td>
										<td >{{ $user->created_by }}</td>
										<td >{{ $user->updated_by }}</td>
										<td >{{ $user->deleted_by }}</td>
										<td >{{ $user->registration_date }}</td>
										<td >{{ $user->gender }}</td>
										<td >{{ $user->profile_picture }}</td>
										<td >{{ $user->external_profile_pic }}</td>
										<td >{{ $user->cnic }}</td>
										<td >{{ $user->mobile_no }}</td>
										<td >{{ $user->cnic_front }}</td>
										<td >{{ $user->external_cnic_front }}</td>
										<td >{{ $user->cnic_back }}</td>
										<td >{{ $user->external_cnic_back }}</td>
										<td >{{ $user->current_city }}</td>
										<td >{{ $user->current_city_id }}</td>
										<td >{{ $user->current_address }}</td>
										<td >{{ $user->permanent_country_id }}</td>
										<td >{{ $user->permanent_city_id }}</td>
										<td >{{ $user->permanent_address }}</td>
										<td >{{ $user->current_country }}</td>
										<td >{{ $user->current_country_id }}</td>
										<td >{{ $user->educational_qualifications }}</td>
										<td >{{ $user->skills }}</td>
										<td >{{ $user->data_source }}</td>
										<td >{{ $user->form_no }}</td>
										<td >{{ $user->is_pakistani }}</td>
										<td >{{ $user->is_approved }}</td>
										<td >{{ $user->is_added }}</td>
										<td >{{ $user->status }}</td>
										<td >{{ $user->comments }}</td>

                        <td class="text-center">@include('admin.user.actions')</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if(request('pagination_mode') === 'server')
            {{ $users->appends(request()->query())->links('vendor.pagination.flat-rounded') }}
        @endif
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
