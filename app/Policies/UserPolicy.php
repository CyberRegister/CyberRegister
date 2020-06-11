<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Controllers may do stuff . .
     *
     * @param User $user
     *
     * @return null|bool
     */
    public function before(User $user)
    {
        if ($user->is_controller) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can edit the model.
     *
     * @param User $user
     * @param User $model
     *
     * @return bool
     */
    public function edit(User $user, User $model)
    {
        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param User $model
     *
     * @return bool
     */
    public function update(User $user, User $model)
    {
        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param User $model
     *
     * @return bool
     */
    public function delete(User $user, User $model)
    {
        return $user->id === $model->id;
    }
}
