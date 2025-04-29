<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class EditServiceController extends Controller
{
    public function __invoke(Request $request, Service $service)
    {
        $service = Service::find($service->id);
        // update permission name
        $lowercase_service_name = strtolower($service->name);
        $permission = Permission::where('name', $lowercase_service_name)->first() ?? null;
        $permission->name = strtolower($request->name);
        $permission->save();
        // dd($permission->name);
        // update the service name
        $service->name = $request->name;
        $service->code_name = str_replace(' ', '_', strtolower($request->name));
        $service->save();

        // creating permissions
        return back();
    }
}
