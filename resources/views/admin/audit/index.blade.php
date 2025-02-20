@extends('admin.layout.app')

@section('title','Audit')

@section('header')
<div class="page-header-content d-lg-flex">
    <div class="d-flex">
        <h4 class="page-title mb-0">
            Home - <span class="fw-normal">Audit Managment</span>
        </h4>
    </div>
</div>
@endsection

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Audit</h5>
        </div>
        <table class="table datatable-basic">
            <thead class="thead">
                <tr>
                    <th>No</th>
                    <th>Model</th>
                    <th>Record ID</th>
                    <th>User</th>
                    <th>Time</th>
                    <th>Event</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($audits as $key => $audit)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $audit->auditable_type }}</td>
                        <td>{{ $audit->auditable_id }}</td>
                        <td>{{ $audit->user?->name }}</td>
                        <td>{{ $audit->created_at }}</td>
                        <td>
                            @php($status = ucfirst($audit->event))
                            @if($status == 'Created')
                                <span class="badge bg-success rounded-pill">{{ $status }}</span>
                            @elseif($status == 'Updated')
                                <span class="badge bg-info rounded-pill">{{ $status }}</span>
                            @else
                                <span class="badge bg-warning rounded-pill">{{ $status }}</span>
                            @endif
                        </td>
                        <td class="text-center">@include('admin.audit.actions')</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $audits->appends(request()->query())->links('vendor.pagination.bordered-rounded') }}
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
                cancelButton: 'btn btn-light',
                denyButton: 'btn btn-light',
                input: 'form-control'
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
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                }
            }).then((result) => {
                if (result.value === true)  $(this).closest("form").submit();
            });
        });
    });
</script>
@endsection