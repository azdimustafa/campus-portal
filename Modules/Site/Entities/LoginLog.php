<?php

namespace Modules\Site\Entities;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $connection = 'mysql';
    protected $table = 'sys_login_logs';

    public const LOGIN_SUCCESS = 'success';
    public const LOGIN_FAILED = 'failed';

    protected $fillable = [
        'email',
        'ip_address',
        'device',
        'platform',
        'user_agent',
        'status',
        'message',
        'type',
    ];
}
