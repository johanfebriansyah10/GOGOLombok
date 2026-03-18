<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('wisatas', function (Blueprint $table) {
            // Budget/Harga tiket masuk
            $table->decimal('ticket_price', 10, 2)->default(0)->after('location')->comment('Harga tiket masuk');

            // Jarak dari pusat kota (dalam km)
            $table->decimal('distance', 8, 2)->default(0)->after('ticket_price')->comment('Jarak dari pusat kota (km)');

            // Jumlah fasilitas tersedia (restoran, toilet, parkir, dll)
            $table->integer('facilities_count')->default(0)->after('distance')->comment('Jumlah fasilitas tersedia');

            // Rating actual dari data wisata (bukan dari SAW)
            $table->decimal('actual_rating', 3, 2)->default(0)->after('rating')->comment('Rating aktual wisata (0-5)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wisatas', function (Blueprint $table) {
            $table->dropColumn(['ticket_price', 'distance', 'facilities_count', 'actual_rating']);
        });
    }
};
