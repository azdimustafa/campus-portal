<?php

namespace Modules\Site\Entities;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $connection = 'mysql';
    protected $table = 'sys_profiles';
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    protected $fillable = [
        'user_id', 
        'ptj_id', 
        'department_id', 
        'salary_no', 
        'ic',
        'office_no', 
        'hp_no', 
        'status', 
        'grade', 
        'grade_desc',
        'position'
    ];

    public function getGradeDescAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    ## RELATIONSHIP
    
    /**
     * Get the user that owns the Profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the faculty that owns the Profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ptj()
    {
        return $this->belongsTo(Ptj::class);
    }

    /**
     * Get the department that owns the Profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
