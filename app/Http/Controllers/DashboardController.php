<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $nombreDepartements = 5 ;

        $nombreEmployees = Employee::count();

        return view('dashboard', compact('nombreDepartements', 'nombreEmployees'));
    }

}
