<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Wisata;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories
        $categories = [
            [
                'name' => 'Pantai',
                'description' => 'Objek wisata pantai dengan pasir putih dan laut biru'
            ],
            [
                'name' => 'Gunung',
                'description' => 'Destinasi wisata pegunungan untuk pendaki dan pencinta alam'
            ],
            [
                'name' => 'Budaya',
                'description' => 'Tempat bersejarah dan warisan budaya Indonesia'
            ],
            [
                'name' => 'Air Terjun',
                'description' => 'Objek wisata air terjun yang indah dan menyegarkan'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create wisatas for each category
        $wisataData = [
            'Pantai' => [
                [
                    'name' => 'Pantai Kuta',
                    'description' => 'Pantai terkenal dengan ombak yang cocok untuk surfing',
                    'location' => 'Bali',
                    'address' => 'Jl. Pantai Kuta, Kuta, Bali',
                    'latitude' => -8.7211,
                    'longitude' => 115.1692,
                    'rating' => 4
                ],
                [
                    'name' => 'Pantai Seminyak',
                    'description' => 'Pantai yang terkenal dengan sunset yang memukau',
                    'location' => 'Bali',
                    'address' => 'Jl. Pantai Seminyak, Seminyak, Bali',
                    'latitude' => -8.6953,
                    'longitude' => 115.1691,
                    'rating' => 5
                ],
                [
                    'name' => 'Pantai Parangtritis',
                    'description' => 'Pantai lama dengan pasir hitam vulkanis dan pemandangan laut yang memukau',
                    'location' => 'Yogyakarta',
                    'address' => 'Kraton, Yogyakarta',
                    'latitude' => -7.8106,
                    'longitude' => 110.3637,
                    'rating' => 4
                ]
            ],
            'Gunung' => [
                [
                    'name' => 'Gunung Bromo',
                    'description' => 'Gunung berapi aktif dengan pemandangan yang spektakuler',
                    'location' => 'Jawa Timur',
                    'address' => 'Cemoro Lawang, Probolinggo, Jawa Timur',
                    'latitude' => -7.9427,
                    'longitude' => 112.9529,
                    'rating' => 5
                ],
                [
                    'name' => 'Gunung Rinjani',
                    'description' => 'Gunung tertinggi di Lombok dengan danau segara anak yang menakjubkan',
                    'location' => 'Nusa Tenggara Barat',
                    'address' => 'Sembalun, Lombok, NTB',
                    'latitude' => -8.4077,
                    'longitude' => 116.3842,
                    'rating' => 4
                ]
            ],
            'Budaya' => [
                [
                    'name' => 'Candi Borobudur',
                    'description' => 'Candi budha terbesar di dunia dengan arsitektur megah',
                    'location' => 'Jawa Tengah',
                    'address' => 'Magelang, Jawa Tengah',
                    'latitude' => -7.6079,
                    'longitude' => 110.2038,
                    'rating' => 5
                ],
                [
                    'name' => 'Candi Prambanan',
                    'description' => 'Candi Hindu terbesar di Indonesia dengan tiga menara utama',
                    'location' => 'Jawa Tengah',
                    'address' => 'Yogyakarta, Jawa Tengah',
                    'latitude' => -7.7520,
                    'longitude' => 110.4924,
                    'rating' => 5
                ],
                [
                    'name' => 'Istana Maimun',
                    'description' => 'Istana bersejarah yang menampilkan arsitektur Melayu klasik',
                    'location' => 'Sumatera Utara',
                    'address' => 'Medan, Sumatera Utara',
                    'latitude' => 3.1955,
                    'longitude' => 98.6722,
                    'rating' => 4
                ]
            ],
            'Air Terjun' => [
                [
                    'name' => 'Air Terjun Tegenungan',
                    'description' => 'Air terjun yang indah dekat dengan Ubud',
                    'location' => 'Bali',
                    'address' => 'Tegenungan, Ubud, Bali',
                    'latitude' => -8.5119,
                    'longitude' => 115.2619,
                    'rating' => 4
                ],
                [
                    'name' => 'Air Terjun Niagara Curug Cilember',
                    'description' => 'Air terjun yang eksotis dengan 7 tingkatan panorama indah',
                    'location' => 'Jawa Barat',
                    'address' => 'Bogor, Jawa Barat',
                    'latitude' => -6.7549,
                    'longitude' => 107.0054,
                    'rating' => 4
                ]
            ]
        ];

        foreach ($wisataData as $categoryName => $wisatas) {
            $category = Category::where('name', $categoryName)->first();
            foreach ($wisatas as $wisata) {
                $category->wisatas()->create($wisata);
            }
        }
    }
}
