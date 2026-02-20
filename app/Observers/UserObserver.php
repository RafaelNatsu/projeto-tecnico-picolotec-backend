<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        if($user->roles()->count() == 0){
            $user->assignRole('usuario');
        }
    }

}
