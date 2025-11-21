<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Pembayaran;
use App\Models\Petugas;
use App\Models\Siswa;
use App\Models\Spp;
use Illuminate\Http\Request;
use function PHPUnit\Framework\returnArgument;

class BerandaController extends Controller
{
    public function admin(){
        return view('beranda.admin',[
            'totalSiswa'       => Siswa::count(),
            'totalSPP'         => Spp::count(),
            'totalPetugas'     => Petugas::count(),
            'totalKelas'       => Kelas::count(),
            'totalUangMasuk'   => Pembayaran::sum('jumlah_bayar'),

            // 'logLogin'         => LogLogin::latest()->take(10)->get(),

            'logPembayaran'    => Pembayaran::with(['petugas','siswa'])
                                ->latest()
                                ->take(10)
                                ->get(),
        ]);
    }
    public function petugas(){
        return view('beranda.petugas');
    }
    public function siswa(){
        return view('beranda.siswa');
    }
}
