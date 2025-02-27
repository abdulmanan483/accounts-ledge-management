<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

class Setting extends BaseModel
{
    use HasFactory;

    protected bool $enable_audit = false; // Disable audits for this model

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

    // Set or update setting
    public static function setSetting($data)
    {
        // self::upsert($data, ['key'], ['value']);
        foreach ($data as $setting) {
            self::updateOrCreate(
                ['key' => $setting['key']], // Unique identifier
                ['value' => $setting['value']] // Update field
            );
        }
        Artisan::call('optimize:clear');
        return true;
    }

}
