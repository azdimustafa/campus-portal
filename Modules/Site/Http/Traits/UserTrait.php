<?php
namespace Modules\Site\Http\Traits;

use Modules\Site\Entities\User;
use Modules\Site\Entities\UserContext;
use Spatie\Permission\Models\Role;

trait UserTrait
{
    public function revokeRole($roleId, $roleName, $user) {

        ## find record in user context
        $totalUserContext = UserContext::where(['role_id' => $roleId, 'user_id' => $user->id])->count('id');

        ## this user does not have any role admin in user context, then revoke the role admin
        if ($totalUserContext == 0) {
            $user->removeRole($roleName);
        }
    }
    
    /**
     * Return current user login role level
     * 
     * @return int $level
     */
    public function getCurrentUserRoleLevel() {
        $user = auth()->user();
        $userRoles = $user->getRoleNames();
        $role = Role::findByName($userRoles[0]);
        return $role->level;
    }

    /**
     * Return given user role level
     * 
     * @return int $level
     */
    public function getUserRoleLevel(User $user) {
        $userRoles = $user->getRoleNames();
        $role = Role::findByName($userRoles[0]);
        return $role->level;
    }
}