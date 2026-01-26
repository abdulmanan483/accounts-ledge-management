<?php

namespace App\Repositories;

use App\Models\Country;
use App\Interfaces\CountryInterface;
use App\Repositories\BaseRepository;

class CountryRepository extends BaseRepository implements CountryInterface
{
    public function __construct(Country $model)
    {
        parent::__construct($model);
    }
}
