<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;

class RiwayatController extends Controller
{
    public function riwayat(Request $request)
    {
        $kelas = Kelas::all();
        $cari = $request->cari;
        $tgl  = $request->tgl;
        $id_kelas = $request->kelas;

        $query = Pembayaran::select(
                DB::raw('MIN(id_pembayaran) as id_transaksi'),
                'nisn',
                'tgl_bayar',
                DB::raw('MIN(created_at) as dicatat'),
                DB::raw('COUNT(bulan_dibayar) as total_bulan'),
                DB::raw('SUM(jumlah_bayar) as total_bayar')
            )
            ->with('siswa.kelas')
            ->groupBy('nisn', 'tgl_bayar')
            ->orderBy('dicatat', 'desc');

        if ($cari) {
            $query->whereHas('siswa', function ($q) use ($cari) {
                $q->where('nama', 'like', '%' . $cari . '%')
                ->orWhere('nisn', 'like', '%' . $cari . '%');
            });
        }

        if ($tgl) {
            $query->where('tgl_bayar', $tgl);
        }

        if ($id_kelas) {
            $query->whereHas('siswa.kelas', function($q) use ($id_kelas){
                $q->where('id_kelas', $id_kelas);
            });
        }
        $pembayaran = $query->get();
        return view('data.riwayat_pembayaran', compact('pembayaran', 'kelas'));
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
