<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClusteringController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RondaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WargaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Modul Data Warga (Semua peran dapat melihat data warga & cetak laporan)
    Route::get('warga/export-pdf', [WargaController::class, 'exportPdf'])->name('warga.exportPdf');
    Route::get('warga/export-excel', [WargaController::class, 'exportExcel'])->name('warga.exportExcel');
    Route::get('warga', [WargaController::class, 'index'])->name('warga.index');

    // Ketua RT & Admin Superadmin: Mengelola Data Master Warga (Tambah, Edit, Hapus) - PRD Section 2
    Route::middleware('role:admin,ketua_rt')->group(function () {
        Route::get('warga/create', [WargaController::class, 'create'])->name('warga.create');
        Route::post('warga', [WargaController::class, 'store'])->name('warga.store');
        Route::get('warga/{warga}/edit', [WargaController::class, 'edit'])->name('warga.edit');
        Route::put('warga/{warga}', [WargaController::class, 'update'])->name('warga.update');
        Route::patch('warga/{warga}', [WargaController::class, 'update']);
        Route::delete('warga/{warga}', [WargaController::class, 'destroy'])->name('warga.destroy');
    });

    // Detail Warga (diletakkan setelah warga/create agar tidak tertangkap oleh wildcard {warga})
    Route::get('warga/{warga}', [WargaController::class, 'show'])->name('warga.show');

    // Modul Mesin Algoritma K-Means Clustering (Ketua RT & Admin Superadmin) - PRD Section 2 & 3
    Route::middleware('role:admin,ketua_rt')->group(function () {
        Route::get('clustering', [ClusteringController::class, 'index'])->name('clustering.index');
        Route::post('clustering/run', [ClusteringController::class, 'run'])->name('clustering.run');
        Route::get('clustering/{session}', [ClusteringController::class, 'show'])->name('clustering.show');
        Route::get('clustering/{session}/export-pdf', [ClusteringController::class, 'exportPdf'])->name('clustering.exportPdf');
        Route::get('clustering/{session}/export-excel', [ClusteringController::class, 'exportExcel'])->name('clustering.exportExcel');
        Route::delete('clustering/{session}', [ClusteringController::class, 'destroy'])->name('clustering.destroy');
    });

    // Modul Jadwal Ronda Malam (Generate, Cetak PDF & Excel untuk Mading/Grup WA)
    Route::get('ronda/export-pdf', [RondaController::class, 'exportPdf'])->name('ronda.exportPdf');
    Route::get('ronda/export-excel', [RondaController::class, 'exportExcel'])->name('ronda.exportExcel');
    Route::get('ronda', [RondaController::class, 'index'])->name('ronda.index');

    // Ketua RT & Admin Superadmin: Membuat jadwal & generate bergilir otomatis
    Route::middleware('role:admin,ketua_rt')->group(function () {
        Route::post('ronda/generate-otomatis', [RondaController::class, 'generateOtomatis'])->name('ronda.generateOtomatis');
        Route::post('ronda', [RondaController::class, 'store'])->name('ronda.store');
        Route::delete('ronda/{ronda}', [RondaController::class, 'destroy'])->name('ronda.destroy');
    });

    // Modul Manajemen Pengguna (Admin Superadmin Only) - PRD Section 2
    Route::middleware('role:admin')->group(function () {
        Route::resource('pengguna', UserController::class);
    });
});
