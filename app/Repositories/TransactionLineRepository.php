<?php

namespace App\Repositories;

use App\Interfaces\TransactionLineInterface;
use App\Models\TransactionLine;

class TransactionLineRepository extends BaseRepository implements TransactionLineInterface
{
    public function __construct(TransactionLine $model)
    {
        parent::__construct($model);
    }
}
