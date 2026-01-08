<?php

namespace App\Traits;

use App\Helpers\CacheManager;
use Illuminate\Database\Eloquent\Model;

trait HasBaseObserver
{
    /**
     * Clear caches for a model via CacheManager on CRUD events
     * @param Model $model
     * @param string|null $task Optionally specify a task to clear (getter, findBy, search)
     * @param array $params Optionally specify params to clear specific cache
     */
    protected function clearCache(Model $model, string $task = null, array $params = []): void
    {
        // Skip if caching disabled
        if (!$model::isCacheEnabled()) return;

        $cacheManager = new CacheManager($model);

        // Clear caches
        $cacheManager->clear($task, $params);
    }

    // ------------------------------
    // CRUD Event Hooks
    // ------------------------------
    public function created(Model $model): void
    {
        // Clear all caches for the model on create
        $this->clearCache($model);
    }

    public function updated(Model $model): void
    {
        // Clear all caches for the model on update
        $this->clearCache($model);
    }

    public function deleted(Model $model): void
    {
        // Clear all caches for the model on delete
        $this->clearCache($model);
    }

    public function restored(Model $model): void
    {
        // Clear all caches for the model on restore
        $this->clearCache($model);
    }

    public function forceDeleted(Model $model): void
    {
        // Clear all caches for the model on force delete
        $this->clearCache($model);
    }
}
