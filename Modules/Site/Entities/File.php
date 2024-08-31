<?php

namespace Modules\Site\Entities;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Model;

use function App\Helpers\formatBytes;

class File extends Model
{
    protected $connection = 'mysql';
    protected $table = 'sys_files';
    use Uuid;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    // define constants
    public const FLEET_VEHICLE_IMAGE = 'fleet_vehicle_image';

    public $fillable = [
        'context', 
        'ori_file_name', 
        'file_name', 
        'mime_type', 
        'file_size', 
        'path',
    ];

    public function getFileSizeAttribute($value)
    {
        return formatBytes($value, 0);
    }
}
