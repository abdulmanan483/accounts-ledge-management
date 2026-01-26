<?php

namespace App\Observers;

use App\Traits\HasBaseObserver;
use Illuminate\Support\Facades\Cache;

class BaseObserver
{
    use HasBaseObserver;
//     /**
//      * Invalidate cache by incrementing version key
//      */
//     protected function clearCache($model)
//     {
//         $modelName = class_basename($model);
//         $versionKey = "{$modelName}.cache_version";
//         $version = Cache::get($versionKey, 1);
//         Cache::put($versionKey, $version + 1, 60*24); // 1 day
//     }

//     public function created($model) { $this->clearCache($model); }
//     public function updated($model) { $this->clearCache($model); }
//     public function deleted($model) { $this->clearCache($model); }
//     public function restored($model) { $this->clearCache($model); }
//     public function forceDeleted($model) { $this->clearCache($model); }
}
