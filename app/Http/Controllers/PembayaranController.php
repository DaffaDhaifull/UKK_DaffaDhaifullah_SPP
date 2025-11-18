<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Siswa;

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
        // dd(['siswa'=>$siswa,'status'=> $status]);
        return view('data.detail_pembayaran',compact('siswa','status'));
    }

    public function storePembayaran(Request $request)
    {
        $request->validate([
            'bulan' => 'required|array',
        ]);

        $nisn = $request->nisn;

        foreach ($request->bulan as $bulan) {

            // Cek apakah bulan sudah lunas
            $cek = Pembayaran::where('nisn', $nisn)
                    ->where('bulan_dibayar', $bulan)
                    ->first();

            if ($cek) continue; // skip jika sudah ada

            Pembayaran::create([
                'id_petugas'    => $request->petugas,
                'nisn'          => $nisn,
                'tgl_bayar'     => $request->tgl,
                'bulan_dibayar' => $bulan,
                'tahun_dibayar' => date('Y'),
                'id_spp'        => $request->spp,
                'jumlah_bayar'  => $request->jumlah,
            ]);
        }

        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil ditambahkan.');
    }



    public function statusPembayaranSiswa($nisn)
    {
        $urutBulan = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        $bulanSudahBayar = Pembayaran::where('nisn', $nisn)
            ->pluck('bulan_dibayar')
            ->toArray();

        $data = [];

        foreach ($urutBulan as $bulan) {
            $data[$bulan] = in_array($bulan, $bulanSudahBayar) ? 'lunas' : 'belum';
        }

        return $data;
    }

}
