<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class CreateHospitalController extends Controller
{
    public function __invoke()
    {
        $categories = Department::select('category')->distinct()->pluck('category');
        $departments= Department::get();
        return inertia()->render('Hospital/Create', [
            'categories' => $categories,
            'departments' => $departments
        ]);
    }
}
