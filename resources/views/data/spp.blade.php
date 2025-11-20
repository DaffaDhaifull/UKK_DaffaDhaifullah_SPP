<x-layout judul="CekSPP | SPP">
    <h4 class="mb-1">Data SPP</h4>
    <p>Menampilkan seluruh data spp yang ada di sekolah ini.</p>

    @if (session('success'))
        <div class="alert alert-success" role="alert" id="s_alert">
            <strong>{{ session('success') }}</strong>
        </div>

        <script>
            setTimeout(function() {
                var alertElement = document.getElementById('s_alert');
                alertElement.remove('show');
            }, 3000);
        </script>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger" role="alert" id="error_alert">
            <strong>Oops! Ada kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

        <script>
            setTimeout(function() {
                var alertElement = document.getElementById('error_alert');
                alertElement.remove('show');
            }, 5000);
        </script>
    @endif



    <div class="card mt-4">
        <div class="row p-4 flex-column flex-md-row pb-0">
            <div class="d-md-flex justify-content-between align-items-center col-md-auto me-auto mt-0">
                <input type="search" class="form-control" placeholder="Cari tahun ...">
            </div>
            <div class="d-md-flex justify-content-between align-items-center col-md-auto ms-auto mt-0">
                <x-modal modalId="tambahspp" useButton="ya" buttonText="Tambah SPP" modalTitle="Tambah data SPP" actionForm="{{ route('spp.store') }}">
                    <div class="mb-3">
                        <label class="form-label">Tahun Masuk</label>
                        <input type="year" class="form-control" name="tahun" placeholder="Masukan tahun">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nominal</label>
                        <input type="text" class="form-control" name="nominal" placeholder="Masukan nominal">
                    </div>
                </x-modal>


                <x-modal modalId="editsp"  buttonText="Edit" modalTitle="Ubah data SPP" actionForm="">
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Tahun Masuk</label>
                        <input type="year" class="form-control" id="th" name="tahun" placeholder="Masukan tahun">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nominal</label>
                        <input type="text" class="form-control" id="nomi" name="nominal" placeholder="Masukan nominal">
                    </div>
                </x-modal>

                <x-modal modalId="deletesp" buttonText="Edit" modalTitle="Hapus data SPP" actionForm="">
                    @method('DELETE')
                    <p>Anda yakin ingin menghapus data ini? tekan 'simpan' untuk menghapus data.</p>
                </x-modal>
            </div>
        </div>


        <table class="table mt-3">
            <thead class="table-primary text-center">
                <tr>
                    <th>No</th>
                    <th>Tahun</th>
                    <th>Nominal</th>
                    <th style="width: 150px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($spp as $p)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $p->tahun }}</td>
                        <td class="text-center">Rp. {{ number_format($p->nominal, 0, ',', '.') }}</td>
                        <td class="d-flex gap-2">
                            <button value="{{ $p->id_spp }}" onclick="ubah(this.value)" data-bs-toggle="modal" data-bs-target="#editsp" class="btn btn-warning btn-sm">Edit</button>
                            <button value="{{ $p->id_spp }}" onclick="hapus(this.value)" data-bs-toggle="modal" data-bs-target="#deletesp" class="btn btn-danger btn-sm">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <script>
        async function ubah(id){
            const data = await window.data.get(`/admin/spp/${id}`)
            const form = document.getElementById("form-editsp")
            const taun = document.getElementById("th")
            const nominal = document.getElementById("nomi")

            taun.value = data.tahun
            nominal.value = data.nominal

            form.action = `/admin/spp/${id}`
        }

        function hapus(id){
            const form = document.getElementById("form-deletesp")

            form.action = `/admin/spp/${id}`
        }
    </script>
</x-layout>
