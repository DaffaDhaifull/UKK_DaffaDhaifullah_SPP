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
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-success text-white">
                <div class="card-body">
                    <h6>Total Uang Masuk</h6>
                    <h2>Rp {{ number_format($totalUangMasuk, 0, ',', '.') }}</h2>
                </div>
            </div>

            <!-- TABLE LOG LOGIN -->
            <div class="card mt-4 shadow-sm border-0">
                <div class="card-header">
                    <strong>SPP lunas di bulan ini</strong>
                </div>
                <div class="card-body p-0">
                    <canvas id="pieLunas" width=""></canvas>
                </div>
            </div>
        </div>


        <div class="col-md-9">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <strong>Total Pembayaran (Rp)</strong>
                </div>
                <div class="card-body p-3">
                    <canvas id="chartPembayaran7Hari" height="132"></canvas>
                </div>
            </div>
        </div>

        {{-- <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <strong>Log Login</strong>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Status</th>
                                <th>Waktu</th>
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
                                    <td><small>{{ \Carbon\Carbon::parse($log->waktu)->diffForHumans() }}</small></td>
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


        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header ">
                    <strong>Log Aktivitas Pembayaran</strong>
                </div>
                <div class="card-body p-4">
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
                                    <td><small>{{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}</small></td>
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
        </div> --}}

    </div>

</div>

<script src="{{ asset('assets/js/chart.umd.min.js') }}"></script>

<script>
    const ctx = document.getElementById('chartPembayaran7Hari');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labelsBulanan) !!},
            datasets: [{
                label: 'Total Uang Masuk per Bulan (Rp)',
                data: {!! json_encode($totalsBulanan) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)'
            }]
        }
    });

    const ctxPie = document.getElementById('pieLunas');

    new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: {!! json_encode($pieLabels) !!},
            datasets: [{
                data: {!! json_encode($pieValues) !!},
                backgroundColor: [
                    '#65C2A5', // hijau: sudah bayar
                    '#C3C9EB'  // merah: belum bayar
                ]
            }]
        }
    });
</script>

</x-layout>
