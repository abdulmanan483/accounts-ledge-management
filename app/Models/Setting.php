<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Setting extends Model
{
    use HasFactory;

    static $rules = [
        'key' 		=> 'required',
        'value' 	=> 'required',
    ];

    protected $fillable = ['key', 'value'];

    public static function get($key) {
        return self::where('key', $key)->pluck('value')->first();
    }

    public static function set($data) {
        return self::upsert($data, ['key'], ['value']);
    }

    public function getValueAttribute($value)
    {
        if ($this->isFile($value)) {
            return asset($value);
        }

        return $value;
    }

    // Helper method to check if value is a file
    protected function isFile($value)
    {
        $fileExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx'];

        foreach ($fileExtensions as $extension) {
            if (Str::endsWith($value, '.' . $extension)) {
                \Log::info("File detected: $value");
                return true;
            }
        }
        \Log::info("Not a file: $value");
        return false;
    }
}
