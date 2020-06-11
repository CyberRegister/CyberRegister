<?php

namespace App\Policies;

use App\CyberExpertise;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CyberExpertisePolicy
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
     * Determine whether the user can create CyberExpertise.
     *
     * @return bool
     */
    public function create()
    {
        return false;
    }

    /**
     * Determine whether the user can update the CyberExpertise.
     *
     * @return bool
     */
    public function update()
    {
        return false;
    }

    /**
     * Determine whether the user can edit the CyberExpertise.
     *
     * @return bool
     */
    public function edit()
    {
        return false;
    }

    /**
     * Determine whether the user can delete the CyberExpertise.
     *
     * @return bool
     */
    public function delete()
    {
        return false;
    }
}
