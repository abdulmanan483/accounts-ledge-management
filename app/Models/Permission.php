<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Permission
 *
 * @property $id
 * @property $name
 * @property $guard_name
 * @property $display_name
 * @property $group
 * @property $display_group
 * @property $type
 * @property $display_type
 * @property $created_at
 * @property $updated_at
 *
 * @property ModelHasPermission[] $modelHasPermissions
 * @property RoleHasPermission[] $roleHasPermissions
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Permission extends Model implements Auditable
{
    
    use \OwenIt\Auditing\Auditable;
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'guard_name', 'display_name', 'group', 'display_group', 'type', 'display_type'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function modelHasPermissions()
    {
        return $this->hasMany(\App\Models\ModelHasPermission::class, 'id', 'permission_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roleHasPermissions()
    {
        return $this->hasMany(\App\Models\RoleHasPermission::class, 'id', 'permission_id');
    }
    
}
