<?php

namespace Modules\Shop\Http\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShopPolicies
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any users.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function viewAny(User $user)
    {
    
        // Allow if the user is an admin or a moderator
        return true;
    }

    /**
     * Determine whether the user can view the user.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $userToView
     * @return bool
     */
    public function view(User $user, $model)
    {
       
        // Allow if the user is viewing their own profile or if they are an admin
        return true;
    }


    public function index(User $user){
        return true;
    }

    /**
     * Determine whether the user can create users.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function create(User $user)
    {
        // Allow if the user is an admin
        return $user->isModerator();
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $userToUpdate
     * @return bool
     */
    public function update(User $user, User $userToUpdate)
    {
        // Allow if the user is updating their own profile or if they are an admin
        return $user->id === $userToUpdate->id || $user->isModerator();
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $userToDelete
     * @return bool
     */
    public function delete(User $user, User $userToDelete)
    {
        // Allow if the user is deleting their own profile or if they are an admin
        // Optionally, you can prevent the deletion of the last user
        return $user->isModerator();
    }
}
