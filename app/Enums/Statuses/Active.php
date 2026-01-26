<?php

namespace App\Enums\Statuses;

use App\Traits\Enums;

enum Active: int
{
    use Enums;
    case ACTIVE = 1;
    case INACTIVE = 0;
}
