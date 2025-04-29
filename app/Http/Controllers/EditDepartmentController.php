<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class EditDepartmentController extends Controller
{
    public function __invoke(Request $request, Department $department)
    {
        $department = Department::find($department->id);
        $department->name = $request->name;
        $department->code_name = str_replace(' ', '_', strtolower($request->name));
        $department->category = $request->category;
        $department->save();
        return back();
    }
}
