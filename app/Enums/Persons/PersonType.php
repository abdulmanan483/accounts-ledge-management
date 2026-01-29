<?php

namespace App\Enums\Persons;

use App\Traits\Enums;

enum PersonType: string
{
    use Enums;
    case CUSTOMER = 'customer';
    case SUPPLIER = 'supplier';
    case EMPLOYEE = 'employee';
}
