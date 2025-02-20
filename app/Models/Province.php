<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Province
 *
 * @property $id
 * @property $name
 * @property $created_at
 * @property $updated_at
 *
 * @property Participant[] $participants
 * @property State[] $states
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Province extends Model implements Auditable
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
    protected $fillable = ['name'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participants()
    {
        return $this->hasMany('App\Models\Participant', 'province_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function states()
    {
        return $this->hasMany('App\Models\State', 'province_id', 'id');
    }
}
