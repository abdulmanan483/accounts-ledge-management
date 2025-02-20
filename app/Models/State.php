<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class State
 *
 * @property $id
 * @property $name
 * @property $province_id
 * @property $created_at
 * @property $updated_at
 *
 * @property City[] $cities
 * @property Participant[] $participants
 * @property Province $province
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class State extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    /**
     * Default number of items per page.
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->perPage = settings('per_page_items') ? : 15;
    }

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','province_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities()
    {
        return $this->hasMany('App\Models\City', 'state_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participants()
    {
        return $this->hasMany('App\Models\Participant', 'state_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function province()
    {
        return $this->hasOne('App\Models\Province', 'id', 'province_id');
    } 
}
