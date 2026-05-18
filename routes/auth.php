<?php

use App\Http\Controllers\Admin\AdminLoginController;
use Illuminate\Support\Facades\Route;

// Admin login routes only
Route::middleware('guest')->group(function () {
    Route::get('admin/login', [AdminLoginController::class, 'create'])->name('admin.login');
    Route::post('admin/login', [AdminLoginController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AdminLoginController::class, 'destroy'])->name('logout');
});

// User registration and login have been disabled - only admin can login
