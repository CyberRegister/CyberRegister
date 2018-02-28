<?php

namespace App\Policies;

use App\PcePoint;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PcePointPolicy
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
     * Determine whether the user can list PcePoint(s).
     *
     * @return bool
     */
    public function index()
    {
        return false;
    }

    /**
     * Determine whether the user can see a PcePoint.
     *
     * @param \App\User $user
     * @param PcePoint  $pcePoint
     *
     * @return bool
     */
    public function show(User $user, PcePoint $pcePoint)
    {
        return $user->id === $pcePoint->user_id;
    }

    /**
     * Determine whether the user can create PcePoint.
     *
     * @return bool
     */
    public function create()
    {
        return false;
    }

    /**
     * Determine whether the user can update the PcePoint.
     *
     * @return bool
     */
    public function update()
    {
        return false;
    }

    /**
     * Determine whether the user can edit the PcePoint.
     *
     * @return bool
     */
    public function edit()
    {
        return false;
    }

    /**
     * Determine whether the user can delete the PcePoint.
     *
     * @return bool
     */
    public function delete()
    {
        return false;
    }
}
