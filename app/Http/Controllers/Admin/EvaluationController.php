<?php

namespace App\Http\Controllers\Admin;

use App\Models\Wisata;
use App\Models\Criteria;
use App\Models\Evaluation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    /**
     * Show matrix input form
     */
    public function index()
    {
        $wisatas = Wisata::all();
        $criterias = Criteria::with('weight')->get();
        $evaluations = Evaluation::all();

        // Auto-populate jika belum ada evaluasi sama sekali
        if ($evaluations->isEmpty()) {
            $this->populateEvaluations();
            $evaluations = Evaluation::all();
        }

        // Build evaluation matrix for display
        $matrix = [];
        foreach ($wisatas as $wisata) {
            $row = ['wisata_id' => $wisata->id, 'wisata_name' => $wisata->name];
            foreach ($criterias as $criteria) {
                $eval = $evaluations->firstWhere(function ($e) use ($wisata, $criteria) {
                    return $e->wisata_id == $wisata->id && $e->criteria_id == $criteria->id;
                });
                $row[$criteria->id] = $eval ? $eval->value : null;
            }
            $matrix[] = $row;
        }

        return view('admin.evaluations.index', [
            'wisatas' => $wisatas,
            'criterias' => $criterias,
            'matrix' => $matrix,
            'evaluations' => $evaluations,
        ]);
    }

    /**
     * Auto-populate evaluations from wisata data (helper method)
     */
    private function populateEvaluations()
    {
        $requiredCriteriaCodes = ['C1', 'C2', 'C3', 'C4'];
        $criteriaIds = Criteria::whereIn('code', $requiredCriteriaCodes)
            ->pluck('id', 'code');

        $missingCriteriaCodes = array_diff($requiredCriteriaCodes, $criteriaIds->keys()->all());

        if ($missingCriteriaCodes !== []) {
            return; // Skip jika kriteria tidak lengkap
        }

        $wisatas = Wisata::all([
            'id',
            'ticket_price',
            'distance',
            'facilities_count',
            'actual_rating',
        ]);

        foreach ($wisatas as $wisata) {
            $evaluations = [
                ['criteria_id' => $criteriaIds['C1'], 'value' => $wisata->ticket_price],
                ['criteria_id' => $criteriaIds['C2'], 'value' => $wisata->distance],
                ['criteria_id' => $criteriaIds['C3'], 'value' => $wisata->facilities_count],
                ['criteria_id' => $criteriaIds['C4'], 'value' => $wisata->actual_rating],
            ];

            foreach ($evaluations as $evaluation) {
                Evaluation::updateOrCreate(
                    [
                        'wisata_id' => $wisata->id,
                        'criteria_id' => $evaluation['criteria_id'],
                    ],
                    ['value' => $evaluation['value']]
                );
            }
        }
    }

    /**
     * Store or update evaluation
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'wisata_id' => 'required|exists:wisatas,id',
            'criteria_id' => 'required|exists:criterias,id',
            'value' => 'required|numeric|min:0',
        ]);

        Evaluation::updateOrCreate(
            [
                'wisata_id' => $validated['wisata_id'],
                'criteria_id' => $validated['criteria_id'],
            ],
            ['value' => $validated['value']]
        );

        return response()->json([
            'success' => true,
            'message' => 'Evaluasi berhasil disimpan',
        ]);
    }

    /**
     * Delete evaluation
     */
    public function destroy(Evaluation $evaluation)
    {
        $evaluation->delete();

        return response()->json([
            'success' => true,
            'message' => 'Evaluasi berhasil dihapus',
        ]);
    }

    /**
     * Auto-populate evaluations from wisata data
     */
    public function populate()
    {
        $requiredCriteriaCodes = ['C1', 'C2', 'C3', 'C4'];
        $criteriaIds = Criteria::whereIn('code', $requiredCriteriaCodes)
            ->pluck('id', 'code');

        $missingCriteriaCodes = array_diff($requiredCriteriaCodes, $criteriaIds->keys()->all());

        if ($missingCriteriaCodes !== []) {
            return redirect()->route('admin.evaluations.index')
                ->with('error', 'Kriteria berikut belum tersedia: ' . implode(', ', $missingCriteriaCodes));
        }

        $wisatas = Wisata::all([
            'id',
            'ticket_price',
            'distance',
            'facilities_count',
            'actual_rating',
        ]);

        $populatedCount = 0;

        foreach ($wisatas as $wisata) {
            $evaluations = [
                ['criteria_id' => $criteriaIds['C1'], 'value' => $wisata->ticket_price],
                ['criteria_id' => $criteriaIds['C2'], 'value' => $wisata->distance],
                ['criteria_id' => $criteriaIds['C3'], 'value' => $wisata->facilities_count],
                ['criteria_id' => $criteriaIds['C4'], 'value' => $wisata->actual_rating],
            ];

            foreach ($evaluations as $evaluation) {
                Evaluation::updateOrCreate(
                    [
                        'wisata_id' => $wisata->id,
                        'criteria_id' => $evaluation['criteria_id'],
                    ],
                    ['value' => $evaluation['value']]
                );
                $populatedCount++;
            }
        }

        return redirect()->route('admin.evaluations.index')
            ->with('success', "Berhasil mengisi nilai evaluasi data wisata");
    }

    /**
     * Import evaluations from file
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getRealPath(), 'r');

        $header = fgetcsv($handle); // Skip header
        $imported = 0;

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < 3) continue;

            $wisataName = trim($row[0]);
            $criteriaCode = trim($row[1]);
            $value = (float)$row[2];

            $wisata = Wisata::where('name', $wisataName)->first();
            $criteria = Criteria::where('code', $criteriaCode)->first();

            if ($wisata && $criteria) {
                Evaluation::updateOrCreate(
                    ['wisata_id' => $wisata->id, 'criteria_id' => $criteria->id],
                    ['value' => $value]
                );
                $imported++;
            }
        }

        fclose($handle);

        return redirect()->route('admin.evaluations.index')
            ->with('success', "Berhasil mengimpor $imported evaluasi");
    }
}
