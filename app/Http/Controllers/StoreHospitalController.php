<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHospitalRequest;
use App\Models\Hospital;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StoreHospitalController extends Controller
{
    public function __invoke(StoreHospitalRequest $request)
    {
        $user = User::create([
            'name' => $request->user_name,
            'email' => $request->user_email,
            'password' => Hash::make('password'),
            'contact' => $request->user_contact,
            'email_verified_at' => now(),
        ]);
        $user->hospitals()->attach(
            $hospital = Hospital::create([
                'name' => $request->hospital_name,
                'address' => $request->hospital_address
            ])
        );
        // saving hospital under current user
        $user->currentHospital()->associate($hospital);
        $user->save();
        // setting hospital to administer
        setPermissionsTeamId($hospital->id);
        $user->assignRole('hospital admin');
        // Creating departments in the hospital
        foreach ($request->departments as $department_id) {
            DB::table('department_hospital')->insert([
                'department_id'=> $department_id,
                'hospital_id' => $hospital->id,
                'created_at' => now()
            ]);
        }
        return redirect()->route('hospital.settings', $hospital->id);
    }
}
