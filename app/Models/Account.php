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
    protected $fillable = [
        'name',
        'currency_id',
        'bank_name',
        'account_title',
        'account_number',
        'iban',
        'branch_name',
        'branch_code',
        'swift_code',
        'opening_balance', 'current_balance', 'total_debit', 'total_credit', 'created_by', 'updated_by', 'deleted_by'];

    public function transactionLines()
    {
        return $this->hasManyThrough(
            TransactionLine::class,
            TransactionHeader::class,
            'account_id',
            'txn_header_id'
        );
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
}
