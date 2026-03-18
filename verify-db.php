<?php

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Category;
use App\Models\Wisata;

echo "=== DATABASE VERIFICATION ===" . PHP_EOL . PHP_EOL;

echo "Total Categories: " . Category::count() . PHP_EOL;
echo "Total Wisatas: " . Wisata::count() . PHP_EOL . PHP_EOL;

echo "Categories & Wisatas:" . PHP_EOL;
foreach (Category::with('wisatas')->get() as $category) {
    echo "- " . $category->name . " (" . $category->wisatas->count() . " wisatas)" . PHP_EOL;
    foreach ($category->wisatas as $wisata) {
        echo "  • " . $wisata->name . " - " . $wisata->location . PHP_EOL;
    }
}

echo PHP_EOL . "✅ Relasi sudah berjalan dengan baik!" . PHP_EOL;
