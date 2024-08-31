<?php

namespace Modules\Site\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Modules\Site\Entities\User;
use Modules\Site\Http\Traits\UserTrait;
use Spatie\Permission\Models\Role;

class UserPolicy
{
    use HandlesAuthorization;
    use UserTrait;

    /**
     * Determine whether the user can view any models.
     *
     * @param  Modules\Site\Entities\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function index(User $user, Role $role)
    {
        if ($this->getCurrentUserRoleLevel() > $role->level) {
            return false;
        }
        return true;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  Modules\Site\Entities\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  Modules\Site\Entities\User  $user
     * @param  Modules\Site\Entities\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\System\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return Response::deny('You do not own this post.');
    }

    /**
     * Determine whether the user can view update form.
     *
     * @param  Modules\Site\Entities\User  $user
     * @param  Modules\Site\Entities\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function edit(User $user, User $model)
    {
        $currentRoleLevel = $this->getCurrentUserRoleLevel();

        if ($user->hasRole('SuperAdmin')) {
        // if ($currentRoleLevel <= $givenRoleLevel) {
            // if current user login role level is small than given model user role level
            return true;
        }
        else {
            return $user->id === $model->id
                ? Response::allow()
                : Response::deny('You are not authorized to edit this user.');
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  Modules\Site\Entities\User  $user
     * @param  Modules\Site\Entities\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  Modules\Site\Entities\User  $user
     * @param  Modules\Site\Entities\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  Modules\Site\Entities\User  $user
     * @param  Modules\Site\Entities\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  Modules\Site\Entities\User  $user
     * @param  Modules\Site\Entities\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }
}
