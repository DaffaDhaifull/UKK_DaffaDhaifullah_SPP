<x-layout judul="CekSPP | Petugas">
    <h4 class="mb-1">Data Petugas</h4>
    <p>Menampilkan data semua petugas yang terdaftar di aplikasi</p>

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
                <input type="search" id="searchPetugas" class="form-control" placeholder="Cari petugas ...">
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
                            <option value="" selected hidden> -- Pilih level -- </option>
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

                <x-modal modalId="deletep" buttonText="Edit" modalTitle="Hapus data petugas" actionForm="">
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
            <tbody id="tabelPetugas">
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
        document.getElementById('searchPetugas').addEventListener('keyup', function () {
            let keyword = this.value.toLowerCase();
            let rows = document.querySelectorAll('#tabelPetugas tr');

            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(keyword) ? "" : "none";
            });
        });


        async function ubah(id){
            const data = await window.data.get(`/admin/petugas/${id}`)
            const form = document.getElementById("form-editp")
            const nama = document.getElementById("nama")
            const user = document.getElementById("username")
            const level = document.getElementById("level")

            nama.value = data.nama_petugas
            user.value = data.username
            level.value = data.level

            form.action = `/admin/petugas/${id}`
        }

        function hapus(id){
            const form = document.getElementById("form-deletep")

            form.action = `/admin/petugas/${id}`
        }
    </script>
</x-layout>
