<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\HasBaseModel;

class BaseModel extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasBaseModel;

    protected $perPage = 20;
}
