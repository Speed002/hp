<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EditHospitalController extends Controller
{
    public function __invoke(Request $request)
    {
        return inertia()->render('Hospital/Edit', [
            'hospital' => $request->user()->currentHospital
        ]);
    }
}
