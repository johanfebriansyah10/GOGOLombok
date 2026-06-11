<?php

namespace App\Services;

use App\Models\Wisata;
use App\Models\Criteria;
use App\Models\Evaluation;
use App\Models\Weight;

class SAWCalculator
{
    public static function calculate($filters = null)
    {
        // 1. Validasi: Total bobot harus = 1
        if (!Weight::isWeightValid()) {
            throw new \Exception('Total bobot harus sama dengan 1');
        }

        // 2. Ambil wisata
        $wisatasQuery = Wisata::all();

        // Jika user location valid diberikan di filters, attach jarak ke setiap wisata
        if (is_array($filters) && self::hasValidCoordinates($filters['user_lat'] ?? null, $filters['user_lng'] ?? null)) {
            $wisatasQuery = self::attachDistances($wisatasQuery, $filters['user_lat'], $filters['user_lng']);
        }

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
            return [
                'decision_matrix' => [],
                'normalized_matrix' => [],
                'scores' => collect(),
                'ranking' => collect(),
                'message' => 'Belum ada evaluasi untuk wisata',
            ];
        }

        // 5. Buat decision matrix (wisata × kriteria)
        $decisionMatrix = self::buildDecisionMatrix($wisatas, $criterias, $evaluations);

        // 6. Normalisasi sesuai tipe (benefit/cost)
        $normalizedMatrix = self::normalize($decisionMatrix, $criterias);

        // 7. Hitung weighted score (Vi)
        $scores = self::calculateScores($normalizedMatrix, $criterias, $wisatas);

        // 8. Sort by score, then prefer higher review credibility when scores tie
        $ranking = $scores->sort(function ($a, $b) {
            return [$b['score'], $b['review_count'], $b['actual_rating'], $a['wisata_name']]
                <=>
                [$a['score'], $a['review_count'], $a['actual_rating'], $b['wisata_name']];
        })->values()->map(function ($item, $index) {
            $item['rank'] = $index + 1;
            return $item;
        });

        return [
            'decision_matrix' => $decisionMatrix,
            'normalized_matrix' => $normalizedMatrix,
            'scores' => $scores,
            'ranking' => $ranking,
        ];
    }

    /**
     * Attach computed distance (km) from user location to each wisata in collection
     */
    private static function attachDistances($wisatas, $userLat, $userLng)
    {
        return $wisatas->map(function ($wisata) use ($userLat, $userLng) {
            $lat2 = $wisata->latitude ?? null;
            $lng2 = $wisata->longitude ?? null;

            if (is_null($lat2) || is_null($lng2)) {
                $wisata->distance = (float) ($wisata->distance ?? 0);
            } else {
                $wisata->distance = round(self::haversineDistance($userLat, $userLng, $lat2, $lng2), 2);
            }

            return $wisata;
        });
    }

    /**
     * Haversine formula to calculate distance between two lat/lng points in kilometers
     */
    private static function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // km

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $d = $earthRadius * $c;

        return $d;
    }

    private static function hasValidCoordinates($lat, $lng): bool
    {
        if (!is_numeric($lat) || !is_numeric($lng)) {
            return false;
        }

        $lat = (float) $lat;
        $lng = (float) $lng;

        return $lat >= -90 && $lat <= 90 && $lng >= -180 && $lng <= 180;
    }

    /**
     * Build decision matrix (wisata × kriteria)
     */
    private static function buildDecisionMatrix($wisatas, $criterias, $evaluations)
    {
        $matrix = [];

        // Hitung rata-rata rating wisata sebagai prior untuk Bayesian weighted rating
        $ratingCriteria = $criterias->firstWhere('code', 'C4');
        $ratingPrior = self::getRatingPriorValue(); // Ambil rata-rata rating wisata

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

                $value = $eval ? $eval->value : 0;

                if ($criteria->code === 'C2') {
                    $value = $wisata->distance ?? $value;
                }

                // Jika kriteria rating (C4), gunakan weighted rating dengan review_count dari database
                if ($criteria->code === 'C4' && $ratingCriteria) {
                    $R = $wisata->actual_rating ?? 0; // actual rating dari wisata
                    $v = $wisata->review_count ?? 0; // jumlah reviewer dari wisata
                    $m = 50; // minimumratings threshold untuk credibility (disesuaikan dengan data distribution)
                    $C = $ratingPrior; // prior netral rating pada skala 0-5

                    if ($v > 0) {
                        // Bayesian weighted rating:
                        // WR = (v/(v+m)) * R + (m/(v+m)) * C
                        // Dengan prior netral, wisata dengan rating sama tetapi review lebih banyak
                        // akan lebih cepat mendekati rating aslinya.
                        $value = ($v / ($v + $m)) * $R + ($m / ($v + $m)) * $C;
                    } else {
                        $value = $C; // jika tidak ada review, gunakan prior netral
                    }
                }

                $row['values'][$criteria->id] = [
                    'criteria_code' => $criteria->code,
                    'criteria_name' => $criteria->name,
                    'criteria_type' => $criteria->type,
                    'value' => $value,
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
                'distance' => (float) ($wisata->distance ?? 0),
                'actual_rating' => (float) ($wisata->actual_rating ?? 0),
                'review_count' => (int) ($wisata->review_count ?? 0),
                'score' => round($totalScore, 4),
                'score_details' => $scoreDetails,
            ]);
        }

        return $scores;
    }

    /**
     * Calculate average rating from all wisata as neutral prior.
     * If no wisata data, fallback to 2.5 (midpoint of 0-5 scale).
     */
    private static function getRatingPriorValue()
    {
        $averageRating = Wisata::where('actual_rating', '>', 0)->avg('actual_rating');

        // Jika tidak ada wisata dengan rating, gunakan midpoint
        if (is_null($averageRating) || $averageRating == 0) {
            return 2.5;
        }

        return round($averageRating, 2);
    }

    /**
     * Apply user filters to wisata collection
     */
    private static function applyFilters($wisatas, $filters)
    {
        return $wisatas->filter(function ($wisata) use ($filters) {
            // Filter: Kategori
            if (isset($filters['category_id']) && $filters['category_id'] > 0) {
                if ($wisata->category_id != $filters['category_id']) {
                    return false;
                }
            }

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

            // Filter: Fasilitas (harus memiliki semua fasilitas yang dipilih)
            if (isset($filters['facilities']) && is_array($filters['facilities']) && !empty($filters['facilities'])) {
                $wisataFacilities = $wisata->facilities ?? [];
                foreach ($filters['facilities'] as $requiredFacility) {
                    if (!in_array($requiredFacility, $wisataFacilities)) {
                        return false;
                    }
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

            if (isset($result['ranking'])) {
                $result['ranking'] = $result['ranking']->map(function ($item, $index) {
                    $item['rank'] = $index + 1;
                    return $item;
                });
            }

            return $result;
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }
}
