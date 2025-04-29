<?php

namespace App\Policies;

use App\Models\Hospital;
use App\Models\User;

class UserPolicy
{
    public function create(User $user, Hospital $hospital){
        if(!$user->hospitals->contain($hospital)){
            return false;
        }
        return $user->can('create users'); //checking the permission
    }
}
