<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;

class EditClientHospitalController extends Controller
{
    public function __invoke(Hospital $hospital)
    {
        return inertia()->render('Hospital/EditHospital', [
            'hospital' => Hospital::with('users')->find($hospital->id)
        ]);
    }
}
