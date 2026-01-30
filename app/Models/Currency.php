<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Currency
 *
 * @property $id
 * @property $country_id
 * @property $name
 * @property $code
 * @property $precision
 * @property $symbol
 * @property $symbol_native
 * @property $symbol_first
 * @property $decimal_mark
 * @property $thousands_separator
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Currency extends BaseModel
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['country_id', 'name', 'code', 'precision', 'symbol', 'symbol_native', 'symbol_first', 'decimal_mark', 'thousands_separator'];


}
