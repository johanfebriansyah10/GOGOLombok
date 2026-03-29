<?php

namespace Database\Seeders;

use App\Models\Criteria;
use Illuminate\Database\Seeder;

class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $criterias = [
            [
                'code' => 'C1',
                'name' => 'Harga Tiket',
                'type' => 'cost',
                'description' => 'Harga tiket masuk (semakin rendah semakin baik)',
            ],
            [
                'code' => 'C2',
                'name' => 'Jarak',
                'type' => 'cost',
                'description' => 'Jarak dari pusat kota (semakin dekat semakin baik)',
            ],
            [
                'code' => 'C3',
                'name' => 'Fasilitas',
                'type' => 'benefit',
                'description' => 'Ketersediaan fasilitas lengkap (restoran, toilet, parkir, dll)',
            ],
            [
                'code' => 'C4',
                'name' => 'Rating',
                'type' => 'benefit',
                'description' => 'Rating/ulasan dari pengunjung',
            ],
        ];

        foreach ($criterias as $criteria) {
            Criteria::updateOrCreate(
                ['code' => $criteria['code']],
                $criteria
            );
        }
    }
}
