<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function index(){
        $siswa = Siswa::all();
        $hasil = [];

        foreach ($siswa as $s) {
            $hasil[] = [
                'nisn' => $s->nisn,
                'nama' => $s->nama,
                'status' => $this->statusPembayaranSiswa($s->nisn)
            ];
        }

        return view('data.pembayaran', [
            'data' => $hasil
        ]);
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
