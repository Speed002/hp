<?php

namespace App\Observers;

use App\Models\Hospital;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserObserver
{
    public function created(User $user)
    {
        // This observer function will be used but only to create a super admin, and nothing more
        // if it finds super admin, it will skip, if it doesnt find super admin, it will create super admin... we hope this runs forever
        $user->email_verified_at = now();
        $user->save();

        $role = Role::where('name', 'super admin')->first();
        $role_is_assigned_to_user = DB::table('model_has_roles')->where('role_id', $role->id)->get()->count();
        if($role_is_assigned_to_user > 0){
            return;
        }else{
            $user->hospitals()->attach(
                $hospital = Hospital::create([
                    'name' => $user->name . ' hospital'
                ])
            );
            $user->currentHospital()->associate($hospital);
            $user->save();

            setPermissionsTeamId($hospital->id);
            $user->assignRole('super admin');
        }
    }
}
