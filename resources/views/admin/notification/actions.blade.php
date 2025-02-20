@canany(['notifications-view', 'notifications-delete'])
<div class="d-inline-flex">
    <div class="dropdown">
        <a href="#" class="text-body" data-bs-toggle="dropdown">
            <i class="ph-list"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-end">
            <form action="{{ route('notifications.destroy',$notification->id) }}" method="POST">
                @csrf
                @method('DELETE')
                @can('notifications-view')
                    @if(!$notification->read_at)
                        <a href="{{ route('notifications.show',$notification->id) }}" class="dropdown-item">
                            <i class="ph-eye me-2"></i>{{ __('Mark as Read') }}
                        </a>
                    @endif
                @endcan
                @can('notifications-delete')
                    <button type="submit" class="dropdown-item sa-confirm">
                        <i class="ph-trash me-2"></i>{{ __('Delete') }}
                    </button>
                @endcan
            </form>
        </div>
    </div>
</div>
@endcanany