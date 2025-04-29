<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class DestroyServiceController extends Controller
{
    public function __invoke(Service $service){
        // remove permission that aligns with service name
        $lower_case_service = strtolower($service->name);
        Permission::where('name', $lower_case_service)->first()->delete() ?? null;
        DB::table('service_department')->where('service_id', $service->id)->delete() ?? null;
        $service->delete();
        return back();
    }
}
