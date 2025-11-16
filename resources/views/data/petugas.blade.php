<x-layout judul="DataPetugas">
    <div class="card">
        <div class="row p-4 flex-column flex-md-row pb-0">
            <div class="d-md-flex justify-content-between align-items-center col-md-auto me-auto mt-0">
                <input type="search" class="form-control" placeholder="Cari petugas ...">
            </div>
            <div class="d-md-flex justify-content-between align-items-center col-md-auto ms-auto mt-0">
                <x-modal modalId="tambahpetugas" useButton="ya" buttonText="Tambah Petugas" modalTitle="Tambah data petugas" actionForm="{{ route('petugas.store') }}">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama" placeholder="Masukan Nama Lengkap">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" placeholder="Masukan username">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Masukan Password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hak Akses</label>
                        <select class="form-select" name="level">
                            <option value="admin">Admin</option>
                            <option value="petugas">Petugas</option>
                        </select>
                    </div>
                </x-modal>


                <x-modal modalId="editp"  buttonText="Edit" modalTitle="Ubah data petugas" actionForm="">
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan Nama Lengkap">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukan username">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="•••••••••">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hak Akses</label>
                        <select class="form-select" name="level" id="level">
                            <option value="admin">Admin</option>
                            <option value="petugas">Petugas</option>
                        </select>
                    </div>
                </x-modal>

                <x-modal modalId="deletep" buttonText="Edit" modalTitle="Hapus data petugas" actionForm="/admin/petugas/">
                    @method('DELETE')
                    <p>Anda yakin ingin menghapus data ini? tekan 'simpan' untuk menghapus data.</p>
                </x-modal>
            </div>
        </div>


        <table class="table mt-3">
            <thead class="table-primary text-center">
                <tr>
                    <th>No</th>
                    <th>Nama Petugas</th>
                    <th>Username</th>
                    <th>Level</th>
                    <th style="width: 150px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($petugas as $p)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="ps-4">{{ $p->nama_petugas }}</td>
                        <td class="text-center">{{ $p->username }}</td>
                        <td class="text-center">{{ $p->level }}</td>
                        <td class="d-flex gap-2">
                            <button value="{{ $p->id_petugas }}" onclick="ubah(this.value)" data-bs-toggle="modal" data-bs-target="#editp" class="btn btn-warning btn-sm">Edit</button>
                            <button value="{{ $p->id_petugas }}" onclick="hapus(this.value)" data-bs-toggle="modal" data-bs-target="#deletep" class="btn btn-danger btn-sm">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <script>
        async function ubah(id){
            const data = await window.data.get(`/admin/petugas/${id}`)
            const form = document.getElementById("form-editp")
            const nama = document.getElementById("nama")
            const user = document.getElementById("username")
            const level = document.getElementById("level")

            nama.value = data.nama_petugas
            user.value = data.username
            level.value = data.level

            form.action = `/admin/update/${id}`
        }

        function hapus(id){
            const form = document.getElementById("form-deletep")

            form.action = `/admin/petugas/${id}`
        }
    </script>
</x-layout>
