<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Account
 *
 * @property $id
 * @property $name
 * @property $type
 * @property $opening_balance
 * @property $current_balance
 * @property $total_debit
 * @property $total_credit
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 * @property $created_by
 * @property $updated_by
 * @property $deleted_by
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Account extends BaseModel
{
    use SoftDeletes;

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'type', 'opening_balance', 'current_balance', 'total_debit', 'total_credit', 'created_by', 'updated_by', 'deleted_by'];


}
