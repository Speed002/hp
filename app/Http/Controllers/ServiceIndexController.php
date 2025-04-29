<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceIndexController extends Controller
{
    // Every function has a different logic
    public function register_patient(){
        dd('register patient');
    }
    public function active_patient(){
        dd('active patient');
    }
    public function appointment(){
        dd('appointment');
    }
    public function search_patient(){
        dd('search patient');
    }
    public function process_payment(){
        dd('process payment');
    }
    public function view_receipt(){
        dd('view_receipt');
    }
    public function view_invoice(){
        dd('view_invoice');
    }
    public function view_debtors(){
        dd('view_debtors');
    }
    public function debit(){
        dd('debit');
    }
    public function view_reports(){
        dd('view_reports');
    }
    public function view_transactions(){
        dd('view_transactions');
    }
    public function view_dashboard(){
        dd('view_dashboard');
    }
    public function credit(){
        dd('credit');
    }
    public function view_checkout(){
        dd('view_checkout');
    }
}
