<?php

namespace App\Http\Controllers;

use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;

class CreateServiceController extends Controller
{
    public function __invoke(Department $department){
        $department = DepartmentResource::make($department->load('services'));
        return inertia()->render('Hospital/Department/Service/Create', [
            'department' => $department,
        ]);
    }
}
