<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FinishingController;
use App\Http\Controllers\Api\NotifikasiController;
use App\Http\Controllers\Api\PemotongController;
use App\Http\Controllers\Api\PenjahitController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

});

// Public
Route::post('/login', [AuthController::class, 'login']);
Route::get('/user/photo/{filename}', function ($filename) {
    $path = storage_path('app/public/users/' . $filename);

    if (! file_exists($path)) {
        abort(404);
    }

    return response()->file($path, [
        'Access-Control-Allow-Origin'  => '*',
        'Access-Control-Allow-Methods' => 'GET',
        'Access-Control-Allow-Headers' => '*',
    ]);
});
// Protected
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::post('/profile', [ProfileController::class, 'update']);

    Route::prefix('notifikasi')->group(function () {
        Route::get('/', [NotifikasiController::class, 'index']);
        Route::post('/{id}/read', [NotifikasiController::class, 'read']);
        Route::post('/read-all', [NotifikasiController::class, 'readAll']);
    });

    // Pemotong
    Route::prefix('pemotong')->group(function () {
        Route::get('/jobs', [PemotongController::class, 'jobs']);
        Route::post('/jobs/{id}/selesai', [PemotongController::class, 'selesai']);
        Route::get('/riwayat', [PemotongController::class, 'riwayat']);
        Route::get('/stats', [PemotongController::class, 'stats']);
        Route::get('/bahan-baku', [PemotongController::class, 'bahanBaku']);
    });

    // routes/api.php — tambah di dalam middleware auth:sanctum
    Route::prefix('penjahit')->group(function () {
        Route::get('/stats', [PenjahitController::class, 'stats']);
        Route::get('/jobs', [PenjahitController::class, 'jobs']);
        Route::post('/jobs/{id}/selesai', [PenjahitController::class, 'selesai']);
        Route::get('/riwayat', [PenjahitController::class, 'riwayat']);
        Route::get('/model-pakaian', [PenjahitController::class, 'modelPakaian']);
    });

    // routes/api.php — tambah di dalam middleware auth:sanctum
    Route::prefix('finishing')->group(function () {
        Route::get('/stats', [FinishingController::class, 'stats']);
        Route::get('/jobs', [FinishingController::class, 'jobs']);
        Route::post('/jobs/{id}/selesai', [FinishingController::class, 'selesai']);
        Route::get('/riwayat', [FinishingController::class, 'riwayat']);
    });

});
