<?php

namespace App\Models;

use App\Traits\HasBaseModel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\Hash;
use App\Enums\Statuses\Active;
use App\Enums\Users\UserApprovalStatus;
use App\Traits\Uploadable;

class User extends Authenticatable implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes, Uploadable;
    use HasBaseModel;

    /**
     * Default number of items per page.
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'profile_picture',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * Hidden attributes.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casting.
     */
    protected $casts = [
        'email_verified_at'      => 'datetime',
        'is_active'              => Active::class
    ];

    /**
     * Hash password automatically.
     */
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    /**
     * Return full image URL.
     */
    public function getImageAttribute($image)
    {
        return $image ? asset($image) : null;
    }

    /**
     * Sanitize email before saving.
     */
    public function setEmailAttribute($email)
    {
        $email = trim($email);
        $this->attributes['email'] = $email === '' ? null : $email;
    }

    /**
     * Scope for active users.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
