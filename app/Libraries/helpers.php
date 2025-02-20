<?php


use App\Models\Setting;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;
use Illuminate\Support\Facades\Cache;

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
            Image::load($finalPath)->fit(Manipulations::FIT_CROP, $width, $height)->save(public_path($finalPath));
        }
    }
    return $finalPath;
}

/**
 * Get listing of a resource.
 *
 * @return \Illuminate\Http\Response
 */
function settings($key, $default = null)
{
    return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
        return Setting::get($key) ? Setting::get($key) : $default;
    });
}