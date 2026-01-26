@extends('admin.layout.app')

@section('title','Notifications')

@section('header')
<div class="page-header-content d-lg-flex">
    <div class="d-flex">
        <h4 class="page-title mb-0">
            Home - <span class="fw-normal">Notifications Managment</span>
        </h4>
    </div>
</div>
@endsection

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">{{ __('Notifications') }}</h5>
        </div>
        <table class="table datatable-basic">
            <thead class="thead">
                <tr>
                    <th>No</th>
                    <th>Title</th>
                    <th>Message</th>
                    <th>Time</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($notifications as  $key => $notification)
                    <tr>
                        <td>{{ ++$key }}</td>
                        @if($notification->read_at)
                        <td>{{ ++$key }}</td>
                        <td>{{ $notification->data['title'] }}</td>
                        <td>{{ $notification->data['message'] }}</td>
                        <td>{{ $notification->created_at->diffForHumans()}}</td>
                        @else
                        <td><dt>{{ ++$key }}</dt></td>
                        <td><dt>{{ $notification->data['title'] }}</dt></td>
                        <td><dt>{{ $notification->data['message'] }}</dt></td>
                        <td><dt>{{ $notification->created_at->diffForHumans()}}</dt></td>
                        @endif
                        <td class="text-center">@include('admin.audit.actions')</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $notifications->links('vendor.pagination.bordered-rounded') }}
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
