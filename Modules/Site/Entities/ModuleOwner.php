<?php

namespace Modules\Site\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModuleOwner extends Model
{
    protected $connection = 'mysql';
    protected $table = 'sys_module_owners';
    // use SoftDeletes;
    
    protected $fillable = ['module_id', 'user_id', 'active', 'created_by', 'updated_by'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // auto-sets values on creation
        static::creating(function ($query) {
            $query->created_by = auth()->user()->id;
            $query->updated_by = auth()->user()->id;
        });

        static::updating(function ($query) {
            $query->updated_by = auth()->user()->id;
        });
    }

    /**
     * Get the modulee that owns the ModuleOwner
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Get the user that owns the ModuleOwner
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}