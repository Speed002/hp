<?php
namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AssignPermissionToRolesController extends Controller
{
    public function assign(Request $request){
        // permissions we never display to anyone.
        $superadmin_permissions = [
            'manage roles and permissions',
            'manage departments',
            'manage hospitals',
            'profile hospitals',
        ];
        // hospital admin permissions
        $other_permissions = [
            'create users',
            'update hospital',
            'profile hospital',
            'manage hospital',
            'assign roles and permissions'
        ];
        // get the departments of the hospital
        $hospital_department_ids = $request->user()->currentHospital->departments->pluck('id')->toArray() ?? null;
        // get services that have only been checked
        $selected_service_ids = DB::table('service_department')->where('hospital_id', $request->user()->currentHospital->id)->get()->pluck('service_id')->toArray() ?? null;
        // look through them now
        $services = array_map('strtolower', Service::whereIn('id', $selected_service_ids)
        ->pluck('name')
        ->toArray() ?? null);
        $hospital_role_names = Role::where('current_hospital_id', $request->user()->currentHospital->id)->get()->pluck('name')->toArray();

        // selected services only (for the current hospital)
        return inertia()->render('Hospital/Permission/Assign', [
            'permissions' => Permission::whereIn('name', $services)->orwhereIn('name', $other_permissions)->whereNotIn('name', $superadmin_permissions)->get(),
            'hospital_user_roles' => Role::where('current_hospital_id', $request->user()->currentHospital->id)->get(),
            'role_has_permissions' => DB::table('role_has_permissions')->get()
        ]);
    }
}
