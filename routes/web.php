<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CriteriaController;
use App\Http\Controllers\Admin\EvaluationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WisataController;
use App\Http\Controllers\Admin\WeightController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\SAWResultController;
use App\Http\Controllers\WisataController as UserWisataController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/landing', fn() => view('landing'))->name('landing');
Route::get('/', [DashboardController::class, 'show'])->name('dashboard');
Route::get('/saw/recommendations', [RecommendationController::class, 'index'])->name('saw.recommendations.index');
Route::get('/saw/recommendations/reset', [RecommendationController::class, 'reset'])->name('saw.recommendations.reset');
Route::get('/saw/ranking', [SAWResultController::class, 'index'])->name('saw.results.index');
Route::redirect('/saw/results', '/saw/ranking');
Route::get('/wisata', [UserWisataController::class, 'catalog'])->name('wisata.catalog');
Route::get('/wisata/{id}', [UserWisataController::class, 'show'])->name('wisata.show');


// Admin Dashboard - only for admins
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'show'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('wisatas', WisataController::class);

    // Criteria & Weight (Combined)
    Route::resource('criterias', CriteriaController::class);
    Route::get('/criterias-weight/create-weight', [CriteriaController::class, 'createWeight'])->name('criterias.create-weight');
    Route::post('/criterias-weight/store-weight', [CriteriaController::class, 'storeWeight'])->name('criterias.store-weight');
    Route::get('/criterias-weight/{weight}/edit-weight', [CriteriaController::class, 'editWeight'])->name('criterias.edit-weight');
    Route::patch('/criterias-weight/{weight}/update-weight', [CriteriaController::class, 'updateWeight'])->name('criterias.update-weight');
    Route::delete('/criterias-weight/{weight}/destroy-weight', [CriteriaController::class, 'destroyWeight'])->name('criterias.destroy-weight');

    // Weights (Bobot Kategori)
    Route::resource('weights', WeightController::class);

    Route::resource('users', UserController::class);
    Route::get('/evaluations', [EvaluationController::class, 'index'])->name('evaluations.index');
    Route::post('/evaluations', [EvaluationController::class, 'store'])->name('evaluations.store');
    Route::post('/evaluations/populate', [EvaluationController::class, 'populate'])->name('evaluations.populate');
    Route::delete('/evaluations/{evaluation}', [EvaluationController::class, 'destroy'])->name('evaluations.destroy');
});


// Utility routes for hosting deployment (without SSH)
Route::prefix('sys-utility')->group(function () {
    Route::get('/storage-link', function () {
        if (request('token') !== env('SYS_UTIL_TOKEN', 'skripsi-secret-123')) {
            abort(403, 'Unauthorized. Silakan gunakan token yang benar.');
        }
        try {
            Illuminate\Support\Facades\Artisan::call('storage:link');
            return 'Storage link berhasil dibuat!';
        } catch (\Exception $e) {
            return 'Gagal membuat storage link: ' . $e->getMessage();
        }
    });

    Route::get('/migrate', function () {
        if (request('token') !== env('SYS_UTIL_TOKEN', 'skripsi-secret-123')) {
            abort(403, 'Unauthorized. Silakan gunakan token yang benar.');
        }
        try {
            Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            return 'Migrasi database berhasil dijalankan!';
        } catch (\Exception $e) {
            return 'Gagal melakukan migrasi: ' . $e->getMessage();
        }
    });
});

require __DIR__ . '/auth.php';

