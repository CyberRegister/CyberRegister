<?php

namespace App\Policies;

use App\Expertise;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExpertisePolicy
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
    }

    /**
     * Determine whether the user can list Expertise(s).
     *
     * @return bool
     */
    public function index()
    {
        return false;
    }

    /**
     * Determine whether the user can see a Expertise.
     *
     * @param \App\User $user
     * @param Expertise $expertise
     *
     * @return bool
     */
    public function show(User $user, Expertise $expertise)
    {
        return $user->id === $expertise->user_id;
    }

    /**
     * Determine whether the user can create Expertise.
     *
     * @return bool
     */
    public function create()
    {
        return false;
    }

    /**
     * Determine whether the user can update the Expertise.
     *
     * @return bool
     */
    public function update()
    {
        return false;
    }

    /**
     * Determine whether the user can edit the Expertise.
     *
     * @return bool
     */
    public function edit()
    {
        return false;
    }

    /**
     * Determine whether the user can delete the Expertise.
     *
     * @return bool
     */
    public function delete()
    {
        return false;
    }
}
