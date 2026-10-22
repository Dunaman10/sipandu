<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClusteringController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasWargaController;
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

    // Modul Data Warga
    Route::get('warga/export-pdf', [WargaController::class, 'exportPdf'])->name('warga.exportPdf');
    Route::resource('warga', WargaController::class);

    // Modul Administrasi Keuangan (Kas Warga)
    Route::get('kas/export-pdf', [KasWargaController::class, 'exportPdf'])->name('kas.exportPdf');
    Route::post('kas/generate-bulanan', [KasWargaController::class, 'generateBulanan'])->name('kas.generateBulanan');
    Route::patch('kas/{ka}/toggle-status', [KasWargaController::class, 'toggleStatus'])->name('kas.toggleStatus');
    Route::get('kas', [KasWargaController::class, 'index'])->name('kas.index');
    Route::post('kas', [KasWargaController::class, 'store'])->name('kas.store');
    Route::delete('kas/{ka}', [KasWargaController::class, 'destroy'])->name('kas.destroy');

    // Modul Mesin Algoritma K-Means Clustering (Ketua RT & Admin)
    Route::middleware('role:admin,ketua_rt')->group(function () {
        Route::get('clustering', [ClusteringController::class, 'index'])->name('clustering.index');
        Route::post('clustering/run', [ClusteringController::class, 'run'])->name('clustering.run');
        Route::get('clustering/{session}', [ClusteringController::class, 'show'])->name('clustering.show');
        Route::get('clustering/{session}/export-pdf', [ClusteringController::class, 'exportPdf'])->name('clustering.exportPdf');
        Route::delete('clustering/{session}', [ClusteringController::class, 'destroy'])->name('clustering.destroy');
    });

    // Modul Jadwal & Absensi Ronda Malam (Fitur Baru)
    Route::get('ronda/export-pdf', [RondaController::class, 'exportPdf'])->name('ronda.exportPdf');
    Route::get('ronda/rekapitulasi', [RondaController::class, 'rekapitulasi'])->name('ronda.rekap');
    Route::patch('ronda/absensi/{participant}', [RondaController::class, 'updateAbsensi'])->name('ronda.updateAbsensi');
    Route::get('ronda', [RondaController::class, 'index'])->name('ronda.index');
    Route::post('ronda', [RondaController::class, 'store'])->name('ronda.store');
    Route::delete('ronda/{ronda}', [RondaController::class, 'destroy'])->name('ronda.destroy');

    // Modul Manajemen Pengguna (Admin Superadmin Only)
    Route::middleware('role:admin')->group(function () {
        Route::resource('pengguna', UserController::class);
    });
});
