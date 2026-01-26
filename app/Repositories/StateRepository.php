<?php

namespace App\Repositories;

use App\Models\State;
use App\Interfaces\StateInterface;
use App\Repositories\BaseRepository;

class StateRepository extends BaseRepository implements StateInterface
{
    public function __construct(State $model)
    {
        parent::__construct($model);
    }
}
