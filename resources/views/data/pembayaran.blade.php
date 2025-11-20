<x-layout judul="CekSPP | Pembayaran">
    <div class="card">
        <div class="row p-4 flex-column flex-md-row pb-0">
            <div class="d-md-flex justify-content-between align-items-center col-md-auto me-auto mt-0">
                <input type="search" class="form-control" placeholder="Cari siswa ...">
            </div>
            <div class="d-md-flex justify-content-between align-items-center col-md-auto ms-auto mt-0">

                <x-modal modalId="deletep" buttonText="Edit" modalTitle="Hapus data petugas" actionForm="">
                    @method('DELETE')
                    <p>Anda yakin ingin menghapus data ini? tekan 'simpan' untuk menghapus data.</p>
                </x-modal>
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
