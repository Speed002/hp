<?php

namespace App\Http\Controllers;

use App\Http\Resources\DepartmentResource;
use App\Http\Resources\HospitalResource;
use App\Models\Department;
use App\Models\Hospital;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class AddServiceController extends Controller
{
    public function __invoke(Hospital $hospital)
    {
        $hospital = HospitalResource::make($hospital->load(['departments', 'departments.services']));
        // getting the ids from the current hospital departments
        $hospital_department_ids = $hospital->departments->pluck('id')->toArray();
        $other_departments = Department::whereNotIn('id', $hospital_department_ids)->get();
        $department_services = DB::table('service_department')->where('hospital_id', $hospital->id)->get();
        return inertia()->render('Hospital/Department/AddService', [
            'hospital' => $hospital,
            'services' => Service::get(),
            'other_departments' => DepartmentResource::collection($other_departments),
            'department_services' => $department_services
        ]);
    }

    public function store(Hospital $hospital, Department $department, Service $service){
        DB::table('service_department')->insert([
            'service_id'=> $service->id,
            'department_id' => $department->id,
            'hospital_id' => $hospital->id,
            'created_at' => now()
        ]);
        return back();
    }
}
