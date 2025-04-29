<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UpdateHospitalController extends Controller
{
    public function __invoke(Request $request)
    {
        $hospital = $request->user()->currentHospital;
        $this->authorize('update', $hospital);
        $request->user()->currentHospital->update($request->only('name', 'address'));

        $request->user()->contact = $request->contact;
        $request->user()->save();
        return back()->with('toast', 'Updated successfully!');
    }
}
