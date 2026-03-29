<?php

namespace Database\Seeders;

use App\Models\Wisata;
use Illuminate\Database\Seeder;

class WisataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = \App\Models\Category::where('name', 'Alam')->first();

        if (!$category) {
            $category = \App\Models\Category::create([
                'name' => 'Alam',
                'description' => 'Wisata alam dan outdoor',
            ]);
        }

        $wisatas = [
            [
                'category_id' => $category->id,
                'name' => 'Taman Hiburan Jaya',
                'description' => 'Taman hiburan dengan berbagai permainan dan wahana seru untuk keluarga',
                'location' => 'Jakarta Timur',
                'address' => 'Jl. Raya Timur No. 123, Jakarta',
                'latitude' => -6.1751,
                'longitude' => 106.8650,
                'rating' => 85,
                'ticket_price' => 150000,      // 150rb
                'distance' => 15.5,            // 15.5 km
                'facilities_count' => 12,      // 12 fasilitas
                'actual_rating' => 4.5,        // 4.5 dari 5
            ],
            [
                'category_id' => $category->id,
                'name' => 'Pantai Pasir Putih',
                'description' => 'Pantai indah dengan pasir putih dan air kristal',
                'location' => 'Tangerang',
                'address' => 'Jl. Pantai Raya No. 45, Tangerang',
                'latitude' => -6.3000,
                'longitude' => 106.5800,
                'rating' => 90,
                'ticket_price' => 50000,       // 50rb
                'distance' => 45.2,            // 45.2 km
                'facilities_count' => 8,       // 8 fasilitas
                'actual_rating' => 4.7,        // 4.7 dari 5
            ],
            [
                'category_id' => $category->id,
                'name' => 'Gunung Bromo Experience',
                'description' => 'Pengalaman mendaki gunung dengan pemandangan spektakuler',
                'location' => 'Probolinggo',
                'address' => 'Desa Cemoro Lawang, Probolinggo',
                'latitude' => -7.9424,
                'longitude' => 112.9511,
                'rating' => 92,
                'ticket_price' => 200000,      // 200rb
                'distance' => 250.0,           // 250 km
                'facilities_count' => 6,       // 6 fasilitas
                'actual_rating' => 4.8,        // 4.8 dari 5
            ],
            [
                'category_id' => $category->id,
                'name' => 'Kebun Binatang Metropolitan',
                'description' => 'Kebun binatang modern dengan koleksi hewan lengkap',
                'location' => 'Jakarta Selatan',
                'address' => 'Jl. Cikini Raya No. 73, Jakarta',
                'latitude' => -6.2086,
                'longitude' => 106.8000,
                'rating' => 88,
                'ticket_price' => 175000,      // 175rb
                'distance' => 8.3,             // 8.3 km
                'facilities_count' => 15,      // 15 fasilitas
                'actual_rating' => 4.6,        // 4.6 dari 5
            ],
            [
                'category_id' => $category->id,
                'name' => 'Danau Toba Resort',
                'description' => 'Resort mewah di pinggir danau toba dengan pemandangan indah',
                'location' => 'Sumatera Utara',
                'address' => 'Jl. Danau Toba No. 1, Parapat',
                'latitude' => 2.6900,
                'longitude' => 98.8800,
                'rating' => 95,
                'ticket_price' => 300000,      // 300rb
                'distance' => 350.0,           // 350 km
                'facilities_count' => 18,      // 18 fasilitas
                'actual_rating' => 4.9,        // 4.9 dari 5
            ],
            [
                'category_id' => $category->id,
                'name' => 'Taman Nasional Ujung Kulon',
                'description' => 'Taman nasional dengan keanekaragaman hayati tinggi',
                'location' => 'Banten',
                'address' => 'Pelabuhanratu, Banten',
                'latitude' => -6.7833,
                'longitude' => 105.3167,
                'rating' => 87,
                'ticket_price' => 225000,      // 225rb
                'distance' => 180.0,           // 180 km
                'facilities_count' => 9,       // 9 fasilitas
                'actual_rating' => 4.4,        // 4.4 dari 5
            ],
            [
                'category_id' => $category->id,
                'name' => 'Taman Bunga Bogor',
                'description' => 'Kebun bunga cantik dengan berbagai koleksi tanaman eksotis',
                'location' => 'Bogor',
                'address' => 'Jl. Ir. Sutami No. 188, Bogor',
                'latitude' => -6.5971,
                'longitude' => 106.8060,
                'rating' => 84,
                'ticket_price' => 25000,       // 25rb (murah!)
                'distance' => 60.0,            // 60 km
                'facilities_count' => 7,       // 7 fasilitas
                'actual_rating' => 4.3,        // 4.3 dari 5
            ],
            [
                'category_id' => $category->id,
                'name' => 'Pulau Seribu Paradise',
                'description' => 'Paket wisata pulau dengan snorkeling dan diving',
                'location' => 'Jakarta Utara',
                'address' => 'Marina Ancol, Jakarta',
                'latitude' => -6.1200,
                'longitude' => 106.8350,
                'rating' => 91,
                'ticket_price' => 500000,      // 500rb (mahal)
                'distance' => 25.0,            // 25 km
                'facilities_count' => 14,      // 14 fasilitas
                'actual_rating' => 4.8,        // 4.8 dari 5
            ],
            [
                'category_id' => $category->id,
                'name' => 'Rumah Tepi Sungai Heritage',
                'description' => 'Tempat bersejarah dengan arsitektur tradisional',
                'location' => 'Jakarta Kota',
                'address' => 'Gang Pokrol No. 34, Jakarta',
                'latitude' => -6.1349,
                'longitude' => 106.8091,
                'rating' => 82,
                'ticket_price' => 100000,      // 100rb
                'distance' => 12.0,            // 12 km
                'facilities_count' => 5,       // 5 fasilitas (minim)
                'actual_rating' => 4.2,        // 4.2 dari 5
            ],
            [
                'category_id' => $category->id,
                'name' => 'Kawah Ijen Expedition',
                'description' => 'Pendakian ke gunung berapi dengan api biru yang spektakuler',
                'location' => 'Banyuwangi',
                'address' => 'Desa Paltuding, Banyuwangi',
                'latitude' => -8.0506,
                'longitude' => 114.2400,
                'rating' => 94,
                'ticket_price' => 150000,      // 150rb
                'distance' => 230.0,           // 230 km
                'facilities_count' => 7,       // 7 fasilitas
                'actual_rating' => 4.7,        // 4.7 dari 5
            ],
        ];

        foreach ($wisatas as $wisata) {
            Wisata::create($wisata);
        }
    }
}
