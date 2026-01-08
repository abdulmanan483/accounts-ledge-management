<?php

namespace App\Models;

use App\Traits\Uploadable;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasBaseModel;
use Spatie\Activitylog\Traits\LogsActivity;

abstract class BaseModel extends Model
{
    use HasBaseModel;
    use Uploadable;
    use LogsActivity;
    /**
     * Per-model cache enable/disable.
     * null = use global config
     */
    protected static ?bool $cacheEnabled = null;
    protected static function booted()
    {
        static::observe(\App\Observers\BaseObserver::class);
    }

    /**
     * Check if cache is enabled for this model
     */
    public static function isCacheEnabled(): bool
    {
        if (static::$cacheEnabled !== null) {
            return static::$cacheEnabled;
        }

        return config('config.cache_enabled', false);
    }
}
