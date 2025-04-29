<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Models\Department;
use App\Models\Service;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class StoreServiceController extends Controller
{
    public function __invoke(StoreServiceRequest $request, Department $department)
    {
        // dd($department);
        $department->services()->create([
            'name' => $request->name,
            'code_name' => str_replace(' ', '_', strtolower($request->name))
        ]);
        // creating permissions
        Permission::create([
            'name' => strtolower($request->name),
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        return back()->with('toast', 'Service created!');
    }
}
