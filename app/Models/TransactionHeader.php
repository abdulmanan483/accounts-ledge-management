<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionHeader extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'txn_id',
        'transaction_category_id',
        'account_id',
        'currency_id',
        'person_id',
        'txn_date',
        'reference',
        'total_debit',
        'total_credit',
        'balance',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'txn_date' => 'date',
    ];

    /**
     * Header belongs to an Account
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
    /**
     * Header belongs to a Currency
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Header belongs to a Person
     */
    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * Header has many transaction lines
     */
    public function lines()
    {
        return $this->hasMany(TransactionLine::class, 'txn_header_id');
    }
    /**
     * Header belongs to a Transaction Category
     */
    public function transaction_category()
    {
        return $this->belongsTo(TransactionCategory::class);
    }

    /**
     * Total Debit of this bill
     */
    public function getTotalDebitAttribute()
    {
        return $this->lines->sum('debit');
    }

    /**
     * Total Credit of this bill
     */
    public function getTotalCreditAttribute()
    {
        return $this->lines->sum('credit');
    }
}
