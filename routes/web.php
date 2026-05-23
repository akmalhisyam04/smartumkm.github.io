<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DetailTransaksiController;
use App\Http\Controllers\PergerakanStokController;
use App\Http\Controllers\LaporanPenjualanController;
use App\Http\Controllers\DashboardController;

// ======================================================
// LOGIN
// ======================================================

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/proses-login', [LoginController::class, 'prosesLogin'])->name('proses-login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ======================================================
// DASHBOARD (pakai controller, bukan closure)
// ======================================================

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth.session')
    ->name('dashboard');

// ======================================================
// ADMIN ONLY
// ======================================================

Route::middleware(['role:admin'])->group(function () {
    Route::resource('user', UserController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('produk', ProdukController::class);
    Route::resource('stok', PergerakanStokController::class);

    // Tambahkan route khusus untuk melihat histori stok per produk
    Route::get('/stok-produk/{id_produk}', [PergerakanStokController::class, 'showByProduk'])
        ->name('stok.produk');
});

// ======================================================
// KASIR & ADMIN (transaksi bisa diakses keduanya)
// ======================================================

Route::middleware(['role:kasir,admin'])->group(function () {
    Route::resource('transaksi', TransaksiController::class);
    Route::resource('detail-transaksi', DetailTransaksiController::class);
});

// ======================================================
// ADMIN & PEMILIK
// ======================================================

Route::middleware(['role:admin,pemilik'])->group(function () {
    Route::get('/laporan', [LaporanPenjualanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export/excel', [LaporanPenjualanController::class, 'exportExcel'])->name('laporan.export.excel');
});