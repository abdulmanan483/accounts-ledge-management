<?php

namespace App\Repositories;

use App\Models\City;
use App\Interfaces\CityInterface;
use App\Repositories\BaseRepository;

class CityRepository extends BaseRepository implements CityInterface
{
    public function __construct(City $model)
    {
        parent::__construct($model);
    }
}
