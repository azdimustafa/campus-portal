<?php
namespace Modules\Site\Entities;

use DateTimeInterface;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Fleet\Entities\User as FleetUser;

use function App\Helpers\camelCase;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'sys_users';

    public const CREATED_BY_GOOGLE = 'google';
    public const CREATED_BY_CAS = 'cas';
    public const CREATED_BY_LOCAL = 'local';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','staff_no', 'phone_no', 'faculty_id', 'department_id', 'created_account_by', 'user_type_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $dates = ['created_at', 'updated_at'];

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
            // $query->created_by = auth()->user()->id;
            // $query->updated_by = auth()->user()->id;
        });
        
        static::updating(function ($query) {
            // $query->updated_by = auth()->user()->id;
        });
    }


    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d-M-Y h:i A');
    }

    public function ptj() {
        return $this->belongsTo('Modules\Site\Entities\Ptj');
    }

    public function department() {
        return $this->belongsTo('Modules\Site\Entities\Department');
    }

    /**
     * Get the user associated with the Profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    ## FLEET 
    // public function fleetAdmins() {
    //     return $this->hasMany(FleetUser::class, 'user_id')->where('role_id', config('constants.role_id.fleetDeptAdmin'));
    // }
}
