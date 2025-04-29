<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class CreateDepartmentController extends Controller
{
    public function __invoke()
    {
        $departments = Department::get();
        return inertia()->render('Hospital/Department/Create', [
            'departments' => $departments
        ]);
    }
}
