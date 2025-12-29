<?php

namespace App\Traits;

use Illuminate\Support\Facades\Schema;

trait HasBaseModel
{
    protected static bool $supports_soft_deletes = true;

    protected static function bootHasBaseModel()
    {
        $model = new static;

        /**
         * Enable / Disable Auditing
         */
        if (method_exists($model, 'isAuditable') && ! $model->isAuditable()) {
            $model->disableAuditing();
        }

        /**
         * Detect soft deletes support
         */
        static::$supports_soft_deletes = method_exists($model, 'bootSoftDeletes');

        /**
         * deleted_by handling
         */
        if (static::$supports_soft_deletes) {
            static::deleting(function ($model) {
                if (
                    auth()->check() &&
                    Schema::hasColumn($model->getTable(), 'deleted_by')
                ) {
                    $model->deleted_by = auth()->id();
                    $model->saveQuietly();
                }
            });

            static::restoring(function ($model) {
                if (
                    auth()->check() &&
                    Schema::hasColumn($model->getTable(), 'deleted_by')
                ) {
                    $model->deleted_by = null;
                }
            });
        }

        /**
         * created_by
         */
        static::creating(function ($model) {
            if (
                auth()->check() &&
                Schema::hasColumn($model->getTable(), 'created_by')
            ) {
                $model->created_by = auth()->id();
            }
        });

        /**
         * updated_by
         */
        static::updating(function ($model) {
            if (
                auth()->check() &&
                Schema::hasColumn($model->getTable(), 'updated_by')
            ) {
                $model->updated_by = auth()->id();
            }
        });
    }

    /**
     * Check if auditing is enabled
     */
    public function isAuditable(): bool
    {
        return property_exists($this, 'enable_audit')
            ? $this->enable_audit
            : true;
    }
}
