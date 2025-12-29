<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait HasBaseObserver
{
    protected function clearCache($model): void
    {
        $modelName  = class_basename($model);
        $versionKey = "{$modelName}.cache_version";

        $version = Cache::get($versionKey, 1);
        Cache::put($versionKey, $version + 1, 60 * 24);
    }

    public function created($model): void
    {
        $this->clearCache($model);
    }

    public function updated($model): void
    {
        $this->clearCache($model);
    }

    public function deleted($model): void
    {
        $this->clearCache($model);
    }

    public function restored($model): void
    {
        $this->clearCache($model);
    }

    public function forceDeleted($model): void
    {
        $this->clearCache($model);
    }
}
