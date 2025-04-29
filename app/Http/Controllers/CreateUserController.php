<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class CreateUserController extends Controller
{
    public function __invoke(Request $request)
    {
        return inertia()->render('User/Create', [
            'roles' => Role::where('current_hospital_id', $request->user()->currentHospital->id)->get(),
            'members' => UserResource::collection($request->user()->currentHospital->members)
        ]);
    }
}
