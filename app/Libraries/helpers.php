<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Spatie\Image\Enums\Fit;
use Spatie\Image\Image;

/**
 * Get listing of a resource.
 */
function uploadFile($file, $path, $width = null, $height = null)
{
    $extension = $file->getClientOriginalExtension();
    $name      = uniqid() . "." . $extension;

    $folder    = 'upload/' . $path;
    $finalPath = $folder . '/' . $name;
    $file->move($folder, $name);

    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'];
    if (in_array(strtolower($extension), $imageExtensions)) {
        if ($width && $height) {
            Image::load($finalPath)->fit(Fit::Contain, $width, $height)->save(public_path($finalPath));
        }
    }
    return $finalPath;
}

/**
 * Get listing of a resource.
 *
 * @return \Illuminate\Http\Response
 */
// function settings($key, $default = null)
// {
//     return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
//         return Setting::get($key) ? Setting::get($key) : $default;
//     });
// }
// function settings($key, $default = null)
// {
//     // Cache all settings at once for 1 hour
//     $settings = Cache::remember('all_settings', 3600, function () {
//         return Setting::pluck('value', 'key')->toArray();
//     });

//     // Retrieve from cached settings
//     return $settings[$key] ?? $default;
// // }

// function geAllSettings($columns = ['key', 'value'])
// {
//     // If 'all' is passed or an empty array, fetch all columns
//     $selectColumns = empty($columns) || in_array('all', (array) $columns) ? ['*'] : (array) $columns;


//     // Cache settings indefinitely until manually cleared
//     return Cache::rememberForever('all_settings_' . implode('_', $selectColumns), function () use ($selectColumns) {
//         return Setting::select($selectColumns)->get()->keyBy('key');
//     });
// }

// function settings($key, $default = null, $columns = ['key', 'value'], $returnObject = false)
// {
//     $settings = geAllSettings($columns);

//     if (is_array($key)) {
//         return collect($key)->mapWithKeys(function ($k) use ($settings, $default, $returnObject) {
//             return [$k => isset($settings[$k]) ? ($returnObject ? $settings[$k] : $settings[$k]->value) : $default];
//         });
//     }

//     return isset($settings[$key])
//         ? ($returnObject ? $settings[$key] : $settings[$key]->value)
//         : $default;
// }

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
