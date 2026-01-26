<?php
namespace App\Enums\Permissions;

use App\Traits\Enums;

enum PermissionType: string
{
    use Enums;
    case ADMIN_PANEL = 'admin_panel';
    case MOBILE_APP = 'mobile_app';
}
