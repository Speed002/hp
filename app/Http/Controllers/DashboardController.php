<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function __invoke()
    {
        // dd(auth()->user()->hasRole('hospital admin')); // works
        return inertia()->render('Dashboard');
    }
}
