<?php

namespace App\Enums\Accounts;

use App\Traits\Enums;

enum AccountType: string
{
    use Enums;
    case BANK = 'bank';
    case CASH = 'cash';
    case EXPENSE = 'expense';
}
