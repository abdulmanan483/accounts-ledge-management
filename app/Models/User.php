<?php

namespace App\Models;

use App\Enums\Statuses\Active;
use App\Enums\Users\UserApprovalStatus;
use App\Traits\Uploadable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 *
 * @property $id
 * @property $name
 * @property $email
 * @property $image
 * @property $email_verified_at
 * @property $password
 * @property $user_type
 * @property $remember_token
 * @property $is_active
 * @property $created_at
 * @property $updated_at
 * @property $created_by
 * @property $updated_by
 * @property $deleted_by
 * @property $deleted_at
 * @property $registration_date
 * @property $gender
 * @property $profile_picture
 * @property $external_profile_pic
 * @property $cnic
 * @property $mobile_no
 * @property $cnic_front
 * @property $external_cnic_front
 * @property $cnic_back
 * @property $external_cnic_back
 * @property $current_city
 * @property $current_city_id
 * @property $current_address
 * @property $permanent_country_id
 * @property $permanent_city_id
 * @property $permanent_address
 * @property $current_country
 * @property $current_country_id
 * @property $educational_qualifications
 * @property $skills
 * @property $data_source
 * @property $form_no
 * @property $is_pakistani
 * @property $is_approved
 * @property $is_added
 * @property $status
 * @property $comments
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class User extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes, Uploadable;
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'image', 'user_type', 'is_active', 'created_by', 'updated_by', 'deleted_by', 'registration_date', 'gender', 'profile_picture', 'external_profile_pic', 'cnic', 'mobile_no', 'cnic_front', 'external_cnic_front', 'cnic_back', 'external_cnic_back', 'current_city', 'current_city_id', 'current_address', 'permanent_country_id', 'permanent_city_id', 'permanent_address', 'current_country', 'current_country_id', 'educational_qualifications', 'skills', 'data_source', 'form_no', 'is_pakistani', 'is_approved', 'is_added', 'status', 'comments'];
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
        'is_active'              => Active::class,
        'registration_date'      => 'datetime',
        'gender'                 => 'integer',
        'user_type'              => 'integer',
        'status'                 => UserApprovalStatus::class,
        'is_pakistani'           => 'boolean',
        'is_approved'            => 'boolean',
        'is_added'               => 'boolean',
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
     * Handle image upload.
     */
    public function setImageAttribute($image)
    {
        if ($image) {
            $this->attributes['image'] = uploadFile($image, 'profile', '100', '100');
        } else {
            $this->attributes['image'] = null;
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

    /**
     * Relationships with media files.
     */
    public function media()
    {
        return $this->morphMany(\App\Models\Media::class, 'mediable');
    }

}
