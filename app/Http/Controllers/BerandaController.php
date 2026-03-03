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
        $logLogin = logLogin::orderBy('id_log', 'desc')->take(8)->get();

        // $startDate = Carbon::now()->subDays(6)->toDateString(); // 7 hari termasuk hari ini
        // $data = Pembayaran::select(DB::raw('DATE(tgl_bayar) as tanggal'), DB::raw('SUM(jumlah_bayar) as total_uang'))->where('tgl_bayar', '>=', $startDate)->groupBy('tanggal')->orderBy('tanggal', 'ASC')->get();
        $dataBulanan = Pembayaran::select(
            DB::raw('MONTH(tgl_bayar) as bulan'),
            DB::raw('SUM(jumlah_bayar) as total')
        )->whereYear('tgl_bayar', Carbon::now()->year)
        ->groupBy('bulan')->orderBy('bulan')->get();

        $labelsBulanan = [
            'Januari','Februari','Maret','April','Mei','Juni',
            'Juli','Agustus','September','Oktober','November','Desember'
        ];

        $totalsBulanan = collect(range(1, 12))->map(function ($bln) use ($dataBulanan) {
            $found = $dataBulanan->firstWhere('bulan', $bln);
            return $found ? $found->total : 0;
        });

        // Mapping nama bulan
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $bulanIni = $namaBulan[Carbon::now()->month];
        $totalSiswa = Siswa::count();

        $totalLunas = Pembayaran::where('bulan_dibayar', $bulanIni)
            ->distinct('nisn')
            ->count('nisn');

        $totalBelum = $totalSiswa - $totalLunas;
        $pieLabels = ['Sudah Bayar', 'Belum Bayar'];
        $pieValues = [$totalLunas, $totalBelum];

        return view('beranda.admin', [
            'labelsBulanan' => $labelsBulanan,
            'totalsBulanan' => $totalsBulanan,
            'pieLabels' => $pieLabels,
            'pieValues' => $pieValues,

            // variabel lama
            'totalSiswa' => $totalSiswa,
            'totalSPP' => $totalSPP,
            'totalPetugas' => $totalPetugas,
            'totalKelas' => $totalKelas,
            'totalUangMasuk' => $totalUangMasuk,
            'logPembayaran' => $logPembayaran,
            'logLogin' => $logLogin,
        ]);
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
