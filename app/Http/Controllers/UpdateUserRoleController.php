<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateUserRoleController extends Controller
{
    public function __invoke(Request $request, User $member)
    {
        $user = User::findOrFail($member->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->contact = $request->contact;
        $user->save();

        $currentHospitalId = $request->user()->currentHospital->id;
        $existingRole = DB::table('model_has_roles')
            ->where('model_id', $user->id)
            ->where('current_hospital_id', $currentHospitalId)
            ->first();

        if ($existingRole) {
            // If a role already exists, update it
            DB::table('model_has_roles')
                ->where('model_id', $user->id)
                ->where('current_hospital_id', $currentHospitalId)
                ->update([
                    'role_id' => $request->role,
                ]);
        } else {
            // If no role exists, insert new
            DB::table('model_has_roles')->insert([
                'role_id' => $request->role,
                'model_type' => 'App\Models\User',
                'model_id' => $user->id,
                'current_hospital_id' => $currentHospitalId,
            ]);
        }

        return back();
    }

}
