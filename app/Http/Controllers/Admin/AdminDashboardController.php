<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Criteria;
use App\Models\Evaluation;
use App\Models\User;
use App\Models\Weight;
use App\Models\Wisata;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function show(Request $request)
    {
        $stats = [
            'total_wisata' => Wisata::count(),
            'total_kategori' => Category::count(),
            'total_bobot' => Weight::count(),
            'total_kriteria' => Criteria::count(),
            'total_evaluasi' => Evaluation::count(),
            'total_user' => User::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
