<?php

namespace Modules\Site\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class RefDay extends Model
{
    protected $connection = 'mysql';
    protected $table = 'sys_ref_days';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * Set the faculty's name ucfirst
     *
     * @param  string  $value
     * @return void
     */
    public function getNameAttribute($value) {
        if (App::isLocale('en')) {
            $name = $value;            
        }
        else if (App::isLocale('ms-my')) {
            $name = $this->name_my;
        }

        return $name;
    }
}
