<x-layout judul="CekSPP | Pembayaran">
@php
    $prefix = request()->routeIs('admin.*') ? 'admin.' : 'petugas.';
@endphp

    <div class="card p-4">
        <h4>Pembayaran SPP</h4>
        <p>Tambahkan pembayaran baru dengan pilih bulan yang ingin di bayar</p>

        <form class="px-4 mx-4 mt-3" action="{{ route($prefix.'pembayaran.store') }}" method="post">
            @csrf

            <input type="hidden" name="nisn" value="{{ $siswa->nisn }}">
            <input type="hidden" name="petugas" value="{{ Auth::guard('petugas')->user()->id_petugas}}">
            <input type="hidden" name="tgl" value="{{ date('Y-m-d') }}">
            <input type="hidden" name="spp" value="{{ $siswa->id_spp }}">
            <input type="hidden" name="jumlah" value="{{ $siswa->spp->nominal }}">
            <input type="hidden" name="tahun" value="{{ $siswa->spp->tahun }}">

            <div class="mb-3">
                <label for="nama" class="for-label">Nomor Induk Siswa Nasional (NISN)</label>
                <input type="text" class="form-control" value="{{ $siswa->nisn }}" disabled>
            </div>
            <div class="mb-3">
                <label for="nama" class="for-label">Nama Siswa</label>
                <input type="text" class="form-control" value="{{ $siswa->nama }}" disabled>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="nama" class="for-label">Tanggal pembayaran</label>
                    <input type="date" class="form-control" value="{{ date('Y-m-d') }}" disabled>
                </div>
                <div class="col-md-6">
                    <label for="nama" class="for-label">Nominal SPP</label>
                    <input type="text" class="form-control" value="Rp. {{ number_format($siswa->spp->nominal ?? 0, 0, ',', '.')  }}" disabled>
                </div>
            </div>
            <div class="row mt-4">

                @foreach($status as $bulan => $ket)
                    @php
                        $id = strtolower($bulan);
                        $isLunas = $ket === 'lunas';
                    @endphp

                    <div class="col-md-3 p-2" style="height: 75px;">

                        <input type="checkbox" class="btn-check bulan-check" autocomplete="off"
                            id="{{ $id }}" name="bulan[]" value="{{ $bulan }}" {{ $isLunas ? 'checked disabled' : '' }}>

                        <label class="btn w-100 h-75 fw-bold d-flex justify-content-center align-items-center
                            {{ $isLunas ? 'btn-success' : 'btn-outline-secondary' }}"
                            id="label-{{ $id }}" for="{{ $id }}"> {{ $bulan }} </label>

                    </div>
                @endforeach

            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route($prefix.'pembayaran.index') }}" class="btn btn-outline-secondary">Batal</a>


                <button type="submit" class="btn btn-primary px-4"  id="btnSimpan">Simpan</button>
            </div>
        </form>
    </div>

    <script>
        const btn = document.getElementById("btnSimpan");
        btn.onclick = () => confirm('Bulan: ' + Array.from(document.querySelectorAll('.bulan-check:checked:not(:disabled)')).map(x=>x.value));


        document.querySelectorAll(".bulan-check").forEach(cb => {
            
            cb.addEventListener("change", function() {
                const label = document.getElementById("label-" + this.id);

                if (this.disabled) return; // bulan lunas tidak boleh berubah

                if (this.checked) {
                    label.classList.remove("btn-outline-secondary");
                    label.classList.add("btn-secondary");
                } else {
                    label.classList.add("btn-outline-secondary");
                    label.classList.remove("btn-secondary");
                }
            });

        });
    </script>

</x-layout>
