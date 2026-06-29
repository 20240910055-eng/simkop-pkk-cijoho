<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\SimpananController;
use App\Http\Controllers\KreditController;
use App\Http\Controllers\KasController;
use App\Http\Controllers\LoginController;

// ========================================================
// 1. RUTE PUBLIK (Bisa Dilihat Semua Orang Tanpa Login)
// ========================================================
Route::get('/', [KasController::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard', [KasController::class, 'dashboard']);

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ========================================================
// 2. RUTE PROTEKSI ADMIN (Wajib Login untuk Input/Kelola Data)
// ========================================================
Route::middleware(['auth'])->group(function () {
    
    Route::resource('anggota', AnggotaController::class);
    Route::resource('simpanan', SimpananController::class);
    Route::resource('kredit', KreditController::class);
    
    Route::get('/kas', [KasController::class, 'index'])->name('kas.index');
    Route::get('/anggota/{id}/aktivitas', [AnggotaController::class, 'aktivitas'])->name('anggota.aktivitas');
    
    // RUTE BARU: Menangani request AJAX cek status simpanan pokok berjalan
    Route::get('/simpanan/cek-pokok/{anggota_id}', [SimpananController::class, 'cekStatusPokok']);
    
});