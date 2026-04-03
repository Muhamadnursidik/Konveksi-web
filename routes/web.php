<?php

use App\Http\Controllers\Admin\BahanBakuController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\FinishingController;
use App\Http\Controllers\Admin\JobProduksiController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\ModelPakaianController;
use App\Http\Controllers\Admin\PemotongController;
use App\Http\Controllers\Admin\PenjahitController;
use App\Http\Controllers\Admin\ProdukJadiController;
use App\Http\Controllers\Finishing\DashboardController as FinishingDashboard;
use App\Http\Controllers\Finishing\JobFinishingController;
use App\Http\Controllers\Finishing\ProfileFinishingController;
use App\Http\Controllers\Pemotong\DashboardController as PemotongDashboard;
use App\Http\Controllers\Pemotong\DataBahanBakuController;
use App\Http\Controllers\Pemotong\JobPotongController;
use App\Http\Controllers\Pemotong\ProfilePemotongController;
use App\Http\Controllers\Penjahit\DashboardController as PenjahitDashboard;
use App\Http\Controllers\Penjahit\DataModelPakaianController;
use App\Http\Controllers\Penjahit\JobJahitController;
use App\Http\Controllers\Penjahit\ProfilePenjahitController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', fn() => redirect('/login'));

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', function () {
    $role = auth::user()->role;

    return match ($role) {
        'admin'     => redirect()->route('admin.dashboard'),
        'pemotong'  => redirect()->route('pemotong.dashboard'),
        'penjahit'  => redirect()->route('penjahit.dashboard'),
        'finishing' => redirect()->route('finishing.dashboard'),
        default     => abort(403),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/notif/read/{id}', function ($id) {
        \App\Models\Notifikasi::where('id', $id)
            ->where('user_id', auth()->id())
            ->update(['is_read' => true]);

        return back();
    })->name('notif.read');

    Route::post('/notif/read-all', function () {
        \App\Models\Notifikasi::where('user_id', auth()->id())
            ->update(['is_read' => true]);

        return back();
    })->name('notif.readAll');
});

Route::middleware([])
    ->prefix('admin')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
        Route::resource('pemotong', PemotongController::class)->names('admin.pemotong');
        Route::resource('penjahit', PenjahitController::class)->names('admin.penjahit');
        Route::resource('finishing', FinishingController::class)->names('admin.finishing');
        Route::resource('bahan-baku', BahanBakuController::class)->names('admin.bahan-baku');
        Route::resource('model-pakaian', ModelPakaianController::class)->names('admin.model-pakaian');
        Route::resource('job-produksi', JobProduksiController::class)->names('admin.job-produksi');
        Route::get('/admin/job-produksi/table', [JobProduksiController::class, 'table'])->name('admin.job-produksi.table');
        Route::get('produk-jadi', [ProdukJadiController::class, 'index'])->name('admin.produk-jadi');
        Route::get('produk-jadi/{produkJadi}', [ProdukJadiController::class, 'show'])->name('admin.produk-jadi.show');
        Route::post('job-produksi/{job}/acc-pemotongan', [JobProduksiController::class, 'accPemotongan'])->name('admin.job-produksi.acc-pemotongan');
        Route::post('job-produksi/{job}/acc-penjahitan', [JobProduksiController::class, 'accPenjahitan'])->name('admin.job-produksi.acc-penjahitan');
        Route::post('job-produksi/{job}/acc-finishing', [JobProduksiController::class, 'accFinishing'])->name('admin.job-produksi.acc-finishing');

        // Laporan
        Route::get('/Laporan/produksi', [LaporanController::class, 'produksi'])->name('laporan.produksi');
        Route::get('/admin/laporan/produksi/excel', [LaporanController::class, 'exportExcel'])->name('laporan.produksi.excel');
        Route::get('/admin/laporan/produksi/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.produksi.pdf');

        Route::get('/Laporan/bahan-baku', [LaporanController::class, 'bahanBaku'])->name('laporan.bahan-baku');
        Route::get('/admin/laporan/bahan-baku/excel', [LaporanController::class, 'exportBahanBakuExcel'])->name('laporan.bahan-baku.excel');
        Route::get('/admin/laporan/bahan-baku/pdf', [LaporanController::class, 'exportBahanBakuPdf'])->name('laporan.bahan-baku.pdf');

        Route::get('/Laporan/produk-jadi', [LaporanController::class, 'produkJadi'])->name('laporan.produk-jadi');
        Route::get('/laporan/produk-jadi/excel', [LaporanController::class, 'exportProdukJadiExcel'])->name('laporan.produk-jadi.excel');
        Route::get('/laporan/produk-jadi/pdf', [LaporanController::class, 'exportProdukJadiPdf'])->name('laporan.produk-jadi.pdf');

    });

Route::middleware(['auth', 'role:pemotong'])
    ->prefix('pemotong')
    ->group(function () {
        Route::get('/dashboard', [PemotongDashboard::class, 'index'])->name('pemotong.dashboard');
        Route::resource('data-bahan-baku', DataBahanBakuController::class)->names('pemotong.data-bahan-baku');
        Route::get('/job-potong', [JobPotongController::class, 'index'])->name('pemotong.job-potong.index');
        Route::post('/job-potong/{job}/selesai', [JobPotongController::class, 'selesai'])->name('pemotong.job-potong.selesai');
        Route::get('/riwayat-potong', [JobPotongController::class, 'riwayat'])->name('pemotong.job-potong.riwayat');
        Route::get('/job-potong/table', [JobPotongController::class, 'table'])->name('pemotong.job.table');
        Route::get('profile', [ProfilePemotongController::class, 'index'])->name('pemotong.profile');
        Route::get('profile/{id}/edit', [ProfilePemotongController::class, 'edit'])->name('pemotong.profile.edit');
        Route::put('profile/{id}', [ProfilePemotongController::class, 'update'])->name('pemotong.profile.update');
    });

Route::middleware(['auth', 'role:penjahit'])
    ->prefix('penjahit')
    ->group(function () {
        Route::get('/dashboard', [PenjahitDashboard::class, 'index'])->name('penjahit.dashboard');
        Route::resource('data-model-pakaian', DataModelPakaianController::class)->names('penjahit.data-model-pakaian');
        Route::get('/job-jahit', [JobJahitController::class, 'index'])->name('penjahit.job-jahit.index');
        Route::post('/job-jahit/{job}/selesai', [JobJahitController::class, 'selesai'])->name('penjahit.job-jahit.selesai');
        Route::get('/riwayat-jahit', [JobJahitController::class, 'riwayat'])->name('penjahit.job-jahit.riwayat');
        Route::get('/job-jahit/table', [JobJahitController::class, 'table'])->name('penjahit.job.table');
        Route::get('profile', [ProfilePenjahitController::class, 'index'])->name('penjahit.profile');
        Route::get('profile/{id}/edit', [ProfilePenjahitController::class, 'edit'])->name('penjahit.profile.edit');
        Route::put('profile/{id}', [ProfilePenjahitController::class, 'update'])->name('penjahit.profile.update');
    });

Route::middleware(['auth', 'role:finishing'])
    ->prefix('finishing')
    ->group(function () {
        Route::get('/dashboard', [FinishingDashboard::class, 'index'])->name('finishing.dashboard');
        Route::get('/job-finishing', [JobFinishingController::class, 'index'])->name('finishing.job-finishing.index');
        Route::post('/job-finishing/{job}/selesai', [JobFinishingController::class, 'selesai'])->name('finishing.job-finishing.selesai');
        Route::get('/riwayat-finishing', [JobFinishingController::class, 'riwayat'])->name('finishing.job-finishing.riwayat');
        Route::get('/job-finishing/table', [JobFinishingController::class, 'table'])->name('finishing.job.table');
        Route::get('profile', [ProfileFinishingController::class, 'index'])->name('finishing.profile');
        Route::get('profile/{id}/edit', [ProfileFinishingController::class, 'edit'])->name('finishing.profile.edit');
        Route::put('profile/{id}', [ProfileFinishingController::class, 'update'])->name('finishing.profile.update');
    });

require __DIR__ . '/auth.php';
