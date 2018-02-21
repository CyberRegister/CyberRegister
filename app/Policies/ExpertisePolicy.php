<?php

namespace App\Policies;

use App\User;
use App\Expertise;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExpertisePolicy
{
    use HandlesAuthorization;

    /**
     * Controllers may do stuff . .
     *
     * @param User $user
     * @param $ability
     * @return null|bool
     */
    public function before(User $user, $ability)
    {
        if ($user->is_controller) {
            return true;
        }
    }

    /**
     * Determine whether the user can list Expertise(s).
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can see a Expertise.
     *
     * @param  \App\User  $user
     * @param  Expertise $expertise
     * @return mixed
     */
    public function show(User $user, Expertise $expertise)
    {
        return $user->id === $expertise->user_id;
    }

    /**
     * Determine whether the user can create Expertise.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the Expertise.
     *
     * @param  \App\User  $user
     * @param  \App\Expertise  $expertise
     * @return mixed
     */
    public function update(User $user, Expertise $expertise)
    {
        return false;
    }

    /**
     * Determine whether the user can edit the Expertise.
     *
     * @param  \App\User  $user
     * @param  \App\Expertise  $expertise
     * @return mixed
     */
    public function edit(User $user, Expertise $expertise)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the Expertise.
     *
     * @param  \App\User  $user
     * @param  \App\Expertise  $expertise
     * @return mixed
     */
    public function delete(User $user, Expertise $expertise)
    {
        return false;
    }
}
