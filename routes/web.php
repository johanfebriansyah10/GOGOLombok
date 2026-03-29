<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use Illuminate\Support\Facades\Route;

// User Dashboard - only for users
Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');
});

// Wisata Catalog & Details - accessible to all authenticated users
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/wisata', [\App\Http\Controllers\WisataController::class, 'catalog'])->name('wisata.catalog');
    Route::get('/wisata/{id}', [\App\Http\Controllers\WisataController::class, 'show'])->name('wisata.show');
});

// SAW Results - accessible to all authenticated users
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/saw/recommendations', [\App\Http\Controllers\RecommendationController::class, 'index'])->name('saw.recommendations.index');
    Route::get('/saw/recommendations/reset', [\App\Http\Controllers\RecommendationController::class, 'reset'])->name('saw.recommendations.reset');
    Route::get('/saw/results', [\App\Http\Controllers\SAWResultController::class, 'index'])->name('saw.results.index');
    Route::get('/saw/results/analysis/transparent', [\App\Http\Controllers\SAWResultController::class, 'analysis'])->name('saw.results.analysis');
    Route::get('/saw/results/{wisataId}', [\App\Http\Controllers\SAWResultController::class, 'detail'])->name('saw.results.detail');
});

// Admin Dashboard - only for admins
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'show'])->name('dashboard');
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('wisatas', \App\Http\Controllers\Admin\WisataController::class);
    Route::resource('criterias', \App\Http\Controllers\Admin\CriteriaController::class);
    Route::resource('weights', \App\Http\Controllers\Admin\WeightController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::get('/evaluations', [\App\Http\Controllers\Admin\EvaluationController::class, 'index'])->name('evaluations.index');
    Route::post('/evaluations', [\App\Http\Controllers\Admin\EvaluationController::class, 'store'])->name('evaluations.store');
    Route::delete('/evaluations/{evaluation}', [\App\Http\Controllers\Admin\EvaluationController::class, 'destroy'])->name('evaluations.destroy');
    Route::post('/evaluations/import', [\App\Http\Controllers\Admin\EvaluationController::class, 'import'])->name('evaluations.import');
});

// Profile routes - for all authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
