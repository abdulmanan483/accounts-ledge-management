<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionLine extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'txn_header_id',
        'description',
        'debit',
        'credit',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * Line belongs to a TransactionHeader
     */
    public function header()
    {
        return $this->belongsTo(TransactionHeader::class, 'txn_header_id');
    }

    /**
     * Optional helper to get Account via header
     */
    public function account()
    {
        return $this->header->account();
    }

    /**
     * Optional helper to get Person via header
     */
    public function person()
    {
        return $this->header->person();
    }
}
