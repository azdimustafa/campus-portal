<?php

namespace Modules\Site\Entities;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

use function App\Helpers\camelCase;

class Section extends Model
{
    protected $connection = 'mysql';
    protected $table = 'sys_org_sections';
    use Uuid;
    use SoftDeletes;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    public $fillable = ['ptj_id', 'department_id', 'division_id', 'code', 'short_name', 'name_my', 'name', 'active'];

    public $casts = [
        'active' => 'boolean',
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
     * Relationship to faculty
     */
    public function ptj() {
        return $this->belongsTo(Ptj::class);
    }

    /**
     * Relationship to department
     */
    public function department() {
        return $this->belongsTo(Department::class);
    }

    /**
     * Relationship to division
     */
    public function division() {
        return $this->belongsTo(Division::class);
    }

    /**
     * Get all of the units for the Section
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function units(): HasMany
    {
        return $this->hasMany(Unit::class)->oldest();
    }
}
