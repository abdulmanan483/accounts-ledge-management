<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobBatch extends Model
{
    use HasFactory;

    // Disable the automatic handling of timestamps since we're using custom created_at and finished_at
    public $timestamps = false;

    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'id',
        'name',
        'total_jobs',
        'pending_jobs',
        'failed_jobs',
        'failed_job_ids',
        'options',
        'cancelled_at',
        'created_at',
        'finished_at'
    ];

    // Cast the integer timestamps to datetime for easier handling
    protected $casts = [
        'created_at' => 'datetime',
        'finished_at' => 'datetime',
        'cancelled_at' => 'datetime'
    ];
}
