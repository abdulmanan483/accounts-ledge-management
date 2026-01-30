<?php

namespace App\Repositories;

use App\Models\TransactionCategory;
use App\Interfaces\TransactionCategoryInterface;
use App\Repositories\BaseRepository;

class TransactionCategoryRepository extends BaseRepository implements TransactionCategoryInterface
{
    public function __construct(TransactionCategory $model)
    {
        parent::__construct($model);
    }
}
