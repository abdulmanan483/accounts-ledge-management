<x-admin.badges.badge
    :type="match($status) {
        App\Enums\Users\UserApprovalStatus::APPROVED => 'primary',
        App\Enums\Users\UserApprovalStatus::PENDING_APPROVAL => 'warning',
        App\Enums\Users\UserApprovalStatus::REJECTED => 'danger',
        App\Enums\Users\UserApprovalStatus::REMOVED => 'secondary',
        App\Enums\Users\UserApprovalStatus::LEFT => 'dark',
        default => 'secondary',
    }"
    :message="$status->name"
/>
