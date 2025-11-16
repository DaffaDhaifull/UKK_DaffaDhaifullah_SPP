<x-layout judul="DataKelas">
    <div class="card">
        <div class="row p-4 flex-column flex-md-row pb-0">
            <div class="d-md-flex justify-content-between align-items-center col-md-auto me-auto mt-0">
                <input type="search" class="form-control" placeholder="Cari Kelas ...">
            </div>
            <div class="d-md-flex justify-content-between align-items-center col-md-auto ms-auto mt-0">
                <x-modal modalId="tambahkelas" useButton="ya" buttonText="Tambah kelas" modalTitle="Tambah data kelas" actionForm="{{ route('kelas.store') }}">
                    <div class="mb-3">
                        <label class="form-label">Nama Kelas</label>
                        <input type="text" class="form-control" name="kls" placeholder="Masukan nama kelas">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kompetensi Keahlian</label>
                        <input type="text" class="form-control" name="keahlian" placeholder="Masukan kompetensi Keahlian">
                    </div>
                </x-modal>


                <x-modal modalId="editk"  buttonText="Edit" modalTitle="Ubah data kelas" actionForm="">
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nama Kelas</label>
                        <input type="text" class="form-control" id="kls" name="kls" placeholder="Masukan nama kelas">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kompetensi Keahlian</label>
                        <input type="text" class="form-control" id="keahlian" name="keahlian" placeholder="Masukan kompetensi keahlian">
                    </div>
                </x-modal>

                <x-modal modalId="deletek" buttonText="Edit" modalTitle="Hapus data kelas" actionForm="">
                    @method('DELETE')
                    <p>Anda yakin ingin menghapus data ini? tekan 'simpan' untuk menghapus data.</p>
                </x-modal>
            </div>
        </div>


        <table class="table mt-3">
            <thead class="table-primary text-center">
                <tr>
                    <th>No</th>
                    <th>Nama Kelas</th>
                    <th>Kompetensi Keahlian</th>
                    <th style="width: 150px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kelas as $k)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $k->nama_kelas }}</td>
                        <td class="text-center">{{ $k->kompetensi_keahlian }}</td>
                        <td class="d-flex gap-2">
                            <button value="{{ $k->id_kelas }}" onclick="ubah(this.value)" data-bs-toggle="modal" data-bs-target="#editk" class="btn btn-warning btn-sm">Edit</button>
                            <button value="{{ $k->id_kelas }}" onclick="hapus(this.value)" data-bs-toggle="modal" data-bs-target="#deletek" class="btn btn-danger btn-sm">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <script>
        async function ubah(id){
            const data = await window.data.get(`/admin/kelas/${id}`)
            const form = document.getElementById("form-editk")
            const nama = document.getElementById("kls")
            const jurusan = document.getElementById("keahlian")

            nama.value = data.nama_kelas
            jurusan.value = data.kompetensi_keahlian

            form.action = `/admin/kelas/${id}`
        }

        function hapus(id){
            const form = document.getElementById("form-deletek")

            form.action = `/admin/kelas/${id}`
        }
    </script>
</x-layout>
