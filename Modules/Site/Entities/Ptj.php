<?php

namespace Modules\Site\Entities;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

use function App\Helpers\camelCase;

class Ptj extends Model
{
    use Uuid;
    protected $connection = 'mysql';
    protected $table = 'sys_org_ptjs';
    use SoftDeletes;
    public $incrementing = false;

    protected $fillable = [
        'code', 
        'short_name', 
        'name', 
        'name_my', 
        'email', 
        'active',
        'is_academic',
    ];

    public $casts = [
        'active' => 'boolean',
        'is_academic' => 'boolean',
    ];

    /**
     * Get the name by translator
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

    /**
     * Set the faculty's name ucfirst
     *
     * @param  string  $value
     * @return void
     */
    public function getNameMalayAttribute($value) {
        return $value;
    }

    /**
     * Scope a query to return faculties.
     *
     * @param  String $search
     * @param  Integer $limit
     * @param  Boolean $trash
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getFaculties($search = null, $limit = 10, $trash = false) {
        $query = $this->with('departments')->where(function ($query) use ($search) {
            if ($search != null) {
                $query->orWhere('name', 'like', '%' . $search . '%');
            }
        });
        if ($trash == false)
            $results = $query->orderBy('name', 'asc')->paginate($limit);
        else 
            $results = $query->onlyTrashed()->orderBy('name', 'asc')->paginate($limit);
        return $results;
    }

    /**
     * Scope a query to only include active faculties.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    /**
     * Get the departments for the faculty
     */
    public function departments() {
        return $this->hasMany(Department::class)->active()->orderBy('name');
    }
}
