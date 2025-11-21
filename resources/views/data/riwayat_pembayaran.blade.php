<x-layout judul="CekSPP | Riwayat">@php
    $prefix = request()->routeIs('admin.*') ? 'admin.' : 'petugas.';
@endphp
    <h4 class="mb-1">Riwayat Pembayaran</h4>
    <p>Menampilkan seluruh transaksi pembayaran yang telah terjadi</p>

    <div class="card">
        <div class="text-nowrap">
            <div class="dt-container dt-bootstrap5 dt-empty-footer">
                <form action="{{ route($prefix.'riwayat.index') }}" method="get" class="row g-3 p-3">
                    @csrf
                    <div class="col-md-3">
                        <label class="form-label text-capitalize">Cari siswa</label>
                        <input class="form-control" type="text" name="cari" value="{{ request('cari') }}" placeholder="Masukan nama / nisn ...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-capitalize">Pilih tanggal</label>
                        <input class="form-control" type="date" name="tgl" value="{{ request('tgl') }}" placeholder="dd-MM-yyyy">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-capitalize">Pilih kelas</label><br>
                        <select class="form-select" id="kelas_ab" name="kelas">
                            <option value="" hidden selected>- Pilih kelas -</option>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id_kelas }}" {{ request('kelas') == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-block align-items-end pt-4">
                        <button type="submit" class="btn btn-primary me-2 mt-2">Cari</button>
                        <button type="button" onclick="this.form.reset(); window.location='{{ route($prefix.'riwayat.index') }}';" class="btn btn-outline-primary mt-2">
                            Reset
                        </button>
                    </div>
                </form>
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
