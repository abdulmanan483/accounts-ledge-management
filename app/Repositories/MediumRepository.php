<?php

namespace App\Repositories;

use App\Models\Media;
use App\Interfaces\MediumInterface;
use App\Repositories\BaseRepository;

class MediumRepository extends BaseRepository implements MediumInterface
{
    public function __construct(Media $model)
    {
        parent::__construct($model);
    }

    // Optional: You can remove this entirely if all media logic is handled in the trait
    // Or keep it for consistency with other repositories
}
