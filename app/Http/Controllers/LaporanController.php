<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Pembayaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $kelas = Kelas::all();
        $data = [];

        if (!$request->id_kelas) {
            return view('data.laporan_pembayaran', compact('data', 'kelas'));
        }

        $siswa = Siswa::where('id_kelas', $request->id_kelas)->get();

        foreach ($siswa as $s) {
            $data[] = [
                'nisn' => $s->nisn,
                'nama' => $s->nama,
                'kelas' => $s->kelas->nama_kelas,
                'status' => $this->statusPembayaranSiswa($s->nisn)
            ];
        }

        return view('data.laporan_pembayaran', compact('data', 'kelas'));
    }






    public function statusPembayaranSiswa($nisn)
    {
        $urutBulan = ["Juli", "Agustus", "September", "Oktober", "November", "Desember","Januari", "Februari", "Maret", "April", "Mei", "Juni"];

        $bulanSudahBayar = Pembayaran::where('nisn', $nisn)
            ->pluck('bulan_dibayar')
            ->toArray();

        $data = [];

        foreach ($urutBulan as $bulan) {
            $data[$bulan] = in_array($bulan, $bulanSudahBayar) ? 'lunas' : 'belum';
        }

        return $data;
    }



    public function cetakPDF(Request $request)
    {

        if (!$request->id_kelas) {
            return back()->with('error', 'Pilih kelas terlebih dahulu!');
        }

        $kelas = Kelas::find($request->id_kelas);
        $siswa = Siswa::with('spp')->where('id_kelas', $request->id_kelas)->get();

        $data = [];

        foreach ($siswa as $s) {
            $data[] = [
                'nisn' => $s->nisn,
                'nama' => $s->nama,
                'kelas' => $s->kelas->nama_kelas,
                'nominal' => $s->spp->nominal,
                'status' => $this->statusPembayaranSiswa($s->nisn)
            ];
        }


        $pdf = Pdf::loadView('pdf.laporan', [
            'data' => $data,
            'kelas' => $kelas,
            'bulan' => ["Juli","Agstus","September","Oktober","November","Desember","Januari","Februari","Maret","April","Mei","Juni"]
        ])->setPaper('A4', 'landscape'); // 🔥 Landscape

        return $pdf->stream('laporan_pembayaran_kelas.pdf');
    }

}
