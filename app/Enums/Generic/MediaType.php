<?php

namespace App\Enums\Generic;

use App\Traits\Enums;

enum MediaType: string
{
    use Enums;
    case PROFILE_PICTURE = 'profile_picture';
    case CNIC_FRONT = 'cnic_front';
    case CNIC_BACK = 'cnic_back';
    case DEFAULT = 'default';
}
