<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

function settings($key = null)
{
    $settings = Cache::rememberForever('all_settings', function () {
        return Setting::pluck('value', 'key'); // Fetch key-value pairs
    });

    if (is_null($key)) {
        return $settings; // Return all settings
    }

    if (is_array($key)) {
        return collect($key)->mapWithKeys(fn($k) => [$k => $settings[$k] ?? '']);
    }

    return $settings[$key] ?? '';
}
