<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ManagePermissionsController extends Controller
{
    public function store(Role $role, Permission $permission){
        // dd($permission->id);
        DB::table('role_has_permissions')->insert([
            'permission_id' => $permission->id,
            'role_id' => $role->id
        ]);
        return back();
    }

    public function destroy(Role $role, Permission $permission){
        DB::table('role_has_permissions')->where('permission_id', $permission->id)->where('role_id', $role->id)->delete();
        return back();
    }
}
