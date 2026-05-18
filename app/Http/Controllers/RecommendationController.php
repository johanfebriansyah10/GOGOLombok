<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Category;
use App\Services\SAWCalculator;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    /**
     * Show recommendation form with filter preferences
     */
    public function index(Request $request)
    {
        // Get filter values from request (if exists)
        $filters = [
            'max_budget' => $request->input('max_budget'),
            'max_distance' => $request->input('max_distance'),
            'facilities' => $request->input('facilities', []),
            'min_rating' => $request->input('min_rating'),
            'category_id' => $request->input('category_id'),
        ];

        // Remove null/empty values
        $filters = array_filter($filters, function ($value) {
            return !is_null($value) && (!is_array($value) || !empty($value));
        });

        $criterias = Criteria::with('weight')->get();
        $categories = Category::all();
        $hasFilters = !empty($filters);
        $result = null;

        // If there are filters, calculate SAW with filters
        if ($hasFilters) {
            $result = SAWCalculator::getDetails($filters);
        }

        return view('saw.recommendations.index', compact(
            'criterias',
            'categories',
            'filters',
            'hasFilters',
            'result'
        ));
    }

    /**
     * Reset filters and show all recommendations
     */
    public function reset()
    {
        return redirect()->route('saw.recommendations.index');
    }
}
