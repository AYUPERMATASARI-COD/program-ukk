<?php

use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KendaraanController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\TarifController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\Owner\LaporanController as OwnerLaporanController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Petugas\TransaksiController as PetugasTransaksiController;
use Illuminate\Support\Facades\Route;

// ===== HALAMAN AWAL =====
Route::get('/', function () {
    return redirect()->route('login');
});

// ===== AUTH =====
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===== ADMIN =====
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('user', UserController::class)->except('show');
    Route::resource('tarif', TarifController::class)->except('show');
    Route::resource('area', AreaController::class)->except('show');
    Route::resource('kendaraan', KendaraanController::class)->except('show');
    Route::get('/log', [LogController::class, 'index'])->name('log.index');
});

// ===== PETUGAS =====
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasDashboardController::class, 'index'])->name('dashboard');
    Route::get('/transaksi/masuk', [PetugasTransaksiController::class, 'create'])->name('transaksi.masuk');
    Route::post('/transaksi/masuk', [PetugasTransaksiController::class, 'store'])->name('transaksi.masuk.store');
    Route::get('/transaksi/keluar', [PetugasTransaksiController::class, 'keluar'])->name('transaksi.keluar');
    Route::post('/transaksi/keluar/id', [PetugasTransaksiController::class, 'prosesKeluarDenganId'])->name('transaksi.keluar.id');
    Route::post('/transaksi/keluar/{transaksi}', [PetugasTransaksiController::class, 'prosesKeluar'])->name('transaksi.keluar.proses');
    Route::get('/transaksi/{transaksi}/cetak', [PetugasTransaksiController::class, 'cetak'])->name('transaksi.cetak');
});

// ===== OWNER =====
Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/laporan', [OwnerLaporanController::class, 'index'])->name('laporan.index');
});
