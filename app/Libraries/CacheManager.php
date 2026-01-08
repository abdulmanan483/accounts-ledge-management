<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class CacheManager
{
    protected string $modelName;
    protected int $cacheTime;

    public function __construct(Model $model, int $cacheTime = 60)
    {
        $this->modelName = class_basename($model);
        $this->cacheTime = $cacheTime;
    }

    /**
     * Generate human-readable cache key
     * Format: Model.task.param1=value1.param2=value2
     */
    public function key(string $task, array $params = []): string
    {
        if (empty($params)) return "{$this->modelName}.{$task}";
        $parts = [];
        foreach ($params as $k => $v) {
            if (is_array($v)) $v = implode('-', $v);
            $parts[] = "{$k}={$v}";
        }
        return "{$this->modelName}.{$task}." . implode('.', $parts);
    }

    /**
     * Store in cache and log creation/update
     */
    public function put(string $task, $value, array $params = []): void
    {
        $key = $this->key($task, $params);
        Cache::put($key, $value, $this->cacheTime * 60);
        $this->trackKey($key);

        Log::info("[CACHE CREATED/UPDATED] Key: {$key}");
    }

    /**
     * Retrieve or store in cache
     */
    public function remember(string $task, callable $callback, array $params = [])
    {
        $key = $this->key($task, $params);

        $value = Cache::remember($key, $this->cacheTime * 60, $callback);
        $this->trackKey($key);

        Log::info("[CACHE REMEMBERED] Key: {$key}");
        return $value;
    }

    /**
     * Clear cache
     * - If $task = null → clear all model caches
     * - If $params provided → clear only that key
     * - Otherwise → clear all keys under that task
     */
    public function clear(string $task = null, array $params = []): void
    {
        if ($task) {
            if (!empty($params)) {
                // Clear single key
                $key = $this->key($task, $params);
                Cache::forget($key);
                $this->untrackKey($key);
                Log::info("[CACHE DELETED] Key: {$key}");
            } else {
                // Clear all keys under task
                $pattern = "{$this->modelName}.{$task}";
                $this->forgetByPrefix($pattern);
            }
        } else {
            // Clear all keys under model
            $pattern = "{$this->modelName}.";
            $this->forgetByPrefix($pattern);
        }
    }

    /**
     * Track a key in the registry
     */
    protected function trackKey(string $key): void
    {
        $registryKey = "{$this->modelName}.cache_registry";
        $registry = Cache::get($registryKey, []);
        $registry[$key] = true;
        Cache::put($registryKey, $registry, $this->cacheTime * 60);
    }

    /**
     * Remove a key from the registry
     */
    protected function untrackKey(string $key): void
    {
        $registryKey = "{$this->modelName}.cache_registry";
        $registry = Cache::get($registryKey, []);
        if (isset($registry[$key])) unset($registry[$key]);
        Cache::put($registryKey, $registry, $this->cacheTime * 60);
    }

    /**
     * Forget all keys matching a prefix using the registry
     * Compatible with file cache
     */
    protected function forgetByPrefix(string $prefix): void
    {
        $registryKey = "{$this->modelName}.cache_registry";
        $registry = Cache::get($registryKey, []);

        foreach ($registry as $key => $_) {
            if (str_starts_with($key, $prefix)) {
                Cache::forget($key);
                unset($registry[$key]);
                Log::info("[CACHE DELETED] Registry: {$prefix} Key: {$key}");
            }
        }

        Cache::put($registryKey, $registry, $this->cacheTime * 60);
    }
}
