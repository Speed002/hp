<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;

class UpdateClientHospitalController extends Controller
{
    public function __invoke(Request $request, Hospital $hospital){
        $hospital->name = $request->name;
        $hospital->address = $request->address;
        $hospital->save();
        return back()->with('toast', 'Updated!');
    }
}
