<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key', 'name', 'description', 'tab', 'section', 'type', 'value',
    ];

    // Validation rules
    static $rules = [
        'key'   => 'required|unique:settings,key',
        'name'  => 'required',
        'type'  => 'required|in:text,image,file,rich_text,number,dropdown',
        'value' => 'nullable',
    ];

    // Retrieve setting value with proper formatting
    public function getValueAttribute($value)
    {
        if ($this->type === 'image' || $this->type === 'file') {
            return asset($value);
        }
        if ($this->type === 'number') {
            return (float) $value;
        }
        return $value;
    }

    // Get setting by key
    public static function getSetting($key)
    {
        return self::where('key', $key)->pluck('value')->first();
    }

    // Set or update setting
    public static function setSetting($data)
    {
        self::upsert($data, ['key'], ['value']);
        Artisan::call('optimize:clear');
        return true;

    }

}
