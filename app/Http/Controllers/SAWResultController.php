<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Category;
use App\Services\SAWCalculator;
use Illuminate\Http\Request;

class SAWResultController extends Controller
{
    public function index(Request $request)
    {
        try {
            $result = SAWCalculator::getDetails();

            if (isset($result['error'])) {
                return view('saw.results.index', [
                    'error' => $result['error'],
                    'message' => null,
                    'ranking' => collect(),
                    'criterias' => Criteria::with('weight')->get(),
                    'categories' => Category::all(),
                    'selectedCategory' => null,
                ]);
            }

            if (isset($result['message'])) {
                return view('saw.results.index', [
                    'message' => $result['message'],
                    'error' => null,
                    'ranking' => collect(),
                    'criterias' => Criteria::with('weight')->get(),
                    'categories' => Category::all(),
                    'selectedCategory' => null,
                ]);
            }

            // Ambil ranking hasil SAW
            $ranking = $result['ranking'];
            $selectedCategory = $request->get('category');

            // Filter berdasarkan kategori jika ada
            if ($selectedCategory) {
                $ranking = collect($ranking)->filter(function ($item) use ($selectedCategory) {
                    $wisata = \App\Models\Wisata::find($item['wisata_id']);
                    return $wisata && $wisata->category_id == $selectedCategory;
                })->values();
            }

            return view('saw.results.index', [
                'ranking' => $ranking,
                'scores' => $result['scores'],
                'criterias' => Criteria::with('weight')->get(),
                'categories' => Category::all(),
                'selectedCategory' => $selectedCategory,
                'error' => null,
                'message' => null,
            ]);
        } catch (\Exception $e) {
            return view('saw.results.index', [
                'error' => $e->getMessage(),
                'message' => null,
                'ranking' => collect(),
                'criterias' => Criteria::with('weight')->get(),
                'categories' => Category::all(),
                'selectedCategory' => null,
            ]);
        }
    }
}
