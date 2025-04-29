<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeleteMemberController extends Controller
{
    public function __invoke(Request $request, User $member)
    {
        // delete from model has roles
        DB::table('model_has_roles')->where('model_id', $member->id)->delete() ?? null;
        DB::table('hospital_user')->where('user_id', $member->id)->where('hospital_id', $request->user()->currentHospital->id)->delete() ?? null;
        User::find($member->id)->delete() ?? null;
        return back();
    }
}
