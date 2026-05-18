<?php

namespace App\Http\Controllers;

use App\Models\Wisata;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function show(Request $request)
    {
        $wisatas = Wisata::orderBy('actual_rating', 'desc')->limit(3)->get();

        // Get featured wisata with image for hero background
        $featuredWisata = Wisata::whereNotNull('image')->orderBy('actual_rating', 'desc')->first();

        // Get all categories with their wisata (limited to 3 per category)
        $categories = Category::with(['wisatas' => function ($query) {
            $query->orderBy('actual_rating', 'desc')->limit(3);
        }])->get();

        return view('user/dashboard', [
            'wisatas' => $wisatas,
            'featuredWisata' => $featuredWisata,
            'categories' => $categories
        ]);
    }
}
