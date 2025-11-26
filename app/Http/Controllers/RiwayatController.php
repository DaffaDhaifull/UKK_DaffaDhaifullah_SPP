<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class RiwayatController extends Controller
{
    public function riwayat(Request $request)
    {
        $kelas = Kelas::all();
        $cari = $request->cari;
        $tglAwal  = $request->input('tgl-awal');
        $tglAkhir = $request->input('tgl-akhir');
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

        if ($tglAwal && $tglAkhir) {
            $query->whereBetween('tgl_bayar', [$tglAwal, $tglAkhir]);
        }
        else if ($tglAwal) {
            $query->where('tgl_bayar', '>=', $tglAwal);
        }
        else if ($tglAkhir) {
            $query->where('tgl_bayar', '<=', $tglAkhir);
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


    public function riwayatSiswa()
    {
        $nisn = auth()->guard('siswa')->user()->nisn;
        $data = Pembayaran::where('nisn', $nisn)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('data.riwayat_siswa', compact('data'));
    }

    public function cetakPDF(Request $request)
    {
        $cari     = $request->cari;
        $tglAwal  = $request->input('tgl-awal');
        $tglAkhir = $request->input('tgl-akhir');
        $id_kelas = $request->kelas;

        $query = Pembayaran::select(
                DB::raw('MIN(id_pembayaran) as id_transaksi'),
                'nisn',
                'tgl_bayar',
                DB::raw('MIN(id_petugas) as id_petugas'),
                DB::raw('MIN(created_at) as dicatat'),
                DB::raw('COUNT(bulan_dibayar) as total_bulan'),
                DB::raw('SUM(jumlah_bayar) as total_bayar')
            )
            ->with(['siswa.kelas'])
            ->groupBy('nisn', 'tgl_bayar')
            ->orderBy('dicatat', 'desc');

        if ($cari) {
            $query->whereHas('siswa', function ($q) use ($cari) {
                $q->where('nama', 'like', '%' . $cari . '%')
                ->orWhere('nisn', 'like', '%' . $cari . '%');
            });
        }

        if ($tglAwal && $tglAkhir) {
            $query->whereBetween('tgl_bayar', [$tglAwal, $tglAkhir]);
        }

        if ($id_kelas) {
            $query->whereHas('siswa.kelas', function($q) use ($id_kelas){
                $q->where('id_kelas', $id_kelas);
            });
        }

        $pembayaran = $query->get();
        $pdf = Pdf::loadView('pdf.riwayat', compact('pembayaran', 'tglAwal', 'tglAkhir'));

        return $pdf->stream('riwayat_pembayaran.pdf');
    }


}
