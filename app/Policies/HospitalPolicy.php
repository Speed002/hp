<?php

namespace App\Policies;

use App\Models\Hospital;
use App\Models\User;

class HospitalPolicy
{
    public function update(User $user, Hospital $hospital){
        if(!$user->hospitals->contains($hospital)){
            return false;
        }
        return $user->can('update hospital'); //the last check will be the permission check, to see if the user can update hospital
    }

}
