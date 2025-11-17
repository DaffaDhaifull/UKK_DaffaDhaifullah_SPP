<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SppController;
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
        Route::put('/admin/petugas/{id}',[PetugasController::class,'update'])->name('petugas.update');
        Route::delete('/admin/petugas/{id}', [PetugasController::class,'destroy'])->name('petugas.destroy');

        Route::get('/admin/kelas', [KelasController::class,'index'])->name('kelas.index');
        Route::post('/admin/kelas',[KelasController::class,'store'])->name('kelas.store');
        Route::get('/admin/kelas/{id}', [KelasController::class,'show'])->name('kelas.show');
        Route::put('/admin/kelas/{id}',[KelasController::class,'update'])->name('kelas.update');
        Route::delete('/admin/kelas/{id}', [KelasController::class,'destroy'])->name('kelas.destroy');

        Route::get('/admin/spp', [SppController::class,'index'])->name('spp.index');
        Route::post('/admin/spp',[SppController::class,'store'])->name('spp.store');
        Route::get('/admin/spp/{id}', [SppController::class,'show'])->name('spp.show');
        Route::put('/admin/spp/{id}',[SppController::class,'update'])->name('spp.update');
        Route::delete('/admin/spp/{id}', [SppController::class,'destroy'])->name('spp.destroy');

        Route::get('/admin/siswa', [SiswaController::class,'index'])->name('siswa.index');
        Route::post('/admin/siswa',[SiswaController::class,'store'])->name('siswa.store');
        Route::get('/admin/siswa/{id}', [SiswaController::class,'show'])->name('siswa.show');
        Route::put('/admin/siswa/{id}',[SiswaController::class,'update'])->name('siswa.update');
        Route::delete('/admin/siswa/{id}', [SiswaController::class,'destroy'])->name('siswa.destroy');
    });

    Route::middleware('role:petugas')->group(function () {
        Route::get('/petugas/beranda', [BerandaController::class, 'petugas'])->name('beranda.petugas');
    });
});



Route::middleware(['siswa'])->group(function () {
    Route::get('/siswa/beranda', [BerandaController::class, 'siswa'])->name('beranda.siswa');
});
