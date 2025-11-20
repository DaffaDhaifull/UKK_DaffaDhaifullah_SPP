<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Siswa;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $kelas = Kelas::all();
        $cari = $request->cari;
        $id_kelas = $request->kelas;
        $query = Siswa::query()->with('kelas');

        if ($cari) {
            $query->where(function ($q) use ($cari) {
                $q->where('nama', 'like', '%' . $cari . '%')
                ->orWhere('nisn', 'like', '%' . $cari . '%');
            });
        }

        if ($id_kelas) {
            $query->where('id_kelas', $id_kelas);
        }

        $siswa = $query->get();
        $hasil = [];

        foreach ($siswa as $s) {
            $hasil[] = [
                'nisn' => $s->nisn,
                'nama' => $s->nama,
                'kelas' => $s->kelas->nama_kelas,
                'status' => $this->statusPembayaranSiswa($s->nisn)
            ];
        }

        return view('data.pembayaran', ['data' => $hasil,'kelas' => $kelas]);
    }



    public function detailPembayaran(string $id){
        $siswa = Siswa::where('nisn',$id)->first();
        $status = $this->statusPembayaranSiswa($id);

        return view('data.detail_pembayaran',compact('siswa','status'));
    }


    public function storePembayaran(Request $request)
    {
        $request->validate([
            'bulan' => 'required|array',
        ]);

        $nisn = $request->nisn;
        $idPertama = null;

        foreach ($request->bulan as $bulan) {
            $cek = Pembayaran::where('nisn', $nisn)
                    ->where('bulan_dibayar', $bulan)
                    ->first();


            if ($cek) continue; // skip jika sudah ada
            $p = Pembayaran::create([
                'id_petugas'    => $request->petugas,
                'nisn'          => $nisn,
                'tgl_bayar'     => $request->tgl,
                'bulan_dibayar' => $bulan,
                'tahun_dibayar' => $request->tahun,
                'id_spp'        => $request->spp,
                'jumlah_bayar'  => $request->jumlah,
            ]);

            if (!$idPertama) {
                $idPertama = $p->id_pembayaran;
            }
        }

        if (!$idPertama) {
            return redirect()->back()->with('warning', 'Semua bulan sudah pernah dibayar.');
        }

        return redirect()->route('riwayat.detail', $idPertama)->with('success', 'Pembayaran berhasil ditambahkan.');
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


    public function cetakKuitansi($id_pembayaran)
    {
        $utama = Pembayaran::with(['siswa.kelas', 'petugas'])->where('id_pembayaran', $id_pembayaran)->firstOrFail();
        $semuaPembayaran = Pembayaran::where('nisn', $utama->nisn)
            ->where('tgl_bayar', $utama->tgl_bayar)->get();
        $totalBayar = $semuaPembayaran->sum('jumlah_bayar');

        $data = [
            'utama' => $utama,
            'semuaPembayaran' => $semuaPembayaran,
            'totalBayar' => $totalBayar,
            'tanggalCetak' => now()->format('l, d F Y'),
        ];

        $pdf = \PDF::loadView('pdf.kuitansi', $data)->setPaper('A5', 'portrait');

        return $pdf->stream('kuitansi-'.$utama->nisn.'.pdf');
    }


}
