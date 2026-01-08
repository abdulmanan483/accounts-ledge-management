<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Country
 *
 * @property $id
 * @property $iso2
 * @property $name
 * @property $status
 * @property $phone_code
 * @property $iso3
 * @property $region
 * @property $subregion
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Country extends BaseModel implements Auditable
{

    use \OwenIt\Auditing\Auditable;
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['iso2', 'name', 'status', 'phone_code', 'iso3', 'region', 'subregion'];


}
