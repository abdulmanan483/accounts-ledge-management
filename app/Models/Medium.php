<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Medium
 *
 * @property $id
 * @property $file_name
 * @property $file_path
 * @property $mime_type
 * @property $file_size
 * @property $type
 * @property $mediable_type
 * @property $mediable_id
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 * @property $created_by
 * @property $updated_by
 * @property $deleted_by
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Medium extends Model implements Auditable
{
    use SoftDeletes;

    use \OwenIt\Auditing\Auditable;
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['file_name', 'file_path', 'mime_type', 'file_size', 'type', 'mediable_type', 'mediable_id', 'created_by', 'updated_by', 'deleted_by'];


}
