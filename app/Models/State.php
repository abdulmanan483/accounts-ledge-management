<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class State
 *
 * @property $id
 * @property $country_id
 * @property $name
 * @property $country_code
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class State extends BaseModel implements Auditable
{

    use \OwenIt\Auditing\Auditable;
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['country_id', 'name', 'country_code'];


}
