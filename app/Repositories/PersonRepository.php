<?php

namespace App\Repositories;

use App\Models\Person;
use App\Interfaces\PersonInterface;
use App\Repositories\BaseRepository;

class PersonRepository extends BaseRepository implements PersonInterface
{
    public function __construct(Person $model)
    {
        parent::__construct($model);
    }
}
