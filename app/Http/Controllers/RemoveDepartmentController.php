<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RemoveDepartmentController extends Controller
{
    public function __invoke(Hospital $hospital, Department $department)
    {
        // remove services from department before detaching department
        DB::table('service_department')
        ->where('hospital_id', $hospital->id)
        ->where('department_id', $department->id)
        ->delete();
        // then detach the department
        $hospital->departments()->detach($department);
        return back();
    }
}
