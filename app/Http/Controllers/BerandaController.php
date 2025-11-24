<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Pembayaran;
use App\Models\Petugas;
use App\Models\Siswa;
use App\Models\Spp;
use App\Models\LogLogin;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use function PHPUnit\Framework\returnArgument;

class BerandaController extends Controller
{
    public function admin(){
        $totalSiswa = Siswa::count();
        $totalSPP = Spp::count();
        $totalPetugas = Petugas::count();
        $totalKelas = Kelas::count();
        $totalUangMasuk = Pembayaran::sum('jumlah_bayar');
        $logPembayaran = Pembayaran::with(['petugas','siswa'])->latest()->take(8)->get();
        $logLogin     = logLogin::orderBy('id_log','desc')->take(5)->get();

        return view('beranda.admin',compact('totalSiswa','totalSPP','totalPetugas','totalKelas','totalUangMasuk','logPembayaran','logLogin'));
    }
    public function petugas(){
        $totalSiswa = Siswa::count();
        $totalSPP = Spp::count();
        $totalPetugas = Petugas::count();
        $totalKelas = Kelas::count();
        $totalUangMasuk = Pembayaran::sum('jumlah_bayar');
        $logPembayaran = Pembayaran::with(['petugas','siswa'])->latest()->take(8)->get();
        // $logLogin     = logLogin::orderBy('id_log','desc')->take(8)->get();
        $logLogin = DB::select('CALL show_log_login()');

        return view('beranda.petugas',compact('totalSiswa','totalSPP','totalPetugas','totalKelas','totalUangMasuk','logPembayaran','logLogin'));
    }
    public function siswa($id){
        $siswa = Siswa::find($id);

        $bulanList = ['Juli', 'Agustus','September', 'Oktober', 'November', 'Desember','Januari', 'Februari', 'Maret', 'April','Mei', 'Juni'];
        $pembayaran = Pembayaran::where('nisn', $siswa->nisn)->get()->keyBy('bulan_dibayar');

        return view('beranda.siswa',compact('siswa','bulanList','pembayaran'));
    }
}
