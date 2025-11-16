<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\PetugasController;
use Illuminate\Support\Facades\Route;


Route::post('/logout', [AuthController::class, 'logout']);
Route::middleware(['guest:petugas', 'guest:siswa'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login/proses', [AuthController::class, 'login']);
});


Route::middleware(['petugas'])->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/beranda', [BerandaController::class, 'admin'])->name('beranda.admin');
        Route::get('/admin/petugas', [PetugasController::class,'index'])->name('petugas.index');
        Route::post('/admin/petugas',[PetugasController::class,'store'])->name('petugas.store');
        Route::get('/admin/petugas/{id}', [PetugasController::class,'show'])->name('petugas.show');
        Route::put('/admin/update/{id}',[PetugasController::class,'update'])->name('petugas.update');
        Route::delete('/admin/petugas/{id}', [PetugasController::class,'destroy'])->name('petugas.destroy');
    });

    Route::middleware('role:petugas')->group(function () {
        Route::get('/petugas/beranda', [BerandaController::class, 'petugas'])->name('beranda.petugas');
    });
});



Route::middleware(['siswa'])->group(function () {
    Route::get('/siswa/beranda', [BerandaController::class, 'siswa'])->name('beranda.siswa');
});
