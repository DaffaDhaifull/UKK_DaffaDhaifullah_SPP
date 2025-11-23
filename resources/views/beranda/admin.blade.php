<x-layout judul="CekSPP | Beranda">
<div class="container-fluid py-4">

    <h3 class="mb-4">Dashboard Admin</h3>

    <div class="row g-4">

        <!-- Total Siswa -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Total Siswa</h6>
                    <h2>{{ $totalSiswa }}</h2>
                </div>
            </div>
        </div>

        <!-- Total Data SPP -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Total Data SPP</h6>
                    <h2>{{ $totalSPP }}</h2>
                </div>
            </div>
        </div>

        <!-- Total Petugas -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Total Petugas</h6>
                    <h2>{{ $totalPetugas }}</h2>
                </div>
            </div>
        </div>

        <!-- Total Kelas -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Total Kelas</h6>
                    <h2>{{ $totalKelas }}</h2>
                </div>
            </div>
        </div>

        <!-- Total Uang Masuk -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-success text-white">
                <div class="card-body">
                    <h6>Total Uang Masuk</h6>
                    <h2>Rp {{ number_format($totalUangMasuk, 0, ',', '.') }}</h2>
                </div>
            </div>

            <!-- TABLE LOG LOGIN -->
            <div class="card mt-4 shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <strong>Log Login</strong>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logLogin as $log)
                                <tr>
                                    <td>{{ $log->username }}</td>
                                    <td>
                                        @if ($log->aktivitas == 'login')
                                            <span class="badge bg-success">login</span>
                                        @else
                                            <span class="badge bg-secondary">logout</span>
                                        @endif
                                    </td>
                                    <td><small>{{ $log->waktu_lalu }}</small></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada log login</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TABLE LOG PEMBAYARAN -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning">
                    <strong>Log Aktivitas Pembayaran</strong>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Petugas</th>
                                <th>Siswa</th>
                                <th>Bulan</th>
                                <th>Jumlah</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logPembayaran as $log)
                                <tr>
                                    <td>{{ $log->petugas->nama_petugas }}</td>
                                    <td>{{ $log->siswa->nama }}</td>
                                    <td>{{ $log->bulan_dibayar }}</td>
                                    <td>Rp {{ number_format($log->jumlah_bayar, 0, ',', '.') }}</td>
                                    <td>{{ $log->created_at }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada aktivitas pembayaran</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>
</x-layout>
