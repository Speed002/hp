<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;

class HospitalIndexController extends Controller
{
    public function __invoke(Request $request)
    {
        return inertia()->render('Hospital/Index', [
            'hospitals' => Hospital::with(['departments', 'users'])->where('id', '!=', $request->user()->currentHospital->id)->get()
        ]);
    }
}
