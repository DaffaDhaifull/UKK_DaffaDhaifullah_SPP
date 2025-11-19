<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;

class RiwayatController extends Controller
{
    public function riwayat(){
        $pembayaran = Pembayaran::select(
                DB::raw('MIN(id_pembayaran) as id_transaksi'),
                'nisn',
                'tgl_bayar',
                DB::raw('MIN(created_at) as dicatat'),
                DB::raw('COUNT(bulan_dibayar) as total_bulan'),
                DB::raw('SUM(jumlah_bayar) as total_bayar')
            )->groupBy('nisn', 'tgl_bayar')->orderBy('dicatat', 'desc')->get();

        return view('data.riwayat_pembayaran', compact('pembayaran'));
    }


    public function detailRiwayat($id_pembayaran){
        $utama = Pembayaran::with(['siswa', 'petugas'])
            ->where('id_pembayaran', $id_pembayaran)->firstOrFail();

        $semuaPembayaran = Pembayaran::where('nisn', $utama->nisn)
            ->where('tgl_bayar', $utama->tgl_bayar)->get();
        $totalBayar = $semuaPembayaran->sum('jumlah_bayar');

        return view('data.detail_riwayat', compact('utama','semuaPembayaran','totalBayar'));
    }
}
