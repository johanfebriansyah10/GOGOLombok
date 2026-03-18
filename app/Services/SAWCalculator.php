<?php

namespace App\Services;

use App\Models\Wisata;
use App\Models\Criteria;
use App\Models\Evaluation;
use App\Models\Weight;
use Illuminate\Support\Collection;

class SAWCalculator
{
    /**
     * Calculate SAW (Simple Additive Weighting) score with optional filters
     */
    public static function calculate($filters = null)
    {
        // 1. Validasi: Total bobot harus = 1
        if (!Weight::isWeightValid()) {
            throw new \Exception('Total bobot harus sama dengan 1');
        }

        // 2. Ambil wisata dengan filter (jika ada)
        $wisatasQuery = Wisata::all();

        if ($filters && is_array($filters)) {
            $wisatasQuery = self::applyFilters($wisatasQuery, $filters);
        }

        $wisatas = $wisatasQuery;
        if ($wisatas->isEmpty()) {
            throw new \Exception('Tidak ada data wisata yang sesuai dengan filter');
        }

        // 3. Ambil semua kriteria dengan bobot
        $criterias = Criteria::with('weight')->get();
        if ($criterias->isEmpty()) {
            throw new \Exception('Tidak ada kriteria');
        }

        // 4. Ambil semua evaluasi
        $evaluations = Evaluation::all();
        if ($evaluations->isEmpty()) {
            throw new \Exception('Belum ada evaluasi untuk wisata');
        }

        // 5. Buat decision matrix (wisata × kriteria)
        $decisionMatrix = self::buildDecisionMatrix($wisatas, $criterias, $evaluations);

        // 6. Normalisasi sesuai tipe (benefit/cost)
        $normalizedMatrix = self::normalize($decisionMatrix, $criterias);

        // 7. Hitung weighted score (Vi)
        $scores = self::calculateScores($normalizedMatrix, $criterias, $wisatas);

        // 8. Sort by score (descending)
        $ranking = $scores->sortByDesc('score')->values();

        return [
            'decision_matrix' => $decisionMatrix,
            'normalized_matrix' => $normalizedMatrix,
            'scores' => $scores,
            'ranking' => $ranking,
        ];
    }

    /**
     * Build decision matrix (wisata × kriteria)
     */
    private static function buildDecisionMatrix($wisatas, $criterias, $evaluations)
    {
        $matrix = [];

        foreach ($wisatas as $wisata) {
            $row = [
                'wisata_id' => $wisata->id,
                'wisata_name' => $wisata->name,
                'values' => [],
            ];

            foreach ($criterias as $criteria) {
                // Cari nilai evaluasi untuk wisata & kriteria ini
                $eval = $evaluations->firstWhere(function ($e) use ($wisata, $criteria) {
                    return $e->wisata_id == $wisata->id && $e->criteria_id == $criteria->id;
                });

                $row['values'][$criteria->id] = [
                    'criteria_code' => $criteria->code,
                    'criteria_name' => $criteria->name,
                    'criteria_type' => $criteria->type,
                    'value' => $eval ? $eval->value : 0,
                ];
            }

            $matrix[] = $row;
        }

        return $matrix;
    }

    /**
     * Normalize values (benefit: value/max, cost: min/value)
     */
    private static function normalize($decisionMatrix, $criterias)
    {
        $normalized = [];

        foreach ($criterias as $criteria) {
            // Cari max dan min value untuk kriteria ini
            $values = collect($decisionMatrix)->flatMap(function ($row) use ($criteria) {
                return [$row['values'][$criteria->id]['value'] ?? 0];
            });

            $maxValue = $values->max();
            $minValue = $values->min();

            // Normalisasi
            foreach ($decisionMatrix as $index => $row) {
                if (!isset($normalized[$index])) {
                    $normalized[$index] = [
                        'wisata_id' => $row['wisata_id'],
                        'wisata_name' => $row['wisata_name'],
                        'normalized_values' => [],
                    ];
                }

                $value = $row['values'][$criteria->id]['value'] ?? 0;

                if ($criteria->type === 'benefit') {
                    // Benefit: normalisasi = value / max
                    $normalized_value = $maxValue > 0 ? $value / $maxValue : 0;
                } else {
                    // Cost: normalisasi = min / value
                    $normalized_value = $value > 0 ? $minValue / $value : 0;
                }

                $normalized[$index]['normalized_values'][$criteria->id] = [
                    'criteria_code' => $row['values'][$criteria->id]['criteria_code'],
                    'criteria_name' => $row['values'][$criteria->id]['criteria_name'],
                    'criteria_type' => $criteria->type,
                    'original_value' => $value,
                    'max_value' => $maxValue,
                    'min_value' => $minValue,
                    'normalized_value' => round($normalized_value, 4),
                ];
            }
        }

        return array_values($normalized);
    }

    /**
     * Calculate weighted score (Vi) = Σ (rij × wj)
     */
    private static function calculateScores($normalizedMatrix, $criterias, $wisatas)
    {
        $scores = collect();

        foreach ($normalizedMatrix as $row) {
            $totalScore = 0;
            $scoreDetails = [];

            foreach ($criterias as $criteria) {
                $normalized = $row['normalized_values'][$criteria->id]['normalized_value'];
                $weight = $criteria->weight->weight;

                $weighted = $normalized * $weight;
                $totalScore += $weighted;

                $scoreDetails[] = [
                    'criteria_code' => $criteria->code,
                    'criteria_name' => $criteria->name,
                    'normalized' => $normalized,
                    'weight' => $weight,
                    'weighted' => round($weighted, 6),
                ];
            }

            $wisata = $wisatas->find($row['wisata_id']);

            $scores->push([
                'rank' => 0, // Will be set after sorting
                'wisata_id' => $row['wisata_id'],
                'wisata_name' => $row['wisata_name'],
                'image' => $wisata->image,
                'score' => round($totalScore, 4),
                'score_details' => $scoreDetails,
            ]);
        }

        return $scores;
    }

    /**
     * Apply user filters to wisata collection
     */
    private static function applyFilters($wisatas, $filters)
    {
        return $wisatas->filter(function ($wisata) use ($filters) {
            // Filter: Budget maksimal
            if (isset($filters['max_budget']) && $filters['max_budget'] > 0) {
                if ($wisata->ticket_price > $filters['max_budget']) {
                    return false;
                }
            }

            // Filter: Jarak maksimal (km)
            if (isset($filters['max_distance']) && $filters['max_distance'] > 0) {
                if ($wisata->distance > $filters['max_distance']) {
                    return false;
                }
            }

            // Filter: Fasilitas minimal
            if (isset($filters['min_facilities']) && $filters['min_facilities'] > 0) {
                if ($wisata->facilities_count < $filters['min_facilities']) {
                    return false;
                }
            }

            // Filter: Rating minimal
            if (isset($filters['min_rating']) && $filters['min_rating'] > 0) {
                if ($wisata->actual_rating < $filters['min_rating']) {
                    return false;
                }
            }

            return true;
        })->values();
    }

    /**
     * Get calculation details with optional filters
     */
    public static function getDetails($filters = null)
    {
        try {
            $result = self::calculate($filters);

            // Add ranking numbers
            foreach ($result['ranking'] as $index => $item) {
                $item['rank'] = $index + 1;
            }

            return $result;
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }
}
