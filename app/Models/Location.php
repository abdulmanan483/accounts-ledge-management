<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\State;
use OwenIt\Auditing\Contracts\Auditable;

class Location extends BaseModel
{
    protected $fillable = [
        'state_id', 'city_id', 'site_id', 'floor_id', 'block_id', 'department_id', 'name', 'description', 'is_active'
    ];

    /**
     * Relations
     */

    // Each Location belongs to a State
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    // Each Location belongs to a City
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    // Each Location belongs to a Site
    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    // Each Location belongs to a Floor
    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    // Each Location belongs to a Block
    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    // Each Location belongs to a Department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
