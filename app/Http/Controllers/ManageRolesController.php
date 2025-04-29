<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ManageRolesController extends Controller
{
    public function __invoke()
    {
        $superadmin_permissions = [
            'manage roles and permissions',
            'manage departments',
            'manage hospitals',
            'profile hospitals'
        ];
        
        $permissions_in_services = Service::get()->pluck('name')->toArray();
        return inertia()->render('Hospital/Role/Index', [
            'permissions' => Permission::whereNotIn('name', $superadmin_permissions)->WhereNotIn('name', $permissions_in_services)->get(),
            'roles' => Role::where('current_hospital_id', null)->where('name', '!=', 'super admin')->get(),
            'role_has_permissions' => DB::table('role_has_permissions')->get()
        ]);
    }

    // super user
    public function store(Request $request){
        // dd(123);
        // validate requests the default way
        $this->validate($request, [
            'name' => [
                'required',
                Rule::notIn(['hospital admin', 'super admin']),
            ]
        ]);
        Role::create([
            'current_hospital_id' => null,
            'name' => strtolower($request->name),
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        return back();
    }

    // admin
    public function newRole(Request $request){
        $this->validate($request, [
            'role_name' => [
                'required',
                Rule::notIn(['hospital admin', 'super admin']),
            ]
        ]);
        DB::table('roles')->insert([
            'current_hospital_id' => $request->user()->currentHospital->id,
            'name' => strtolower($request->role_name),
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('toast', 'New role created!');
    }

    public function destroy(Role $role){
        // delete all permissions attached to that role
        // you are deleting a specific permission from the role
        DB::table('role_has_permissions')->where('role_id', $role->id)->delete();
        $role->delete();
        return back()->with('toast', 'Successfully removed!');
    }
}
