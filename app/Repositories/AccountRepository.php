<?php

namespace App\Repositories;

use App\Models\Account;
use App\Interfaces\AccountInterface;
use App\Repositories\BaseRepository;

class AccountRepository extends BaseRepository implements AccountInterface
{
    public function __construct(Account $model)
    {
        parent::__construct($model);
    }
}
