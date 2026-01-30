<?php

namespace App\Repositories;

use App\Models\Currency;
use App\Interfaces\CurrencyInterface;
use App\Repositories\BaseRepository;

class CurrencyRepository extends BaseRepository implements CurrencyInterface
{
    public function __construct(Currency $model)
    {
        parent::__construct($model);
    }
}
