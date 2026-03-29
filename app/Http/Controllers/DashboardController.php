<?php

namespace App\Http\Controllers;

use App\Models\Wisata;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the user dashboard.
     */
    public function show(Request $request)
    {
        $wisatas = Wisata::orderBy('rating', 'desc')->limit(3)->get();
        return view('user/dashboard', ['wisatas' => $wisatas]);
    }
}
