<?php
namespace App\Enums\Users;

use App\Traits\Enums;

enum UserApprovalStatus:int {
    use Enums;
    case PENDING_APPROVAL = 1;
    case APPROVED = 2;
    case REJECTED = 3;
    case REMOVED = 4;
    case LEFT = 5;
}
