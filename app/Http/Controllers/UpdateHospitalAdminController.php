<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UpdateHospitalAdminController extends Controller
{
    public function __invoke(Request $request, User $user)
    {
        // dd($request->admin_contact);
        $user->name = $request->admin_username;
        $user->email = $request->admin_email;
        $user->contact = $request->admin_contact;
        $user->save();
        return back()->with('toast', 'Updated!');
    }
}
