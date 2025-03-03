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
