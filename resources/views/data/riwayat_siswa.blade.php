<x-layout judul="CekSPP | Riwayat">
    <div class="card p-3">
    <h4 class="mb-3">Riwayat Pembayaran Saya</h4>

    @if ($data->isEmpty())
        <p class="text-muted">Belum ada riwayat pembayaran.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal Bayar</th>
                    <th>Bulan Dibayar</th>
                    <th>Jumlah Bayar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $r)
                <tr>
                    <td>{{ $r->tgl_bayar }}</td>
                    <td>{{ $r->bulan_dibayar }}</td>
                    <td>Rp {{ number_format($r->jumlah_bayar, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
</x-layout>
