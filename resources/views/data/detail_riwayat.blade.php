<x-layout judul="CekSPP | Riwayat">
@php
    $prefix = request()->routeIs('admin.*') ? 'admin.' : 'petugas.';
@endphp


    <h4>Detail Pembayaran SPP</h4>
    <p>Melihat pembayaran yang telah di catat dan anda bisa mencetak kuitansi disini</p>

    <div class="card mb-4 mt-4">
        <div class="card-body">
            <div class="p-2">
                <div class="row">
                    <div class="col-md-2 fw-semibold">NISN</div>
                    <div class="col-md-4">: {{ $utama->nisn }}</div>

                    <div class="col-md-2 fw-semibold">Nama Petugas</div>
                    <div class="col-md-4">: {{ $utama->petugas->nama_petugas }}</div>
                </div>

                <div class="row">
                    <div class="col-sm-2 fw-semibold">Nama Siswa</div>
                    <div class="col-sm-4">: {{ $utama->siswa->nama }}</div>

                    <div class="col-sm-2 fw-semibold">Tanggal Bayar</div>
                    <div class="col-sm-4">: {{ $utama->tgl_bayar }}</div>
                </div>
            </div>
            </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h4>Bulan yang dibayar:</h4>
            <table class="table">
                <thead class="table-primary">
                    <tr>
                        <th class="text-center">Bulan</th>
                        <th class="text-center">Tahun</th>
                        <th class="text-center">Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($semuaPembayaran as $item)
                        <tr>
                            <td class="text-center">{{ $item->bulan_dibayar }}</td>
                            <td class="text-center">{{ $item->tahun_dibayar }}</td>
                            <td class="text-center">Rp. {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach

                    <tr>
                        <td></td>
                        <td class="text-end fw-bold">Total :</td>
                        <td class="fw-bold text-center">
                            Rp. {{ number_format($totalBayar, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex">
        <a href="{{ route($prefix.'riwayat.index') }}" class="btn btn-outline-secondary mt-3 me-2">Selesai</a>

        <form action="{{ route($prefix.'riwayat.cetak', $utama->id_pembayaran) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary mt-3">Cetak kuitansi</button>
        </form>
    </div>
</x-layout>
