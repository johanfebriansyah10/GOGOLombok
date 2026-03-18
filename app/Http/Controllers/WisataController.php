<?php

namespace App\Http\Controllers;

use App\Models\Wisata;
use App\Models\Category;
use Illuminate\Http\Request;

class WisataController extends Controller
{
    /**
     * Show the wisata catalog page
     */
    public function catalog()
    {
        $wisatas = Wisata::with('category')->get();
        $categories = Category::all();

        return view('user.wisata.catalog', compact('wisatas', 'categories'));
    }

    /**
     * Show a specific wisata detail page
     */
    public function show($id)
    {
        $wisata = Wisata::with('category')->findOrFail($id);

        // Get related wisatas (from same category, excluding current)
        $related = Wisata::where('category_id', $wisata->category_id)
            ->where('id', '!=', $wisata->id)
            ->limit(4)
            ->get();

        return view('user.wisata.show', compact('wisata', 'related'));
    }
}
