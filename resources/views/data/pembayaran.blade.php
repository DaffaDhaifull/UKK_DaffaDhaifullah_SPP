<x-layout judul="CekSPP | Pembayaran">
    <div class="card">
        <div class="card-datatable text-nowrap">
            <div class="dt-container dt-bootstrap5 dt-empty-footer">
                <form action="{{ route('pembayaran.index') }}" method="get" class="row g-3 p-3">
                    @csrf
                    <div class="col-md-4">
                        <label class="form-label text-capitalize">Cari siswa</label>
                        <input class="form-control" type="text" name="cari" value="{{ request('cari') }}" placeholder="Masukan nama / nisn ...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-capitalize">Pilih kelas</label><br>
                        <select class="form-select" id="kelas_ab" name="kelas">
                            <option value="" hidden selected>- Pilih kelas -</option>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id_kelas }}" {{ request('kelas') == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 d-block align-items-end pt-4">
                        <button type="submit" class="btn btn-primary me-2 mt-2">Cari</button>
                        <button type="button" onclick="this.form.reset(); window.location='{{ route('pembayaran.index') }}';" class="btn btn-outline-primary mt-2">
                            Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>


        <table class="table table-bordered mt-3">
            <thead class="table-primary text-center">
                <tr>
                    <th>NISN</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    @php
                        $bln = ["07","08","09","10","11","12","01","02","03","04","05","06"];
                    @endphp
                    @foreach ($bln as $b)
                        <th>{{ $b }}</th>
                    @endforeach
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td class="text-center">{{ $item['nisn'] }}</td>
                        <td>{{ $item['nama'] }}</td>
                        <td class="text-center">{{ $item['kelas'] }}</td>

                        @foreach ($item['status'] as $bulan => $sts)
                            <td class="text-center">
                                @if ($sts === 'lunas')
                                    <span class="badge bg-success">L</span>
                                @else
                                    <span class="badge bg-danger">X</span>
                                @endif
                            </td>
                        @endforeach
                        <td class="text-center"><a href="/admin/pembayaran/{{ $item['nisn'] }}" class="btn btn-secondary btn-sm">Bayar</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</x-layout>
