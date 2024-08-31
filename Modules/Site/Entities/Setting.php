<?php

namespace Modules\Site\Entities;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $connection = 'mysql';
    protected $table = 'sys_settings';

    public $fillable = ['key', 'value'];
}
