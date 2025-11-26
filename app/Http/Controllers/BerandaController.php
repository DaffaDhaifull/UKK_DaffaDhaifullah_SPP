<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Pembayaran;
use App\Models\Petugas;
use App\Models\Siswa;
use App\Models\Spp;
use App\Models\LogLogin;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use function PHPUnit\Framework\returnArgument;

class BerandaController extends Controller
{
    public function admin()
    {
        $totalSiswa = Siswa::count();
        $totalSPP = Spp::count();
        $totalPetugas = Petugas::count();
        $totalKelas = Kelas::count();
        $totalUangMasuk = Pembayaran::sum('jumlah_bayar');
        $logPembayaran = Pembayaran::with(['petugas', 'siswa'])
            ->latest()
            ->take(8)
            ->get();
        $logLogin = logLogin::orderBy('id_log', 'desc')->take(5)->get();

        $startDate = Carbon::now()->subDays(6)->toDateString(); // 7 hari termasuk hari ini

        $data = Pembayaran::select(DB::raw('DATE(tgl_bayar) as tanggal'), DB::raw('SUM(jumlah_bayar) as total_uang'))->where('tgl_bayar', '>=', $startDate)->groupBy('tanggal')->orderBy('tanggal', 'ASC')->get();

        // Siapkan array tanggal lengkap 7 hari (untuk mengisi data yang kosong)
        $labels = collect();
        for ($i = 6; $i >= 0; $i--) {
            $labels->push(Carbon::now()->subDays($i)->toDateString());
        }

        // Mapping agar tanggal tanpa pembayaran → 0
        $totals = $labels->map(function ($tgl) use ($data) {
            $found = $data->firstWhere('tanggal', $tgl);
            return $found ? $found->total_uang : 0;
        });

        return view('beranda.admin', compact('labels', 'totals', 'totalSiswa', 'totalSPP', 'totalPetugas', 'totalKelas', 'totalUangMasuk', 'logPembayaran', 'logLogin'));
    }
    public function petugas()
    {
        $totalSiswa = Siswa::count();
        $totalSPP = Spp::count();
        $totalPetugas = Petugas::count();
        $totalKelas = Kelas::count();
        $totalUangMasuk = Pembayaran::sum('jumlah_bayar');
        $logPembayaran = Pembayaran::with(['petugas', 'siswa'])
            ->latest()
            ->take(8)
            ->get();
        // $logLogin     = logLogin::orderBy('id_log','desc')->take(8)->get();
        $logLogin = DB::select('CALL show_log_login()');

        return view('beranda.petugas', compact('totalSiswa', 'totalSPP', 'totalPetugas', 'totalKelas', 'totalUangMasuk', 'logPembayaran', 'logLogin'));
    }
    public function siswa(Request $request, $id)
    {
        $siswa = Siswa::find($id);
        $kelas = $siswa->kelas->nama_kelas;

        $bulanList = ['Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'];

        $semester = $request->input('semester');

        $pembayaran = Pembayaran::where('nisn', $siswa->nisn);

        if ($semester) {
            if ($semester % 2 == 1) {
                $bulanList = ['Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            } else {
                $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'];
            }
        }

        $pembayaran = $pembayaran->get()->keyBy('bulan_dibayar');

        return view('beranda.siswa', compact('siswa', 'bulanList', 'pembayaran'));
    }
}
