<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the user dashboard.
     */
    public function show(Request $request)
    {
        return view('user/dashboard');
    }
}
