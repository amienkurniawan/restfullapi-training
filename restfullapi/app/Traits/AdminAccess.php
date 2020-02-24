<?php

namespace App\Traits;

trait AdminAccess
{
    /**
     * this method is execute before the method policy execute if return null then this method is ignore
     * @param $user current user login
     * @param $ability
     * @return boolean
     */
    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }
}
