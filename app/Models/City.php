<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class City
 *
 * @property $id
 * @property $name
 * @property $state_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Participant[] $participants
 * @property State $state
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class City extends Model implements Auditable
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
    protected $fillable = ['name','state_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participants()
    {
        return $this->hasMany('App\Models\Participant', 'city_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function state()
    {
        return $this->hasOne('App\Models\State', 'id', 'state_id');
    }
}
