<x-layout judul="DataPembayaran">
    <div class="card">
        <div class="row p-4 flex-column flex-md-row pb-0">
            <div class="d-md-flex justify-content-between align-items-center col-md-auto me-auto mt-0">
                <input type="search" class="form-control" placeholder="Cari siswa ...">
            </div>
            <div class="d-md-flex justify-content-between align-items-center col-md-auto ms-auto mt-0">
            </div>
        </div>


        <table class="table mt-3">
            <thead class="table-primary text-center">
                <tr>
                    <th>Tanggal Bayar</th>
                    <th>NISN</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Bulan Dibayar</th>
                    <th>Total Bayar</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pembayaran as $p)
                    <tr>
                        <td class="text-center">{{ $p->tgl_bayar }}</td>
                        <td class="text-center">{{ $p->nisn }}</td>
                        <td style="padding-left: 12px;">{{  $p->siswa->nama }}</td>
                        <td class="text-center">{{ $p->siswa->kelas->nama_kelas }}</td>
                        <td class="text-center">{{ $p->total_bulan }}</td>
                        <td class="text-center">Rp {{ number_format($p->total_bayar, 0, ',', '.') }}</td>
                        <td class="text-center"><a href="/admin/riwayat/{{ $p->id_transaksi }}" class="btn btn-secondary btn-sm">detail</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</x-layout>
