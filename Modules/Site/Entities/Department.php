<?php

namespace Modules\Site\Entities;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

use function App\Helpers\camelCase;

class Department extends Model
{
    use SoftDeletes;
    use Uuid;

    protected $connection = 'mysql';
    protected $table = 'sys_org_departments';
    public $incrementing = false;

    protected $fillable = [
        'id', 
        'ptj_id',
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
     * Scope a query to return departments.
     *
     * @param  String $search
     * @param  Integer $limit
     * @param  Boolean $trash
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getDepartments($search = null, $limit = 10, $trash = false) {
        $query = $this->where(function ($query) use ($search) {
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
     * Scope a query to only include active departments.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

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
     * Relationship to faculty
     */
    public function ptj() {
        return $this->belongsTo(Ptj::class);
    }

    /**
     * Get all of the divisions for the Department
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function divisions()
    {
        return $this->hasMany(Division::class)->oldest();
    }
}
