<?php

namespace Database\Seeders;

use App\Models\Evaluation;
use Illuminate\Database\Seeder;

class EvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample evaluation data
        // Wisata IDs: 1-5
        // Criteria IDs: 7-10 (C1: Harga Tiket, C2: Jarak, C3: Fasilitas, C4: Rating)

        $evaluations = [
            // Wisata 1 (Taman Nasional)
            ['wisata_id' => 1, 'criteria_id' => 7, 'value' => 50000],   // Harga Tiket (cost - lower is better)
            ['wisata_id' => 1, 'criteria_id' => 8, 'value' => 25],       // Jarak km (cost - lower is better)
            ['wisata_id' => 1, 'criteria_id' => 9, 'value' => 85],       // Fasilitas (benefit - higher is better)
            ['wisata_id' => 1, 'criteria_id' => 10, 'value' => 4.5],     // Rating (benefit)

            // Wisata 2 (Pantai)
            ['wisata_id' => 2, 'criteria_id' => 7, 'value' => 30000],
            ['wisata_id' => 2, 'criteria_id' => 8, 'value' => 15],
            ['wisata_id' => 2, 'criteria_id' => 9, 'value' => 80],
            ['wisata_id' => 2, 'criteria_id' => 10, 'value' => 4.2],

            // Wisata 3 (Candi)
            ['wisata_id' => 3, 'criteria_id' => 7, 'value' => 25000],
            ['wisata_id' => 3, 'criteria_id' => 8, 'value' => 10],
            ['wisata_id' => 3, 'criteria_id' => 9, 'value' => 75],
            ['wisata_id' => 3, 'criteria_id' => 10, 'value' => 4.7],

            // Wisata 4 (Gunung)
            ['wisata_id' => 4, 'criteria_id' => 7, 'value' => 40000],
            ['wisata_id' => 4, 'criteria_id' => 8, 'value' => 35],
            ['wisata_id' => 4, 'criteria_id' => 9, 'value' => 70],
            ['wisata_id' => 4, 'criteria_id' => 10, 'value' => 4.0],

            // Wisata 5 (Air Terjun)
            ['wisata_id' => 5, 'criteria_id' => 7, 'value' => 35000],
            ['wisata_id' => 5, 'criteria_id' => 8, 'value' => 20],
            ['wisata_id' => 5, 'criteria_id' => 9, 'value' => 90],
            ['wisata_id' => 5, 'criteria_id' => 10, 'value' => 4.8],
        ];

        foreach ($evaluations as $evaluation) {
            Evaluation::create($evaluation);
        }
    }
}
