<?php

namespace Modules\Site\Entities;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role;

class UserContext extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'sys_user_contexts';
    public $fillable = ['role_id', 'user_id', 'level', 'model_type', 'model_id'];

    /**
 * Get the user that owns the UserAssignment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the role that owns the UserAssignment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function model() {
        return $this->morphTo();
    }
}
