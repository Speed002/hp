<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DestroyDepartmentController extends Controller
{
    public function __invoke(Department $department)
    {
        DB::table('department_hospital')->where('department_id', $department->id)->delete();
        DB::table('service_department')->where('department_id', $department->id)->delete();
        $services = Service::where('department_id', $department->id)->delete();
        $department->delete();
        return back()->with('toast', 'Deleted successfully!');
    }
}
