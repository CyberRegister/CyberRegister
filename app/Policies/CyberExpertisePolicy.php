<?php

namespace App\Policies;

use App\User;
use App\CyberExpertise;
use Illuminate\Auth\Access\HandlesAuthorization;

class CyberExpertisePolicy
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
     * Determine whether the user can create cyberExpertises.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the cyberExpertise.
     *
     * @param  \App\User  $user
     * @param  \App\CyberExpertise  $cyberExpertise
     * @return mixed
     */
    public function update(User $user, CyberExpertise $cyberExpertise)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the cyberExpertise.
     *
     * @param  \App\User  $user
     * @param  \App\CyberExpertise  $cyberExpertise
     * @return mixed
     */
    public function delete(User $user, CyberExpertise $cyberExpertise)
    {
        return false;
    }
}
