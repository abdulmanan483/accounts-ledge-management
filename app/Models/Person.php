<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Person
 *
 * @property $id
 * @property $name
 * @property $phone_no
 * @property $type
 * @property $created_at
 * @property $updated_at
 * @property $created_by
 * @property $updated_by
 * @property $deleted_by
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Person extends BaseModel
{
    protected $table = 'persons';
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'phone_no', 'type','total_debit','total_credit','current_balance', 'created_by', 'updated_by', 'deleted_by'];

    public function transactionLines()
    {
        return $this->hasManyThrough(
            TransactionLine::class,
            TransactionHeader::class,
            'person_id',
            'txn_header_id'
        );
    }
}
