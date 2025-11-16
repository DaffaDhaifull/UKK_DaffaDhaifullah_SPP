<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use Illuminate\Support\Facades\Route;


Route::middleware(['guest:petugas', 'guest:siswa'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login/proses', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout']);


Route::middleware(['petugas'])->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/beranda', [BerandaController::class, 'admin'])->name('beranda.admin');
    });

    Route::middleware('role:petugas')->group(function () {
        Route::get('/petugas/beranda', [BerandaController::class, 'petugas'])->name('beranda.petugas');
    });
});

Route::middleware(['siswa'])->group(function () {
    Route::get('/siswa/beranda', [BerandaController::class, 'siswa'])->name('beranda.siswa');
});
