<x-layout judul="CekSPP | Beranda">
    <h3 class="mb-4">Dashboard Siswa</h3>

    <div class="card p-4">
        <h5>Data Siswa</h5>
        <form class="px-4 mx-4 mt-3" action="">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nama" class="for-label">Nomor Induk Siswa Nasional (NISN)</label>
                    <input type="text" class="form-control" value="{{ $siswa->nisn }}" disabled>
                </div>
                <div class="col-md-6">
                    <label for="nama" class="for-label">Nomor Induk Siswa (NIS)</label>
                    <input type="text" class="form-control" value="{{ $siswa->nis }}" disabled>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nama" class="for-label">Nama Siswa</label>
                    <input type="text" class="form-control" value="{{ $siswa->nama }}" disabled>
                </div>
                <div class="col-md-6">
                    <label for="nama" class="for-label">Nomor telepon</label>
                    <input type="text" class="form-control" value="{{ $siswa->no_telepon }}" disabled>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="nama" class="for-label">Kelas</label>
                    <input type="text" class="form-control" value="{{ $siswa->kelas->nama_kelas }}" disabled>
                </div>
                <div class="col-md-6">
                    <label for="nama" class="for-label">Nominal SPP</label>
                    <input type="text" class="form-control" value="Rp. {{ number_format($siswa->spp->nominal ?? 0, 0, ',', '.')  }}" disabled>
                </div>
            </div>
        </form>
    </div>

    <div class="card p-4 mt-4">
        <h5>Data Pembayaran</h5>
        <div class="px-4 mx-4 mt-3">
            <table class="table table-bordered">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>Bulan</th>
                        <th>Tanggal Bayar</th>
                        <th>Petugas</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bulanList as $bulan)
                        @php
                            $bayar = $pembayaran->get($bulan);
                        @endphp

                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $bulan }}</td>

                            @if ($bayar)
                                <td>{{ \Carbon\Carbon::parse($bayar->tgl_bayar)->format('d-m-Y') }}</td>
                                <td>{{ $bayar->petugas->nama_petugas }}</td>
                                <td>Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}</td>
                                <td><span class="badge bg-success">Lunas</span></td>
                            @else
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td><span class="badge bg-secondary">Belum Bayar</span></td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</x-layout>
