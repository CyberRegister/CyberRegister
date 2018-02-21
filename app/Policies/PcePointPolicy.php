<?php

namespace App\Policies;

use App\User;
use App\PcePoint;
use Illuminate\Auth\Access\HandlesAuthorization;

class PcePointPolicy
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
     * Determine whether the user can list PcePoint(s).
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can see a PcePoint.
     *
     * @param  \App\User  $user
     * @param  PcePoint $pcePoint
     * @return mixed
     */
    public function show(User $user, PcePoint $pcePoint)
    {
        return $user->id === $pcePoint->user_id;
    }

    /**
     * Determine whether the user can create PcePoint.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the PcePoint.
     *
     * @param  \App\User  $user
     * @param  \App\PcePoint  $pcePoint
     * @return mixed
     */
    public function update(User $user, PcePoint $pcePoint)
    {
        return false;
    }

    /**
     * Determine whether the user can edit the PcePoint.
     *
     * @param  \App\User  $user
     * @param  \App\PcePoint  $pcePoint
     * @return mixed
     */
    public function edit(User $user, PcePoint $pcePoint)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the PcePoint.
     *
     * @param  \App\User  $user
     * @param  \App\PcePoint  $pcePoint
     * @return mixed
     */
    public function delete(User $user, PcePoint $pcePoint)
    {
        return false;
    }
}
