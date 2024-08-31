<?php
namespace Modules\Site\Entities;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $connection = 'mysql';
    protected $table = 'sys_roles';
    // You might set a public property like guard_name or connection, or override other Eloquent Model methods/properties
    const SUPERADMIN = 1;
    const NORMALUSER = 999;
}