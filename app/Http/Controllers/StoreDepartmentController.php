<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddDepartmentRequest;
use App\Http\Requests\StoreDepartmentRequest;
use App\Models\Department;
use App\Models\Hospital;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\PseudoTypes\LowercaseString;

class StoreDepartmentController extends Controller
{
    public function __invoke(StoreDepartmentRequest $request)
    {
        // dd($request->name);
        Department::create([
            'name' => $request->name,
            'category' => $request->category,
            'code_name' => str_replace(' ', '_', strtolower($request->name))
        ]);
        return back()->with('toast', 'Department created successfully');
    }

    public function add(AddDepartmentRequest $request, Hospital $hospital){
        // dd($request->name);
        $hospital->departments()->attach($request->name);
        return back();
    }
}
