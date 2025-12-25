<?php
namespace App\Enums\Users;

use App\Traits\Enums;

enum UserApprovalStatus:int {
    case PENDING_APPROVAL = 1;
    case APPROVED = 2;
    case REJECTED = 3;
    case REMOVED = 4;
    case LEFT = 5;
    // public function label(): string
    // {
    //     return match ($this) {
    //         self::PENDING_APPROVAL => 'Pending Approval',
    //         self::APPROVED => 'Approved',
    //         self::REJECTED => 'Rejected',
    //         self::REMOVED => 'Removed',
    //         self::LEFT => 'Left',
    //     };
    // }
}
