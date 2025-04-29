<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Hospital;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RemoveServiceController extends Controller
{
    public function __invoke(Request $request, Hospital $hospital, Department $department, Service $service)
    {
        $service = Service::find($service->id);
        $service_permission = Permission::where('name', $service->name)->first();
        $role_that_has_the_permission = DB::table('role_has_permissions')->where('permission_id', $service_permission->id)->first();
        $role_belongs_to_current_hospital = Role::where('id', $role_that_has_the_permission->role_id)
        ->where('current_hospital_id', $request->user()->currentHospital->id)
        ->first();
        if($role_belongs_to_current_hospital){
            DB::table('role_has_permissions')->where('permission_id', $service_permission->id)->where('role_id', $role_that_has_the_permission->role_id)->delete();
            // then delete the service from that hospital
            DB::table('service_department')
            ->where('hospital_id', $hospital->id)
            ->where('department_id', $department->id)
            ->where('service_id', $service->id)
            ->delete();
        }
        return back();
    }
}
