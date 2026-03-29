<?php

namespace Database\Seeders;

use App\Models\Criteria;
use App\Models\Evaluation;
use App\Models\Wisata;
use Illuminate\Database\Seeder;

class EvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $requiredCriteriaCodes = ['C1', 'C2', 'C3', 'C4'];
        $criteriaIds = Criteria::whereIn('code', $requiredCriteriaCodes)
            ->pluck('id', 'code');

        $missingCriteriaCodes = array_diff($requiredCriteriaCodes, $criteriaIds->keys()->all());

        if ($missingCriteriaCodes !== []) {
            throw new \RuntimeException(
                'Criteria berikut belum tersedia: ' . implode(', ', $missingCriteriaCodes)
            );
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
}
