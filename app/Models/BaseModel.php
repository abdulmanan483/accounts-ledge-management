<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use OwenIt\Auditing\Contracts\Auditable;

class BaseModel extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $perPage = 20;
    // Check if soft deletes should be enabled
    protected static bool $supports_soft_deletes = true;

    protected static function boot()
    {
        parent::boot();

        $model = new static;

        // Ensure auditing is enabled/disabled based on model
        if (method_exists($model, 'isAuditable') && ! $model->isAuditable()) {
            $model->disableAuditing();
        }
        static::$supports_soft_deletes = method_exists($model, 'bootSoftDeletes');

        if (static::$supports_soft_deletes) {
            static::deleting(function ($model) {
                if (
                    auth()->check() &&
                    Schema::hasColumn($model->getTable(), 'deleted_by')
                ) {
                    $model->deleted_by = auth()->id();
                    $model->save();
                }
            });
            static::restoring(function ($model) {
                if (auth()->check() && Schema::hasColumn($model->getTable(), 'updated_by')) {
                    $model->deleted_by = null;
                }
            });
        }

        // Automatically set created_by & updated_by
        static::creating(function ($model) {
            if (auth()->check() && Schema::hasColumn($model->getTable(), 'created_by')) {
                $model->created_by = auth()->id();
            }
        });

        static::updating(function ($model) {
            if (auth()->check() && Schema::hasColumn($model->getTable(), 'updated_by')) {
                $model->updated_by = auth()->id();
            }
        });
    }

    /**
     * Check if auditing is enabled for this model.
     */
    public function isAuditable(): bool
    {
        return property_exists($this, 'enable_audit') ? $this->enable_audit : true;
    }
    // /**
    //  * Override the `transformAudit` method to prevent logging if auditing is disabled.
    //  */
    // public function transformAudit(array $data): array
    // {
    //     return $this->isAuditable() ? $data :  [];
    // }
}
