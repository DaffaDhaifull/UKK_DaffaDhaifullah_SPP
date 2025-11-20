<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\RiwayatController;
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

        Route::prefix('admin/petugas')->name('petugas.')->group(function () {
            Route::get('/', [PetugasController::class, 'index'])->name('index');
            Route::post('/', [PetugasController::class, 'store'])->name('store');
            Route::get('/{id}', [PetugasController::class, 'show'])->name('show');
            Route::put('/{id}', [PetugasController::class, 'update'])->name('update');
            Route::delete('/{id}', [PetugasController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('admin/kelas')->name('kelas.')->group(function () {
            Route::get('/', [KelasController::class, 'index'])->name('index');
            Route::post('/', [KelasController::class, 'store'])->name('store');
            Route::get('/{id}', [KelasController::class, 'show'])->name('show');
            Route::put('/{id}', [KelasController::class, 'update'])->name('update');
            Route::delete('/{id}', [KelasController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('admin/spp')->name('spp.')->group(function () {
            Route::get('/', [SppController::class, 'index'])->name('index');
            Route::post('/', [SppController::class, 'store'])->name('store');
            Route::get('/{id}', [SppController::class, 'show'])->name('show');
            Route::put('/{id}', [SppController::class, 'update'])->name('update');
            Route::delete('/{id}', [SppController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('admin/siswa')->name('siswa.')->group(function () {
            Route::get('/', [SiswaController::class, 'index'])->name('index');
            Route::post('/', [SiswaController::class, 'store'])->name('store');
            Route::get('/{id}', [SiswaController::class, 'show'])->name('show');
            Route::put('/{id}', [SiswaController::class, 'update'])->name('update');
            Route::delete('/{id}', [SiswaController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('admin/pembayaran')->name('pembayaran.')->group(function () {
            Route::get('',[PembayaranController::class,'index'])->name('index');
            Route::get('/{id}',[PembayaranController::class,'detailPembayaran'])->name('detail');
            Route::post('/', [PembayaranController::class, 'storePembayaran'])->name('store');
        });

        Route::get('/admin/riwayat',[RiwayatController::class,'riwayat'])->name('riwayat.index');
        Route::get('/admin/riwayat/{id}',[RiwayatController::class,'detailRiwayat'])->name('riwayat.detail');
        Route::post('/admin/cetak/{id}', [PembayaranController::class, 'cetakKuitansi'])->name('riwayat.cetak');

        route::get('/admin/laporan',[LaporanController::class,'index'])->name('laporan.index');
        Route::get('/laporan/cetak', [LaporanController::class, 'cetakPDF'])->name('laporan.cetak');
    });

    Route::middleware('role:petugas')->group(function () {
        Route::get('/petugas/beranda', [BerandaController::class, 'petugas'])->name('beranda.petugas');
    });
});



Route::middleware(['siswa'])->group(function () {
    Route::get('/siswa/beranda', [BerandaController::class, 'siswa'])->name('beranda.siswa');
});
