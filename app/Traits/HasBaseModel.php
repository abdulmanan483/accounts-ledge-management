<?php

namespace App\Traits;

use App\Observers\BaseObserver;
use Illuminate\Support\Facades\Schema;
use Spatie\Activitylog\LogOptions;

trait HasBaseModel
{
    protected static bool $supports_soft_deletes = true;
    protected static array $columnCache = [];
    protected static ?bool $cacheEnabled = null;
    /**
     * Check if cache is enabled for this model
     */
    public static function isCacheEnabled(): bool
    {
        // If the trait property is set, use it
        if (static::$cacheEnabled !== null) {
            return static::$cacheEnabled;
        }

        // fallback to global config
        return config('config.cache_enabled', false);
    }

    protected static function bootHasBaseModel()
    {
        $model = new static;
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
                    static::hasColumnCached($model->getTable(), 'deleted_by')
                ) {
                    $model->updated_by = auth()->id();
                    $model->deleted_by = auth()->id();
                    $model->saveQuietly();
                }
            });

            static::restoring(function ($model) {
                if (
                    auth()->check() &&
                    static::hasColumnCached($model->getTable(), 'deleted_by')
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
                static::hasColumnCached($model->getTable(), 'created_by')
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
                static::hasColumnCached($model->getTable(), 'updated_by')
            ) {
                $model->updated_by = auth()->id();
            }
        });
    }
    public function getActivitylogOptions(): LogOptions
    {
        $a = LogOptions::defaults()
            // Use model class name as log name (User, Post, Order, etc.)
            ->useLogName(class_basename($this))

            // Log all fillable attributes
            ->logFillable()
//
//            // Log only changed attributes
            ->logOnlyDirty()

            // Prevent empty logs
            ->dontSubmitEmptyLogs()

            // Custom description per event
//            ->setDescriptionForEvent(function (string $eventName) {
//                return sprintf(
//                    '%s %s',
//                    class_basename($this),
//                    $eventName
//                );
//            });
            ->setDescriptionForEvent(function (string $eventName) {
                if ($eventName === 'deleted' && method_exists($this, 'isForceDeleting') && $this->isForceDeleting()) {
                    return class_basename($this) . ' force deleted';
                }

                return class_basename($this) . ' ' . $eventName;
            });
        return $a;
    }
    protected static function hasColumnCached($table, $column): bool
    {
        return static::$columnCache[$table][$column]
            ??= Schema::hasColumn($table, $column);
    }
}
