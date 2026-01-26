<x-admin.badges.badge :type="$status->value === App\Enums\Statuses\Active::ACTIVE->value ? 'primary' : 'danger'"
    :message="$status->label()" />
