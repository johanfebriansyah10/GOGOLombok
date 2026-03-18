<?php

namespace App\Http\Controllers;

use App\Models\Wisata;
use App\Models\Criteria;
use App\Models\Evaluation;
use App\Services\SAWCalculator;
use Illuminate\Http\Request;

class SAWResultController extends Controller
{
    /**
     * Show SAW ranking results
     */
    public function index()
    {
        try {
            $result = SAWCalculator::getDetails();

            if (isset($result['error'])) {
                return view('saw.results.index', [
                    'error' => $result['error'],
                    'ranking' => collect(),
                    'criterias' => Criteria::with('weight')->get(),
                ]);
            }

            return view('saw.results.index', [
                'ranking' => $result['ranking'],
                'scores' => $result['scores'],
                'criterias' => Criteria::with('weight')->get(),
                'normalizedMatrix' => $result['normalized_matrix'],
            ]);
        } catch (\Exception $e) {
            return view('saw.results.index', [
                'error' => $e->getMessage(),
                'ranking' => collect(),
                'criterias' => Criteria::with('weight')->get(),
            ]);
        }
    }

    /**
     * Show detail of SAW calculation
     */
    public function detail($wisataId)
    {
        try {
            $result = SAWCalculator::getDetails();

            if (isset($result['error'])) {
                return redirect()->route('saw.results.index')->with('error', $result['error']);
            }

            $wisata = Wisata::find($wisataId);
            if (!$wisata) {
                return redirect()->route('saw.results.index')->with('error', 'Wisata tidak ditemukan');
            }

            // Find score detail for this wisata
            $scoreDetail = $result['ranking']->firstWhere('wisata_id', $wisataId);

            if (!$scoreDetail) {
                return redirect()->route('saw.results.index')->with('error', 'Data skor tidak ditemukan');
            }

            return view('saw.results.detail', [
                'wisata' => $wisata,
                'scoreDetail' => $scoreDetail,
                'ranking' => $result['ranking'],
                'criterias' => Criteria::with('weight')->get(),
            ]);
        } catch (\Exception $e) {
            return redirect()->route('saw.results.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Show comprehensive SAW analysis with all calculation steps
     */
    public function analysis()
    {
        try {
            $result = SAWCalculator::getDetails();

            if (isset($result['error'])) {
                return view('saw.results.analysis', [
                    'error' => $result['error'],
                    'decisionMatrix' => collect(),
                    'normalizedMatrix' => collect(),
                    'scores' => collect(),
                    'ranking' => collect(),
                    'criterias' => Criteria::with('weight')->get(),
                ]);
            }

            return view('saw.results.analysis', [
                'decisionMatrix' => $result['decision_matrix'],
                'normalizedMatrix' => $result['normalized_matrix'],
                'scores' => collect($result['scores'])->keyBy('wisata_id'),
                'ranking' => $result['ranking'],
                'criterias' => Criteria::with('weight')->get(),
            ]);
        } catch (\Exception $e) {
            return view('saw.results.analysis', [
                'error' => $e->getMessage(),
                'decisionMatrix' => collect(),
                'normalizedMatrix' => collect(),
                'scores' => collect(),
                'ranking' => collect(),
                'criterias' => Criteria::with('weight')->get(),
            ]);
        }
    }
}
