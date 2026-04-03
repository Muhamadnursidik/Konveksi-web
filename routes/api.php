<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PemotongController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

});

// Public
Route::post('/login', [AuthController::class, 'login']);

// Protected
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // Pemotong
    Route::prefix('pemotong')->group(function () {
        Route::get('/jobs',               [PemotongController::class, 'jobs']);
        Route::post('/jobs/{id}/selesai', [PemotongController::class, 'selesai']);
        Route::get('/riwayat',            [PemotongController::class, 'riwayat']);
    });

});
