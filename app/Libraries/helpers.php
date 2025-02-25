<?php


use App\Models\Setting;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;
use Illuminate\Support\Facades\Cache;
use Spatie\Image\Enums\Fit;

/**
 * Get listing of a resource.
 */
function uploadFile($file, $path, $width = null, $height = null)
{
    $extension = $file->getClientOriginalExtension();
    $name = uniqid().".".$extension;

    $folder = 'upload/'.$path;
    $finalPath = $folder.'/'.$name;
    $file->move($folder, $name);

    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'];
    if (in_array(strtolower($extension), $imageExtensions)) {
        if ($width && $height) {
            Image::load($finalPath)->fit(Fit::Contain , $width, $height)->save(public_path($finalPath));
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
// }

function settings($key = null, $default = null, $cacheDuration = 3600)
{
    // Cache all settings for the specified duration (default: 1 hour)
    $settings = Cache::remember('all_settings', $cacheDuration, function () {
        return Setting::pluck('value', 'key')->toArray();
    });

    // If no key is provided, return all settings
    if (is_null($key)) {
        return $settings;
    }

    // If an array of keys is provided, return multiple settings
    if (is_array($key)) {
        return collect($key)->mapWithKeys(function ($k) use ($settings, $default) {
            return [$k => $settings[$k] ?? $default];
        })->toArray();
    }

    // Return a single setting value or default if not found
    return $settings[$key] ?? $default;
}
