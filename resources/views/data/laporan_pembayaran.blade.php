<x-layout judul="CekSPP | Pembayaran">
    <div class="card">
        <form class="row p-3" action="{{ route('laporan.index') }}" method="get">@csrf
            <div class="col-md-5">
                <label class="form-label text-capitalize">Pilih kelas</label><br>
                <select class="form-select select2" id="kelas_ab" name="id_kelas">
                    <option value="" hidden>- Pilih kelas -</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id_kelas }}"
                            {{ request('id_kelas') == $k->id_kelas ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-7 d-block align-items-end pt-4">
                <button type="submit" class="btn btn-primary me-2 mt-2">Cari</button>
                <button type="button" onclick="this.form.reset(); window.location='';" class="btn btn-outline-primary mt-2 me-2">
                    Reset
                </button>
                <a href="{{ route('laporan.cetak', ['id_kelas' => request('id_kelas')]) }}"
                    class="btn btn-danger mt-2" target="_blank">
                    Cetak PDF
                </a>
            </div>
        </form>

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
                    <th>Lunas</th>
                    <th>Belum</th>
                </tr>
            </thead>

            <tbody>
                @if(Request::has('id_kelas'))
                    @foreach ($data as $item)

                        @php
                            $countLunas = collect($item['status'])->filter(fn($v) => $v === 'lunas')->count();
                            $countBelum = collect($item['status'])->filter(fn($v) => $v !== 'lunas')->count();
                        @endphp

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

                            <td class="text-center fw-bold">{{ $countLunas }}</td>
                            <td class="text-center fw-bold">{{ $countBelum }}</td>
                        </tr>
                    @endforeach

                @else
                    <tr>
                        <td colspan="{{ 3 + count($bln) + 2 }}" class="text-center">
                            Pilih kelas terlebih dahulu
                        </td>
                    </tr>

                @endif

            </tbody>
        </table>

    </div>
</x-layout>
