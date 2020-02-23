<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $Authenticateduser, User $user)
    {
        // return true;
        // Log::debug(['view' => $Authenticateduser->id === $user->id]);
        // die();
        return $Authenticateduser->id === $user->id;
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $Authenticateduser, User $user)
    {
        // return true;
        return $Authenticateduser->id === $user->id;
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $Authenticateduser, User $user)
    {
        // return true;
        return $Authenticateduser->id === $user->id && $Authenticateduser->token()->client->personal_access_client;
    }
}
