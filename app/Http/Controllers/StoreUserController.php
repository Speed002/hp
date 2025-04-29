<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class StoreUserController extends Controller
{
    public function __invoke(UserStoreRequest $request)
    {
        $hospital = $request->user()->currentHospital;
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password'), // consider random + email
            'contact' => $request->contact ?? '000000000', // optional fallback
            'email_verified_at' => now()
        ]);
        
        $user->hospitals()->attach($hospital);
        $user->currentHospital()->associate($hospital);
        $user->save();

        setPermissionsTeamId($hospital->id);
        $user->assignRole($request->role);
        return back()->with('toast', 'User created successfully!');
    }
}
