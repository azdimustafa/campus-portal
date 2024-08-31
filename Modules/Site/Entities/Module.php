<?php

namespace Modules\Site\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use SoftDeletes;
    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
    protected $connection = 'mysql';
    protected $table = 'sys_modules';
    protected $fillable = ['parent_id', 'code', 'name', 'description', 'booking_available_for', 'active'];

    const FLEET = 'FLEET';
    const SPACE = 'SPACE';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
        'booking_available_for' => 'json',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    // protected static function boot()
    // {
    //     parent::boot();

    //     // auto-sets values on creation
    //     static::creating(function ($query) {
    //         $query->created_by = auth()->user()->id;
    //         $query->updated_by = auth()->user()->id;
    //     });

    //     static::updating(function ($query) {
    //         $query->updated_by = auth()->user()->id;
    //     });
    // }

    /**
     * Set the module's code to uppercase value.
     *
     * @param  string  $value
     * @return void
     */
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }

    /**
     * Get all of the owners for the Module
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function owners(): HasMany
    {
        return $this->hasMany(ModuleOwner::class);
    }

    /**
     * Get the module booking available for base on user type give
     *
     * @return \Staudenmeir\EloquentJsonRelations\HasJsonRelationships\belongsToJson
     */
    public function bookingAvailableFor() {
        return $this->belongsToJson(UserType::class, 'booking_available_for');
    }

}
