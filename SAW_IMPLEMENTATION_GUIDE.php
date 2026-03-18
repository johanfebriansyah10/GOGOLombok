<?php

/**
 * CONTOH PENGGUNAAN SAW SYSTEM
 *
 * File ini menunjukkan bagaimana menggunakan Criteria dan Weight
 * untuk perhitungan SAW di langkah berikutnya.
 */

namespace App\Services;

use App\Models\Criteria;
use App\Models\Weight;
use Illuminate\Support\Collection;

class SAWCalculatorExample
{
    /**
     * Contoh 1: Ambil semua kriteria dengan bobotnya
     */
    public static function getAllCriteria()
    {
        return Criteria::with('weight')
            ->get()
            ->map(function ($criteria) {
                return [
                    'id' => $criteria->id,
                    'code' => $criteria->code,
                    'name' => $criteria->name,
                    'type' => $criteria->type,
                    'weight' => $criteria->weight?->weight ?? null,
                ];
            });
    }

    /**
     * Contoh 2: Validasi sebelum perhitungan
     */
    public static function isReadyForCalculation()
    {
        $totalCriteria = Criteria::count();
        $totalWeights = Weight::count();
        $isWeightValid = Weight::isWeightValid();

        return [
            'has_criteria' => $totalCriteria > 0,
            'all_weighted' => $totalCriteria === $totalWeights,
            'weight_valid' => $isWeightValid,
            'ready' => $totalCriteria > 0 && $totalCriteria === $totalWeights && $isWeightValid,
        ];
    }

    /**
     * Contoh 3: Persiapan data untuk normalisasi
     *
     * -- Struktur yang diperlukan untuk SAW:
     * -- Tabel alternatif (wisata) dengan ID
     * -- Tabel evaluasi: nilai setiap alternatif untuk setiap kriteria
     *
     * CREATE TABLE alternatives (
     *     id BIGINT UNSIGNED PRIMARY KEY,
     *     name VARCHAR(255),
     *     created_at TIMESTAMP
     * );
     *
     * CREATE TABLE evaluations (
     *     id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
     *     alternative_id BIGINT UNSIGNED,
     *     criteria_id BIGINT UNSIGNED,
     *     value DECIMAL(10, 2),
     *     FOREIGN KEY(alternative_id) REFERENCES alternatives(id),
     *     FOREIGN KEY(criteria_id) REFERENCES criterias(id)
     * );
     */

    /**
     * Contoh 4: Hitung normalisasi (benefit vs cost)
     */
    public static function normalizeValue($value, $criteria, $maxValue, $minValue)
    {
        if ($criteria->type === 'benefit') {
            // Benefit: Value / Max
            return $value / $maxValue;
        } else {
            // Cost: Min / Value
            return $minValue / $value;
        }
    }

    /**
     * Contoh 5: Hitung scoring (weighted sum)
     *
     * Score = Σ (Normalized Value × Weight)
     */
    public static function calculateScore($normalizedValues, $weights)
    {
        $score = 0;

        foreach ($normalizedValues as $criteriaId => $normalizedValue) {
            $weight = $weights[$criteriaId] ?? 0;
            $score += $normalizedValue * $weight;
        }

        return $score;
    }

    /**
     * Contoh 6: Full SAW Process (pseudocode)
     *
     * Step 1: Ambil data
     * $alternatives = Alternative::all();
     * $criterias = Criteria::with('weight')->get();
     * $evaluations = Evaluation::all();
     *
     * Step 2: Validasi
     * if (!Weight::isWeightValid()) {
     *     throw new Exception('Total bobot harus = 1');
     * }
     *
     * Step 3: Buat decision matrix
     * Alternatif × Kriteria = Nilai
     *
     * Step 4: Normalisasi
     * foreach ($evaluations as $eval) {
     *     $maxValue = Evaluation::where('criteria_id', $eval->criteria_id)->max('value');
     *     $minValue = Evaluation::where('criteria_id', $eval->criteria_id)->min('value');
     *     $normalized = normalizeValue($eval->value, $eval->criteria, $maxValue, $minValue);
     * }
     *
     * Step 5: Weighted scoring
     * foreach ($alternatives as $alt) {
     *     $score = 0;
     *     foreach ($alt->evaluations as $eval) {
     *         $weight = $eval->criteria->weight->weight;
     *         $score += $eval->normalized_value * $weight;
     *     }
     *     $alt->final_score = $score;
     * }
     *
     * Step 6: Sort dan ranking
     * $alternatives->sortByDesc('final_score');
     */
}

/**
 * QUERY CONTOH untuk pengembangan berikutnya
 */

/*
-- Dapatkan semua kriteria dengan bobotnya
SELECT c.id, c.code, c.name, c.type, w.weight
FROM criterias c
LEFT JOIN weights w ON c.id = w.criteria_id
ORDER BY c.id;

-- Check total weight
SELECT SUM(weight) as total_weight FROM weights;

-- Dapatkan evaluasi untuk normalisasi (min/max per kriteria)
SELECT
    criteria_id,
    MIN(value) as min_value,
    MAX(value) as max_value
FROM evaluations
GROUP BY criteria_id;

-- Normalisasi dan weighted scoring per alternatif
SELECT
    e1.alternative_id,
    a.name as alternative_name,
    SUM(
        CASE
            WHEN c.type = 'benefit'
            THEN (e1.value / (SELECT MAX(value) FROM evaluations WHERE criteria_id = e1.criteria_id)) * w.weight
            ELSE ((SELECT MIN(value) FROM evaluations WHERE criteria_id = e1.criteria_id) / e1.value) * w.weight
        END
    ) as final_score
FROM evaluations e1
JOIN alternatives a ON e1.alternative_id = a.id
JOIN criterias c ON e1.criteria_id = c.id
JOIN weights w ON c.id = w.criteria_id
GROUP BY e1.alternative_id
ORDER BY final_score DESC;
*/

/**
 * FILE-FILE YANG PERLU DIBUAT UNTUK SAW CALCULATION
 *
 * 1. Model/Alternative.php - untuk tabel alternatif
 * 2. Model/Evaluation.php - untuk tabel evaluasi
 * 3. Services/SAWCalculator.php - service untuk perhitungan
 * 4. Controllers/Admin/AlternativeController.php - CRUD alternatif
 * 5. Controllers/Admin/EvaluationController.php - CRUD evaluasi
 * 6. Views/admin/alternatives/* - views CRUD alternatif
 * 7. Views/admin/evaluations/* - views CRUD evaluasi
 * 8. Views/admin/results/* - views hasil ranking
 */

// ============================================
// KODE YANG BISA DIGUNAKAN SEKARANG
// ============================================

/**
 * Dalam Controller atau Service, gunakan:
 */
example_code:

// 1. Ambil kriteria dengan bobot
$criterias = Criteria::with('weight')->where('type', 'benefit')->get();

// 2. Hitung total bobot
$totalWeight = Weight::totalWeight();

// 3. Validasi
if (!Weight::isWeightValid()) {
    abort(422, 'Total bobot harus sama dengan 1');
}

// 4. Ambil kriteria berdasarkan tipe
$benefits = Criteria::where('type', 'benefit');
$costs = Criteria::where('type', 'cost');

// 5. Loop untuk akses bobot
foreach ($criterias as $criteria) {
    $code = $criteria->code;
    $weight = $criteria->weight->weight;
    echo "$code: $weight";
}
