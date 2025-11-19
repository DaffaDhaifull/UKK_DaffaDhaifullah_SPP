<x-layout judul="DataSiswa">
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


    <div class="card">
        <div class="row p-4 flex-column flex-md-row pb-0">
            <div class="d-md-flex justify-content-between align-items-center col-md-auto me-auto mt-0">
                <input type="search" class="form-control" placeholder="Cari Siswa ...">
            </div>
            <div class="d-md-flex justify-content-between align-items-center col-md-auto ms-auto mt-0">
                <x-modal modalId="tambahsiswa" useButton="ya" buttonText="Tambah Siswa" modalTitle="Tambah data Siswa" actionForm="{{ route('siswa.store') }}">
                    <div class="mb-3">
                        <label class="form-label">Nomor Induk Siswa Nasional</label>
                        <input type="text" class="form-control" name="nisn" placeholder="Masukan NISN">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Induk siswa</label>
                        <input type="text" class="form-control" name="nis" placeholder="Masukan NIS">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap Siswa</label>
                        <input type="text" class="form-control" name="nama" placeholder="Masukan nama siswa">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kelas Siswa</label>
                            <select class="form-select" name="idk">
                                @foreach ($kelas as $k)
                                    <option value="" hidden selected> - pilih kelas - </option>
                                    <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nominal SPP</label>
                            <select class="form-select" name="ids">
                                @foreach ($spp as $s)
                                    <option value="" hidden selected> - pilih spp - </option>
                                    <option value="{{ $s->id_spp }}">Rp. {{  number_format($s->nominal ?? 0, 0, ',', '.') }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" name="tlp" placeholder="Masukan nomor telepon">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Masukan passsword">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat Tinggal</label>
                        <textarea class="form-control" name="alamat"></textarea>
                    </div>
                </x-modal>


                <x-modal modalId="edits"  buttonText="Edit" modalTitle="Ubah data siswa" actionForm="">
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nomor Induk Siswa Nasional</label>
                        <input type="text" class="form-control" id="nisn" name="nisn" placeholder="Masukan NISN" disabled>
                        <input type="hidden" name="nisn" id="nisn_hidden">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Induk siswa</label>
                        <input type="text" class="form-control" id="nis" name="nis" placeholder="Masukan NIS">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap Siswa</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan nama siswa">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kelas Siswa</label>
                        <select class="form-select" id="idk" name="idk">
                            @foreach ($kelas as $k)
                                <option value="" hidden selected> - pilih kelas - </option>
                                <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nominal SPP</label>
                        <select class="form-select" id="ids" name="ids">
                            @foreach ($spp as $s)
                                <option value="" hidden selected> - pilih spp - </option>
                                <option value="{{ $s->id_spp }}" >Rp. {{  number_format($s->nominal ?? 0, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="tlp" name="tlp" placeholder="Masukan nomor telepon">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" id="pw" name="password" placeholder="•••••••••">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat Tinggal</label>
                        <textarea class="form-control" id="alamat" name="alamat"></textarea>
                    </div>
                </x-modal>

                <x-modal modalId="deletes" buttonText="Edit" modalTitle="Hapus data siswa" actionForm="">
                    @method('DELETE')
                    <p>Anda yakin ingin menghapus data ini? tekan 'simpan' untuk menghapus data.</p>
                </x-modal>
            </div>
        </div>


        <table class="table mt-3">
            <thead class="table-primary text-center">
                <tr>
                    <th>NISN</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Telepon</th>
                    <th>Kelas</th>
                    <th>SPP</th>
                    <th style="width: 150px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($siswa as $s)
                    <tr>
                        <td class="text-center">{{ $s->nisn }}</td>
                        <td class="text-center">{{ $s->nis }}</td>
                        <td class="ps-4">{{ $s->nama }}</td>
                        <td class="text-center">{{ $s->no_telepon }}</td>
                        <td class="text-center">{{ $s->kelas->nama_kelas }}</td>
                        <td class="text-center">Rp. {{ number_format($s->spp->nominal ?? 0, 0, ',', '.') }}</td>
                        <td class="d-flex gap-2">
                            <button value="{{ $s->nisn }}" onclick="ubah(this.value)" data-bs-toggle="modal" data-bs-target="#edits" class="btn btn-warning btn-sm">Edit</button>
                            <button value="{{ $s->nisn }}" onclick="hapus(this.value)" data-bs-toggle="modal" data-bs-target="#deletes" class="btn btn-danger btn-sm">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <script>
        async function ubah(id){
            const data = await window.data.get(`/admin/siswa/${id}`)
            const form = document.getElementById("form-edits")

            const nisn = document.getElementById("nisn")
            const nisnHide = document.getElementById("nisn_hidden")
            const nis = document.getElementById("nis")
            const nama = document.getElementById("nama")
            const tlp = document.getElementById("tlp")
            const idk = document.getElementById("idk")
            const ids = document.getElementById("ids")
            const alamat = document.getElementById("alamat")

            nisn.value = data.nisn
            nisnHide.value = data.nisn
            nis.value = data.nis
            nama.value = data.nama
            tlp.value = data.no_telepon
            idk.value = data.id_kelas
            ids.value = data.id_spp
            alamat.value = data.alamat

            form.action = `/admin/siswa/${id}`
        }

        function hapus(id){
            const form = document.getElementById("form-deletes")

            form.action = `/admin/siswa/${id}`
        }
    </script>
</x-layout>
